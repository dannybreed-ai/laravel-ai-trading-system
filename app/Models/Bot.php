<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bot extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'symbol',
        'description',
        'min_investment',
        'max_investment',
        'expected_return_min',
        'expected_return_max',
        'duration_days',
        'risk_level',
        'risk_weight',
        'status',
    ];

    protected $casts = [
        'min_investment' => 'decimal:2',
        'max_investment' => 'decimal:2',
        'expected_return_min' => 'decimal:2',
        'expected_return_max' => 'decimal:2',
        'risk_weight' => 'decimal:2',
        'duration_days' => 'integer',
    ];

    public function activations()
    {
        return $this->hasMany(BotActivation::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByRiskLevel($query, $level)
    {
        return $query->where('risk_level', $level);
    }
}
