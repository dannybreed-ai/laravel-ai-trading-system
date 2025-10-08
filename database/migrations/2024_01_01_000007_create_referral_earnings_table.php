<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('referral_earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('referred_user_id')->constrained('users')->onDelete('cascade');
            $table->integer('level');
            $table->decimal('amount', 15, 2);
            $table->string('source_type');
            $table->unsignedBigInteger('source_id');
            $table->decimal('commission_rate', 5, 2);
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('referred_user_id');
            $table->index('level');
            $table->index(['source_type', 'source_id']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referral_earnings');
    }
};
