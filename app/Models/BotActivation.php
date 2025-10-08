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
        'current_profit',
        'final_profit',
        'status',
        'activated_at',
        'closed_at',
    ];

    protected $casts = [
        'investment_amount' => 'decimal:2',
        'current_profit' => 'decimal:2',
        'final_profit' => 'decimal:2',
        'activated_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bot()
    {
        return $this->belongsTo(Bot::class);
    }

    public function trades()
    {
        return $this->hasMany(Trade::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    public function isActive()
    {
        return $this->status === 'active';
    }
}
