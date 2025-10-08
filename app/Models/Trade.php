<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trade extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'bot_activation_id',
        'symbol',
        'side',
        'quantity',
        'price',
        'total',
        'fee',
        'profit_loss',
        'status',
        'metadata',
    ];

    protected $casts = [
        'quantity' => 'decimal:8',
        'price' => 'decimal:8',
        'total' => 'decimal:2',
        'fee' => 'decimal:2',
        'profit_loss' => 'decimal:2',
        'metadata' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function botActivation()
    {
        return $this->belongsTo(BotActivation::class);
    }

    public function scopeBySymbol($query, $symbol)
    {
        return $query->where('symbol', $symbol);
    }

    public function scopeBuys($query)
    {
        return $query->where('side', 'buy');
    }

    public function scopeSells($query)
    {
        return $query->where('side', 'sell');
    }
}
