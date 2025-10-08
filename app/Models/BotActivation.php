<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BotActivation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'bot_id',
        'investment_amount',
        'duration_days',
        'status',
        'started_at',
        'expected_end_at',
        'closed_at',
        'profit_earned',
        'profit_withdrawn',
        'daily_profits',
        'notes',
    ];

    protected $casts = [
        'investment_amount' => 'decimal:2',
        'duration_days' => 'integer',
        'profit_earned' => 'decimal:2',
        'profit_withdrawn' => 'decimal:2',
        'started_at' => 'datetime',
        'expected_end_at' => 'datetime',
        'closed_at' => 'datetime',
        'daily_profits' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bot()
    {
        return $this->belongsTo(Bot::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'reference', 'id')
                    ->where('reference_type', 'bot_activation');
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function getDaysRemainingAttribute()
    {
        if (!$this->expected_end_at || $this->status !== 'active') {
            return 0;
        }
        return max(0, now()->diffInDays($this->expected_end_at, false));
    }

    public function getTotalReturnAttribute()
    {
        return $this->investment_amount + $this->profit_earned;
    }

    public function getProgressPercentageAttribute()
    {
        if (!$this->started_at || !$this->expected_end_at) {
            return 0;
        }
        
        $totalDays = $this->started_at->diffInDays($this->expected_end_at);
        $elapsedDays = $this->started_at->diffInDays(now());
        
        return min(100, ($elapsedDays / max(1, $totalDays)) * 100);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
