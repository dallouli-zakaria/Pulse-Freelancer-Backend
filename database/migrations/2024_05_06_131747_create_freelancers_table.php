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

            $table->foreignId('id')->constrained('users')->primary()->cascadeOnDelete();
            $table->string('title')->nullable();;
            $table->date('dateOfBirth')->nullable();;
            $table->string('city')->nullable();;
            $table->string('TJM')->nullable();;
            $table->text('summary')->nullable();;
            $table->string('availability')->nullable();;
            $table->string('adress')->nullable();;
            $table->string('phone')->nullable();;
            $table->string('portfolio_url')->nullable();
            $table->string('status');
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
