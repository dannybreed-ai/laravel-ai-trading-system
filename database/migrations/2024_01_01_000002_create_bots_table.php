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
            $table->text('description')->nullable();
            $table->string('strategy_type')->default('AI Trading');
            $table->decimal('min_investment', 15, 2)->default(10);
            $table->decimal('max_investment', 15, 2)->default(10000);
            $table->decimal('daily_profit_range_min', 5, 2)->default(0.5);
            $table->decimal('daily_profit_range_max', 5, 2)->default(5);
            $table->integer('duration_days')->default(30);
            $table->string('risk_level')->default('medium');
            $table->boolean('status')->default(true);
            $table->integer('total_activations')->default(0);
            $table->decimal('total_profit_generated', 15, 2)->default(0);
            $table->decimal('success_rate', 5, 2)->default(95);
            $table->json('features')->nullable();
            $table->string('icon')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bots');
    }
};
