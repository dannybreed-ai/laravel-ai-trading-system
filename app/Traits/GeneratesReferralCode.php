<?php

namespace App\Traits;

trait GeneratesReferralCode
{
    /**
     * Generate a unique referral code for the user.
     *
     * @return string
     */
    public static function generateReferralCode(): string
    {
        do {
            $code = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8));
        } while (self::where('referral_code', $code)->exists());

        return $code;
    }

    /**
     * Boot the trait and set up model event listeners.
     */
    protected static function bootGeneratesReferralCode(): void
    {
        static::creating(function ($model) {
            if (empty($model->referral_code)) {
                $model->referral_code = self::generateReferralCode();
            }
        });
    }
}
