<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Please sign in to access the NUESA Admin Executive Portal.');
        }

        $user = Auth::user();
        if (!$user->isStaff()) {
            abort(403, 'Unauthorized. Access restricted to NUESA Executive Administrators.');
        }


        return $next($request)->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
        ]);
    }
}
