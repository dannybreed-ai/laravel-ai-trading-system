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
            $table->decimal('current_profit', 15, 2)->default(0.00);
            $table->decimal('final_profit', 15, 2)->nullable();
            $table->string('status')->default('active');
            $table->timestamp('activated_at')->useCurrent();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('user_id');
            $table->index('bot_id');
            $table->index('status');
            $table->index('activated_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bot_activations');
    }
};
