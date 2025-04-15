<?php

use App\Domains\Airdrop\Enums\AirdropTypeEnum;
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
        Schema::create('airdrops', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name');
            $table->string('keyword');

            $table->enum('type', [
                AirdropTypeEnum::Wheel->value,
                AirdropTypeEnum::Rain->value,
            ]);

            $table->boolean('active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });

        // create airdrop winners table
        Schema::create('airdrop_participants', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('airdrop_id')->constrained('airdrops');
            $table->foreignUuid('user_id')->constrained('users');
            $table->boolean('winner')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airdrops');
    }
};
