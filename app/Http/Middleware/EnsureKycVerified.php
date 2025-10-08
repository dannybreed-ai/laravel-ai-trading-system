<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureKycVerified
{
    /**
     * Routes that are exempt from KYC verification.
     *
     * @var array
     */
    protected $except = [
        'kyc/submit',
        'kyc/store',
        'logout',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Check if current route is in the exception list
        foreach ($this->except as $pattern) {
            if ($request->is($pattern)) {
                return $next($request);
            }
        }

        // Check if user is KYC verified
        if (!auth()->user()->isKycVerified()) {
            return redirect()->route('kyc.submit')
                ->with('warning', 'Please complete KYC verification to access this area.');
        }

        return $next($request);
    }
}
