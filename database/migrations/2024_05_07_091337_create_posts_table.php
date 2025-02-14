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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('location');
            $table->string('type');
            $table->text('description');
            $table->string('period');
            $table->integer('freelancers_number'); 
            $table->integer('periodvalue')->nullable();
            $table->string('budget');
            $table->integer('budgetvalue')->nullable();
            $table->string('status')->default('open')->nullable();
            $table->foreignId('client_id')->constrained('clients')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
