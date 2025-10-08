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
        'bot_id',
        'bot_activation_id',
        'symbol',
        'side',
        'quantity',
        'entry_price',
        'exit_price',
        'profit_loss',
        'profit_loss_percentage',
        'fee',
        'status',
        'opened_at',
        'closed_at',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:8',
        'entry_price' => 'decimal:8',
        'exit_price' => 'decimal:8',
        'profit_loss' => 'decimal:2',
        'profit_loss_percentage' => 'decimal:2',
        'fee' => 'decimal:2',
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    const SIDE_BUY = 'buy';
    const SIDE_SELL = 'sell';
    const SIDE_LONG = 'long';
    const SIDE_SHORT = 'short';

    const STATUS_OPEN = 'open';
    const STATUS_CLOSED = 'closed';
    const STATUS_CANCELLED = 'cancelled';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bot()
    {
        return $this->belongsTo(Bot::class);
    }

    public function botActivation()
    {
        return $this->belongsTo(BotActivation::class);
    }

    public function scopeOpen($query)
    {
        return $query->where('status', self::STATUS_OPEN);
    }

    public function scopeClosed($query)
    {
        return $query->where('status', self::STATUS_CLOSED);
    }

    public function scopeProfitable($query)
    {
        return $query->where('profit_loss', '>', 0);
    }

    public function scopeLossMaking($query)
    {
        return $query->where('profit_loss', '<', 0);
    }

    public function isOpen()
    {
        return $this->status === self::STATUS_OPEN;
    }

    public function isClosed()
    {
        return $this->status === self::STATUS_CLOSED;
    }

    public function isProfitable()
    {
        return $this->profit_loss > 0;
    }

    public function getDurationAttribute()
    {
        if (!$this->opened_at || !$this->closed_at) {
            return null;
        }
        return $this->opened_at->diffForHumans($this->closed_at, true);
    }
}
