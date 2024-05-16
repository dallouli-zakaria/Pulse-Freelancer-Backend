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
        Schema::create('expericences', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('companyName');
            $table->string('country');
            $table->string('city');
            $table->date('startDate');
            $table->date('endDate');
            $table->text('description');
            $table->foreignId('freelancer_id')->constrained('freelancers')->cascadeOnDelete()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expericences');
    }
};
