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
        Schema::create('freelancers', function (Blueprint $table) {
            $table->foreignId('id')->constrained('users')->primary();
            $table->string('freelancer_profession')->nullable();
            $table->text('freelancer_description')->nullable();
            $table->string('freelancer_experience')->nullable();
            $table->string('freelancer_city')->nullable();
            $table->string('freelancer_phone_number')->nullable();
            $table->string('freelancer_adress')->nullable();
            $table->date('freelancer_birth_date')->nullable();
            $table->string('portfolio_URL')->nullable();
            $table->string('CV')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freelancers');
    }
};
