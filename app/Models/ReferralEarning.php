<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralEarning extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'from_user_id',
        'level',
        'amount',
        'percentage',
        'source_type',
        'source_id',
        'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'percentage' => 'decimal:4',
        'level' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function source()
    {
        return $this->morphTo('source', 'source_type', 'source_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'reference', 'id')
                    ->where('reference_type', 'referral_earning');
    }

    public function scopeByLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    public function scopeBySourceType($query, $sourceType)
    {
        return $query->where('source_type', $sourceType);
    }
}
