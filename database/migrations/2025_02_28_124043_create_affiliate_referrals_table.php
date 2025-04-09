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
        Schema::create('inviter_invitees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('inviter_id')->constrained('users')->onDelete('cascade'); // The user who invites others with the code
            $table->foreignUuid('invitee_id')->constrained('users')->onDelete('cascade'); // The user who accepts the invite and joins
            $table->string('invite_code'); // The unique code for the invitation
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_referrals');
    }
};
