<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('bot_activation_id')->constrained()->onDelete('cascade');
            $table->string('symbol');
            $table->string('side');
            $table->decimal('quantity', 20, 8);
            $table->decimal('price', 20, 8);
            $table->decimal('total', 15, 2);
            $table->decimal('fee', 15, 2)->default(0.00);
            $table->decimal('profit_loss', 15, 2)->default(0.00);
            $table->string('status')->default('completed');
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('user_id');
            $table->index('bot_activation_id');
            $table->index('symbol');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
