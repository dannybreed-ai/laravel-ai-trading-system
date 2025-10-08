<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bot_activations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('bot_id')->constrained()->onDelete('cascade');
            $table->decimal('investment_amount', 15, 2);
            $table->integer('duration_days');
            $table->string('status')->default('active');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('expected_end_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->decimal('profit_earned', 15, 2)->default(0);
            $table->decimal('profit_withdrawn', 15, 2)->default(0);
            $table->json('daily_profits')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bot_activations');
    }
};
