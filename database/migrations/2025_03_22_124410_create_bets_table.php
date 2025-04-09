<?php

use App\Domains\Betting\Enums\BetStatusEnum;
use App\Domains\Betting\Enums\GameTypeEnum;
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
        Schema::create('bets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained();
            $table->enum('game_type', [
                GameTypeEnum::Coinflip->value,
            ]);
            $table->decimal('amount', 18, 8);
            $table->decimal('amount_after', 18, 0);
            $table->foreignUuid('currency_id')->constrained();
            $table->string('choice');
            $table->string('server_seed_hash');
            $table->string('server_seed');
            $table->foreignUuid('user_balance_id')->constrained();
            $table->string('client_seed');
            $table->string('nonce')->default(time());
            $table->string('result')->nullable();
            $table->enum('status', [
                BetStatusEnum::Placed->value,
                BetStatusEnum::Pending->value,
                BetStatusEnum::Finished->value,
                BetStatusEnum::Cancelled->value,
            ]);
            $table->string('final_result')->nullable();
            $table->boolean('won')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bets');
    }
};
