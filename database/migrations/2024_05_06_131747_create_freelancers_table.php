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
            $table->string('title');
            $table->date('dateOfBirth');
            $table->string('city');
            $table->string('TJM');
            $table->text('summary');
            $table->string('availability');
            $table->string('adress');
            $table->string('phone');
            $table->string('portfolio_url')->nullable();
            $table->string('cv')->nullable();
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
