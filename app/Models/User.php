<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'avatar',
        'phone',
        'country',
        'city',
        'address',
        'date_of_birth',
        'balance',
        'status',
        'is_admin',
        'referral_code',
        'referred_by',
        'kyc_verified_at',
        'last_login_at',
        'last_login_ip',
        'two_factor_enabled',
        'two_factor_secret',
        'preferences',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'kyc_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'date_of_birth' => 'date',
        'balance' => 'decimal:2',
        'status' => 'boolean',
        'is_admin' => 'boolean',
        'two_factor_enabled' => 'boolean',
        'preferences' => 'array',
        'password' => 'hashed',
    ];

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function botActivations()
    {
        return $this->hasMany(BotActivation::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function trades()
    {
        return $this->hasMany(Trade::class);
    }

    public function referralEarnings()
    {
        return $this->hasMany(ReferralEarning::class);
    }

    public function kycRecords()
    {
        return $this->hasMany(KycRecord::class);
    }

    public function sentTransfers()
    {
        return $this->hasMany(P2pTransfer::class, 'sender_id');
    }

    public function receivedTransfers()
    {
        return $this->hasMany(P2pTransfer::class, 'receiver_id');
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    public function isKycVerified()
    {
        return !is_null($this->kyc_verified_at);
    }

    public function hasTwoFactorEnabled()
    {
        return $this->two_factor_enabled;
    }

    public function getTotalProfitAttribute()
    {
        return $this->transactions()
                    ->where('type', 'profit')
                    ->sum('amount');
    }

    public function getTotalDepositsAttribute()
    {
        return $this->deposits()
                    ->where('status', 'approved')
                    ->sum('amount');
    }

    public function getTotalWithdrawalsAttribute()
    {
        return $this->withdrawals()
                    ->where('status', 'approved')
                    ->sum('amount');
    }

    public function getActiveBotActivationsAttribute()
    {
        return $this->botActivations()
                    ->where('status', 'active')
                    ->count();
    }

    public static function generateReferralCode()
    {
        do {
            $code = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8));
        } while (self::where('referral_code', $code)->exists());

        return $code;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeKycVerified($query)
    {
        return $query->whereNotNull('kyc_verified_at');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->referral_code)) {
                $user->referral_code = self::generateReferralCode();
            }
        });
    }
}