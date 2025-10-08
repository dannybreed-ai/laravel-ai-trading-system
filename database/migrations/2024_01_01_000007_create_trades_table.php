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
            $table->foreignId('bot_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('bot_activation_id')->nullable()->constrained()->onDelete('set null');
            $table->string('symbol');
            $table->string('side');
            $table->decimal('quantity', 20, 8)->default(0);
            $table->decimal('entry_price', 20, 8);
            $table->decimal('exit_price', 20, 8)->nullable();
            $table->decimal('profit_loss', 15, 2)->default(0);
            $table->decimal('profit_loss_percentage', 8, 2)->default(0);
            $table->decimal('fee', 15, 2)->default(0);
            $table->string('status')->default('open');
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['user_id', 'status']);
            $table->index('bot_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
