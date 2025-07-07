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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tct_number')->unique();
            $table->date('tct_date');
            $table->string('tct_time')->nullable();
            $table->text('fname')->nullable();
            $table->text('lname')->nullable();
            $table->text('mname')->nullable();
            $table->text('xname')->nullable();
            $table->date('dob')->nullable();
            $table->text('street_address')->nullable();
            $table->string('region')->nullable();
            $table->string('province')->nullable();
            $table->string('municipality')->nullable();
            $table->string('barangay')->nullable();
            $table->text('description')->nullable();
            $table->text('violation_details')->nullable();

            // $table->text('plate_number')->nullable();
            // $table->string('place_of_citation')->nullable();
            // $table->string('mv_type')->nullable();
            // $table->string('engine_number')->nullable();
            // $table->string('chasis_number')->nullable();
            // $table->string('mv_reg_number')->nullable();
            // $table->string('con_item')->nullable();
            // $table->string('license_number')->nullable();
            // $table->string('contact_number')->nullable();
            // $table->string('owner_vehicle')->nullable();
            
            $table->string('or_number')->nullable();
            $table->string('amount_pay')->nullable();
            $table->string('date_pay')->nullable();
            $table->string('ticket_by')->nullable();
            $table->string('encoded_by')->nullable();
            $table->string('status')->default('Unpaid');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
