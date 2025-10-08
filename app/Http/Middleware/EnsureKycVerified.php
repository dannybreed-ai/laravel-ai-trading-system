<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureKycVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!auth()->user()->isKycVerified()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'KYC verification required',
                    'message' => 'Please complete KYC verification to access this feature.'
                ], 403);
            }

            return redirect()->route('kyc.submit')
                ->with('error', 'Please complete KYC verification to access this feature.');
        }

        return $next($request);
    }
}
