<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel events
            $table->foreignId('event_id')
                ->constrained('events')
                ->cascadeOnDelete();

            // Relasi ke tabel users
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('partner_id')
                ->constrained('partners')
                ->cascadeOnDelete();

            // Rating 1 sampai 5 bintang
            $table->unsignedTinyInteger('rating');

            // Isi ulasan/testimoni
            $table->text('review');

            $table->timestamps();

            // Satu user hanya dapat memberikan satu review
            // untuk satu event
            $table->unique(['event_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
