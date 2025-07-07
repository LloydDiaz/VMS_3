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
        Schema::create('geography', function (Blueprint $table) {
            $table->id();
            $table->string('psgccode')->default('');
            $table->string('name')->default('');
            $table->string('level')->default('');
            $table->string('region')->default('');
            $table->string('province')->default('');
            $table->string('municipality')->default('');
            $table->string('islandGroup')->default('');
            $table->string('status')->default('Active');
            $table->integer('enteredBy')->default(2);
            $table->date('timestamp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('geography');
    }
};
