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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 8, 2);
            $table->string('payer');
            $table->string('due_on');
            $table->decimal('vat', 8, 2);
            $table->boolean('is_vat_inclusive')->default(true);
            $table->enum('status',['paid','outstanding','overdue'])->default('paid');
            $table->timestamps();
            $table->foreignId('user_id')->constrained('users','id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
