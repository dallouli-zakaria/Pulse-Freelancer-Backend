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
        Schema::create('client__companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('field');
            $table->string('phone_number');
            $table->string('email');
            $table->string('ICE');
            $table->string('adresse');
            $table->string('website')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client__companies');
    }
};
