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
        Schema::create('ticket_ranges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->year('year'); // ← Ticket year
            $table->unsignedInteger('start_number');
            $table->unsignedInteger('end_number');
            $table->unsignedInteger('current_number')->nullable(); // last issued
            $table->timestamps();

            $table->unique(['user_id', 'year', 'start_number']); // one range per year/user/start
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_ranges');
    }
};
