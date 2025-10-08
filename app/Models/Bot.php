<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bot extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'strategy_type',
        'min_investment',
        'max_investment',
        'daily_profit_range_min',
        'daily_profit_range_max',
        'duration_days',
        'risk_level',
        'status',
        'total_activations',
        'total_profit_generated',
        'success_rate',
        'features',
        'icon',
    ];

    protected $casts = [
        'min_investment' => 'decimal:2',
        'max_investment' => 'decimal:2',
        'daily_profit_range_min' => 'decimal:2',
        'daily_profit_range_max' => 'decimal:2',
        'duration_days' => 'integer',
        'total_activations' => 'integer',
        'total_profit_generated' => 'decimal:2',
        'success_rate' => 'decimal:2',
        'status' => 'boolean',
        'features' => 'array',
    ];

    public function activations()
    {
        return $this->hasMany(BotActivation::class);
    }

    public function trades()
    {
        return $this->hasMany(Trade::class);
    }

    public function activeActivations()
    {
        return $this->hasMany(BotActivation::class)->where('status', 'active');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function calculateExpectedProfit($investmentAmount, $durationDays = null)
    {
        $days = $durationDays ?? $this->duration_days;
        $avgDailyRate = ($this->daily_profit_range_min + $this->daily_profit_range_max) / 2;
        return $investmentAmount * ($avgDailyRate / 100) * $days;
    }
}
