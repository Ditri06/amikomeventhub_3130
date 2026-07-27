<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_tiers', function (Blueprint $table) {
            $table->id();

            // Event yang memiliki tahap harga ini
            $table->foreignId('event_id')
                ->constrained('events')
                ->cascadeOnDelete();

            // Nama tahap harga
            // Contoh: Early Bird, Presale 1, Regular
            $table->string('name');

            // Harga tiket pada tahap ini
            $table->integer('price');

            // Periode mulai dan berakhir
            $table->dateTime('start_date');
            $table->dateTime('end_date');

            // Urutan tahap harga
            // Contoh: Early Bird = 1, Presale 1 = 2, Regular = 3
            $table->integer('sort_order')->default(1);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_tiers');
    }
};
