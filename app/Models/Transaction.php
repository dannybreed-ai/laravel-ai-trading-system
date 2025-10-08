<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'balance_before',
        'balance_after',
        'reference',
        'reference_type',
        'description',
        'meta',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'meta' => 'array',
    ];

    const TYPE_DEPOSIT = 'deposit';
    const TYPE_WITHDRAWAL = 'withdrawal';
    const TYPE_PROFIT = 'profit';
    const TYPE_REFERRAL_BONUS = 'referral_bonus';
    const TYPE_TRADE_FEE = 'trade_fee';
    const TYPE_ADJUST = 'adjust';
    const TYPE_P2P_TRANSFER_IN = 'p2p_transfer_in';
    const TYPE_P2P_TRANSFER_OUT = 'p2p_transfer_out';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function referenceable()
    {
        return $this->morphTo('reference', 'reference_type', 'reference');
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeCredits($query)
    {
        return $query->whereIn('type', [
            self::TYPE_DEPOSIT,
            self::TYPE_PROFIT,
            self::TYPE_REFERRAL_BONUS,
            self::TYPE_P2P_TRANSFER_IN,
        ]);
    }

    public function scopeDebits($query)
    {
        return $query->whereIn('type', [
            self::TYPE_WITHDRAWAL,
            self::TYPE_TRADE_FEE,
            self::TYPE_P2P_TRANSFER_OUT,
        ]);
    }

    public function isCredit()
    {
        return in_array($this->type, [
            self::TYPE_DEPOSIT,
            self::TYPE_PROFIT,
            self::TYPE_REFERRAL_BONUS,
            self::TYPE_P2P_TRANSFER_IN,
        ]);
    }

    public function isDebit()
    {
        return in_array($this->type, [
            self::TYPE_WITHDRAWAL,
            self::TYPE_TRADE_FEE,
            self::TYPE_P2P_TRANSFER_OUT,
        ]);
    }
}
