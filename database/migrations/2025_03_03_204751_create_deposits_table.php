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
        Schema::create('deposits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('transaction_hash', 70)->unique();
            $table->string('sender', 50)->index();
            $table->string('token_address', 50)->nullable();
            $table->string('token_ticker', 10)->nullable();
            $table->decimal('amount', 38, 18);
            $table->unsignedInteger('block');
            $table->dateTime('block_timestamp');
            $table->string('block_hash', 70);
            $table->boolean('confirmed');
            $table->boolean('receipt_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
