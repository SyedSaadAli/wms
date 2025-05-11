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
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User who made the booking
            $table->foreignId('venue_id')->constrained()->onDelete('cascade'); // Venue being booked
            $table->date('booking_date'); // Date of the booking
            $table->integer('guest_count'); // Number of guests
            $table->time('event_start_time'); // Event start time
            $table->time('event_end_time'); // Event end time
            $table->text('special_requests')->nullable(); // Optional special requests
            $table->timestamps();
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
