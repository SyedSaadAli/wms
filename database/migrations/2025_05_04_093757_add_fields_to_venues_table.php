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
        Schema::table('venues', function (Blueprint $table) {
            $table->string('event_type')->nullable()->after('price');
            $table->integer('guest_capacity')->nullable()->after('event_type');
            $table->string('ambience')->nullable()->after('guest_capacity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('venues', function (Blueprint $table) {
            $table->dropColumn(['event_type', 'guest_capacity', 'ambience']);
        });
    }
};
