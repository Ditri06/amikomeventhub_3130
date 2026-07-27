<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Dashboard') - AmikomEventHub
    </title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 flex min-h-screen">

    <!-- ====================================================== -->
    <!-- SIDEBAR -->
    <!-- ====================================================== -->

    <aside class="w-64 bg-indigo-900 text-indigo-100 flex flex-col p-6 space-y-8 sticky top-0 h-screen">

        <!-- Logo -->
        <div class="flex items-center gap-3">

            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-900 font-bold text-xl">
                AH
            </div>

            <span class="text-xl font-bold text-white tracking-tight">
                AmikomEventHub
            </span>

        </div>


        <!-- ====================================================== -->
        <!-- NAVIGATION -->
        <!-- ====================================================== -->

        <nav class="flex-1 space-y-2">

            <p class="text-[10px] font-bold uppercase tracking-widest text-indigo-400 mb-4 px-2">
                Main Menu
            </p>


            <!-- ================================================== -->
            <!-- DASHBOARD -->
            <!-- ================================================== -->

            @if(auth()->user()->role === 'partner')

                <!-- Dashboard Partner -->

                <a href="{{ route('partner.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('partner.dashboard') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">

                    <svg class="w-5 h-5 {{ request()->routeIs('partner.dashboard') ? 'text-indigo-300' : 'text-indigo-400' }}"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>

                    </svg>

                    Dashboard

                </a>

            @else

                <!-- Dashboard Admin -->

                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">

                    <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-indigo-300' : 'text-indigo-400' }}"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>

                    </svg>

                    Dashboard

                </a>

            @endif


            <!-- ================================================== -->
            <!-- KELOLA EVENT -->
            <!-- ================================================== -->

            @if(auth()->user()->role === 'partner')

                <!-- Event Partner -->

                <a href="{{ route('partner.events.index') }}"
                   class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('partner.events.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">

                    <svg class="w-5 h-5 {{ request()->routeIs('partner.events.*') ? 'text-indigo-300' : 'text-indigo-400' }}"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h14a2 2 0 002-2V7">
                        </path>

                    </svg>

                    Kelola Event

                </a>

            @else

                <!-- Event Admin -->

                <a href="{{ route('admin.events.index') }}"
                   class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.events.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">

                    <svg class="w-5 h-5 {{ request()->routeIs('admin.events.*') ? 'text-indigo-300' : 'text-indigo-400' }}"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h14a2 2 0 002-2V7">
                        </path>

                    </svg>

                    Kelola Event

                </a>

            @endif


            <!-- ================================================== -->
            <!-- MENU KHUSUS ADMIN -->
            <!-- ================================================== -->

            @if(auth()->user()->role === 'admin')

                <!-- Kelola Kategori -->

                <a href="{{ route('admin.categories.index') }}"
                   class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.categories.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">

                    <svg class="w-5 h-5 {{ request()->routeIs('admin.categories.*') ? 'text-indigo-300' : 'text-indigo-400' }}"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                        </path>

                    </svg>

                    Kelola Kategori

                </a>


                <!-- Kelola Partner -->

                <a href="{{ route('admin.partners.index') }}"
                   class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.partners.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">

                    <svg class="w-5 h-5 {{ request()->routeIs('admin.partners.*') ? 'text-indigo-300' : 'text-indigo-400' }}"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>

                    </svg>

                    Kelola Partner

                </a>

                 <!-- Kelola Kupon -->

                <a href="{{ route('admin.coupons.index') }}"
                   class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.coupons.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">

                    <svg class="w-5 h-5 {{ request()->routeIs('admin.coupons.*') ? 'text-indigo-300' : 'text-indigo-400' }}"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M15 5h4a2 2 0 012 2v2a2 2 0 01-2 2h-4v2h4a2 2 0 012 2v2a2 2 0 01-2 2h-4v-2h-2v2H5a2 2 0 01-2-2v-2a2 2 0 012-2h4v-2H5a2 2 0 01-2-2V7a2 2 0 012-2h6v2H5v2h6v2h2V9h2V7h-2V5z">
                        </path>

                    </svg>

                    Kelola Kupon

                </a>

                <!-- Kelola Ticket Tier -->
                <a href="{{ route('admin.ticket-tiers.index') }}"
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.ticket-tiers.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">

                    <svg class="w-5 h-5 {{ request()->routeIs('admin.ticket-tiers.*') ? 'text-indigo-300' : 'text-indigo-400' }}"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2zm3-5h2m2 0h2m2 0h2">
                        </path>

                    </svg>

                    Kelola Ticket Tier

                </a>


            @endif


            <!-- ================================================== -->
            <!-- LAPORAN TRANSAKSI -->
            <!-- ================================================== -->

            @if(auth()->user()->role === 'partner')

                <!-- Transaksi Partner -->

                <a href="{{ route('partner.transactions.index') }}"
                   class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('partner.transactions.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">

                    <svg class="w-5 h-5 {{ request()->routeIs('partner.transactions.*') ? 'text-indigo-300' : 'text-indigo-400' }}"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>

                    </svg>

                    Laporan Transaksi

                </a>

            @else

                <!-- Transaksi Admin -->

                <a href="{{ route('admin.transactions.index') }}"
                   class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.transactions.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">

                    <svg class="w-5 h-5 {{ request()->routeIs('admin.transactions.*') ? 'text-indigo-300' : 'text-indigo-400' }}"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>

                    </svg>

                    Laporan Transaksi

                </a>

            @endif

        </nav>


        <!-- ====================================================== -->
        <!-- LOGOUT -->
        <!-- ====================================================== -->

        <div class="pt-6 border-t border-indigo-800">

            <form action="{{ route('admin.logout') }}" method="POST">

                @csrf

                <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 text-indigo-300 hover:text-white transition font-medium text-left">

                    <svg class="w-5 h-5"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>

                    </svg>

                    Keluar

                </button>

            </form>

        </div>

    </aside>


    <!-- ====================================================== -->
    <!-- MAIN CONTENT -->
    <!-- ====================================================== -->

    <main class="flex-1 p-10 overflow-y-auto w-full">

        <!-- Header -->

        <header class="flex justify-between items-center mb-10 w-full col-span-full">

            <div>

                <h1 class="text-3xl font-black">
                    @yield('page_title', 'Dashboard')
                </h1>

                <p class="text-slate-500 font-medium">
                    @yield('page_subtitle', 'Selamat datang kembali!')
                </p>

            </div>


            <!-- User Info -->

            <div class="flex items-center gap-4">

                <div class="text-right hidden md:block">

                    <p class="font-bold">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-xs text-slate-400">
                        {{ ucfirst(auth()->user()->role) }}
                    </p>

                </div>

                <div class="w-12 h-12 bg-white rounded-2xl shadow-sm border flex items-center justify-center p-1">

                    <img
                        src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=6366f1&color=fff"
                        class="rounded-xl"
                        alt="User Avatar"
                    >

                </div>

            </div>

        </header>


        <!-- Success Message -->

        @if(session('success'))

            <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6 font-bold text-sm">

                {{ session('success') }}

            </div>

        @endif


        <!-- Content -->

        @yield('content')

    </main>

      @stack('scripts')
</body>
</html>
