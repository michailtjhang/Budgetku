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
            $table->uuid('id')->primary(); // UUID sebagai primary key
            $table->unsignedBigInteger('user_id'); // Foreign key ke User
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('category_id'); // Foreign key ke Category
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->date('date');
            $table->decimal('amount', 15, 2); // Jumlah uang
            $table->text('description')->nullable();
            $table->enum('type', ['income', 'expense']); // Jenis transaksi
            $table->timestamps();
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
