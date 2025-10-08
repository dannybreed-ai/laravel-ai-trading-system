<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bots', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('symbol')->default('BTC/USDT');
            $table->text('description')->nullable();
            $table->decimal('min_investment', 15, 2)->default(100.00);
            $table->decimal('max_investment', 15, 2)->default(10000.00);
            $table->decimal('expected_return_min', 5, 2)->default(1.00);
            $table->decimal('expected_return_max', 5, 2)->default(5.00);
            $table->integer('duration_days')->default(30);
            $table->string('risk_level')->default('medium');
            $table->decimal('risk_weight', 5, 2)->default(1.00);
            $table->string('status')->default('active');
            $table->timestamps();
            
            $table->index('status');
            $table->index('risk_level');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bots');
    }
};
