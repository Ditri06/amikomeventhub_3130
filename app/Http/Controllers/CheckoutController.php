<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use App\Models\Coupon;
use App\Models\TicketTier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout
     */
      public function create(Event $event)
    {
        if (!Auth::check()) {
            session(['checkout_event_id' => $event->id]);

            return redirect()->route('google.login');
        }

        $categories = \App\Models\Category::all();

        $coupons = Coupon::where('is_active', true)->get();

        $activeTicketTier = TicketTier::where('event_id', $event->id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderBy('sort_order')
            ->first();

        $eventPrice = $activeTicketTier
            ? $activeTicketTier->price
            : $event->price;

        $serviceFee = $eventPrice > 0 ? 5000 : 0;

        return view('checkout.create', compact(
            'event',
            'categories',
            'coupons',
            'activeTicketTier',
            'eventPrice',
            'serviceFee'
        ));
    }

    /**
     * Memproses checkout
     */
    public function store(Request $request, Event $event)
    {
        // =====================================================
        // 1. VALIDASI DATA PEMESAN
        // =====================================================

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'coupon_code' => 'nullable|string|max:50',
        ]);


        // =====================================================
        // 2. CEK STOK TIKET
        // =====================================================

        if ($event->stock <= 0) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Mohon maaf, tiket untuk acara ini sudah habis.'
                );
        }


        // =====================================================
        // 3. AMBIL HARGA TICKET TIER AKTIF
        // =====================================================

        $activeTicketTier = TicketTier::where('event_id', $event->id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderBy('sort_order')
            ->first();

        // Jika ada Ticket Tier aktif, gunakan harga tier.
        // Jika tidak ada, gunakan harga event lama.
        $eventPrice = $activeTicketTier
            ? $activeTicketTier->price
            : $event->price;

        // Biaya layanan Rp 5.000 hanya untuk event berbayar
        $serviceFee = $eventPrice > 0 ? 5000 : 0;

        // Harga sebelum diskon
        $subtotal = $eventPrice + $serviceFee;


        // =====================================================
        // 4. INISIALISASI KUPON
        // =====================================================

        $coupon = null;
        $discountAmount = 0;


        // =====================================================
        // 5. VALIDASI DAN HITUNG KUPON
        // =====================================================

        if (
            $request->filled('coupon_code') &&
            $eventPrice > 0
        ) {

            // Cari kupon berdasarkan kode
            $coupon = Coupon::where(
                'code',
                strtoupper(trim($request->coupon_code))
            )->first();


            // -------------------------------------------------
            // Kupon tidak ditemukan
            // -------------------------------------------------

            if (!$coupon) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Kode kupon tidak ditemukan.'
                    );
            }


            // -------------------------------------------------
            // Cek status aktif
            // -------------------------------------------------

            if (!$coupon->is_active) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Kupon yang digunakan sudah tidak aktif.'
                    );
            }


            // -------------------------------------------------
            // Cek tanggal mulai kupon
            // -------------------------------------------------

            if (
                $coupon->start_date &&
                now()->lt($coupon->start_date)
            ) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Kupon belum mulai berlaku.'
                    );
            }


            // -------------------------------------------------
            // Cek tanggal berakhir kupon
            // -------------------------------------------------

            if (
                $coupon->end_date &&
                now()->gt($coupon->end_date)
            ) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Kupon sudah tidak berlaku.'
                    );
            }


            // -------------------------------------------------
            // Cek batas maksimal penggunaan
            // -------------------------------------------------

            if (
                $coupon->max_usage !== null &&
                $coupon->used_count >= $coupon->max_usage
            ) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Kuota penggunaan kupon sudah habis.'
                    );
            }


            // -------------------------------------------------
            // Hitung diskon persentase
            // -------------------------------------------------

            if ($coupon->discount_type === 'percentage') {

                // Maksimal diskon 100%
                $percentage = min(
                    $coupon->discount_value,
                    100
                );

                $discountAmount = $subtotal * $percentage / 100;
            }


            // -------------------------------------------------
            // Hitung diskon nominal
            // -------------------------------------------------

            elseif ($coupon->discount_type === 'fixed') {

                $discountAmount = $coupon->discount_value;
            }


            // -------------------------------------------------
            // Pastikan diskon tidak lebih besar dari subtotal
            // -------------------------------------------------

            $discountAmount = min(
                $discountAmount,
                $subtotal
            );

            // Pastikan nilai diskon berupa angka bulat
            $discountAmount = (int) $discountAmount;
        }


        // =====================================================
        // 6. HITUNG TOTAL AKHIR
        // =====================================================

        $totalPrice = $subtotal - $discountAmount;

        // Pastikan total tidak menjadi negatif
        $totalPrice = max(
            0,
            $totalPrice
        );


        // =====================================================
        // 7. GENERATE ORDER ID
        // =====================================================

        $orderId = 'TRX-' . time() . '-' . Str::random(5);


        // =====================================================
        // 8. EVENT GRATIS
        // =====================================================

        if ($eventPrice == 0) {

            $transaction = Transaction::create([
                'event_id' => $event->id,
                'coupon_id' => null,
                'order_id' => $orderId,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'total_price' => 0,
                'discount_amount' => 0,
                'status' => 'success',
                'snap_token' => null,
            ]);


            // Kurangi stok tiket
            $event->decrement('stock');


            // Event gratis tidak menggunakan kupon
            // sehingga used_count tidak berubah


            // Langsung ke halaman sukses
            return redirect()->route(
                'checkout.success',
                $transaction->order_id
            );
        }


        // =====================================================
        // 9. EVENT BERBAYAR
        // =====================================================

        $transaction = Transaction::create([
            'event_id' => $event->id,
            'coupon_id' => $coupon ? $coupon->id : null,
            'order_id' => $orderId,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total_price' => $totalPrice,
            'discount_amount' => $discountAmount,
            'status' => 'pending',
            'snap_token' => null,
        ]);


        // =====================================================
        // 10. KONFIGURASI MIDTRANS
        // =====================================================

        \Midtrans\Config::$serverKey = env(
            'MIDTRANS_SERVER_KEY'
        );

        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;


        // =====================================================
        // 11. DATA TRANSAKSI MIDTRANS
        // =====================================================

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $totalPrice,
            ],

            'customer_details' => [
                'first_name' => $request->customer_name,
                'email' => $request->customer_email,
                'phone' => $request->customer_phone,
            ],
        ];


        // =====================================================
        // 12. GENERATE SNAP TOKEN
        // =====================================================

        try {

            $snapToken = \Midtrans\Snap::getSnapToken(
                $params
            );


            // Simpan Snap Token
            $transaction->update([
                'snap_token' => $snapToken
            ]);


            // Arahkan ke halaman pembayaran
            return redirect()->route(
                'checkout.payment',
                $transaction->order_id
            );

        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Gagal memproses pembayaran: '
                    . $e->getMessage()
                );
        }
    }


    /**
     * Menampilkan halaman pembayaran
     */
    public function payment($order_id)
    {
        $categories = \App\Models\Category::all();

        $transaction = Transaction::with([
            'event',
            'coupon'
        ])
            ->where('order_id', $order_id)
            ->firstOrFail();

        return view(
            'checkout.payment',
            compact(
                'transaction',
                'categories'
            )
        );
    }


    /**
     * Menampilkan halaman sukses
     * sekaligus memproses pembayaran Midtrans
     */
    public function success($order_id)
    {
        $categories = \App\Models\Category::all();

        $transaction = Transaction::with([
            'event',
            'coupon'
        ])
            ->where('order_id', $order_id)
            ->firstOrFail();


        // =====================================================
        // EVENT GRATIS
        // =====================================================

        if (
            $transaction->total_price == 0 &&
            $transaction->status === 'success'
        ) {

            return view(
                'checkout.success',
                compact(
                    'transaction',
                    'categories'
                )
            );
        }


        // =====================================================
        // KONFIGURASI MIDTRANS
        // =====================================================

        \Midtrans\Config::$serverKey = env(
            'MIDTRANS_SERVER_KEY'
        );

        \Midtrans\Config::$isProduction = false;


        try {

            // =================================================
            // CEK STATUS PEMBAYARAN KE MIDTRANS
            // =================================================

            $midtransStatus = \Midtrans\Transaction::status(
                $order_id
            );


            // =================================================
            // JIKA PEMBAYARAN BERHASIL
            // =================================================

            if (
                in_array(
                    $midtransStatus->transaction_status,
                    [
                        'capture',
                        'settlement'
                    ]
                )
            ) {

                // Cegah stok dan kupon berkurang dua kali
                if (
                    $transaction->status !== 'success'
                ) {

                    // =========================================
                    // CEK STOK KEMBALI
                    // =========================================

                    if (
                        $transaction->event->stock <= 0
                    ) {

                        return redirect()
                            ->route('home')
                            ->with(
                                'error',
                                'Mohon maaf, stok tiket sudah habis.'
                            );
                    }


                    // =========================================
                    // UPDATE STATUS TRANSAKSI
                    // =========================================

                    $transaction->update([
                        'status' => 'success'
                    ]);


                    // =========================================
                    // KURANGI STOK EVENT
                    // =========================================

                    $transaction->event->decrement(
                        'stock'
                    );


                    // =========================================
                    // TAMBAH JUMLAH PENGGUNAAN KUPON
                    // =========================================

                    if (
                        $transaction->coupon_id
                    ) {

                        $coupon = Coupon::find(
                            $transaction->coupon_id
                        );

                        if ($coupon) {

                            $coupon->increment(
                                'used_count'
                            );
                        }
                    }
                }
            }


        } catch (\Exception $e) {

            return redirect()
                ->route('home')
                ->with(
                    'error',
                    'Transaksi tidak ditemukan atau gagal diproses oleh sistem pembayaran.'
                );
        }


        // =====================================================
        // TAMPILKAN HALAMAN SUKSES
        // =====================================================

        return view(
            'checkout.success',
            compact(
                'transaction',
                'categories'
            )
        );
    }
}
