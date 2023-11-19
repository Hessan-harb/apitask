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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->integer('month');
            $table->integer('year');
            $table->decimal('paid', 10, 2);
            $table->decimal('outstanding', 10, 2);
            $table->decimal('overdue', 10, 2);
            $table->timestamps();
            $table->foreignId('user_id')->constrained('users','id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
