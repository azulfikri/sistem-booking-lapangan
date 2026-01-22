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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('field_id')->constrained('fields')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();

            $table->string('booking_code', 50)->unique();

            // MIDTRANS (Optional - untuk future upgrade)
            $table->string('snap_token')->nullable();
            $table->string('midtrans_transaction_id')->nullable();
            $table->string('midtrans_payment_type')->nullable();

            // WAKTU BOOKING
            $table->date('booking_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('duration');
            // GUEST INFO (WAJIB untuk guest booking)
            $table->string('guest_name'); // Nama customer
            $table->string('guest_phone', 20); // No HP customer
            $table->string('guest_email'); // Email customer

            // FINANSIAL
            $table->decimal('total_price', 10, 2);
            $table->enum('payment_method', ['transfer', 'cash', 'midtrans'])->default('transfer');

            // STATUS PEMBAYARAN (KHUSUS)
            $table->enum('payment_status', [
                'unpaid',
                'pending',
                'paid',
                'expired',
                'failed'
            ])->default('unpaid');

            // STATUS BOOKING (KHUSUS)
            $table->enum('booking_status', [
                'pending',
                'confirmed',
                'cancelled',
                'completed'
            ])->default('pending');

            $table->text('notes')->nullable();
            $table->string('payment_proof')->nullable();

            $table->timestamps();

            // INDEX untuk performa query
            $table->index(['booking_code', 'booking_date', 'booking_status', 'payment_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
