<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // إذا المستخدم مسجل دخول
        if (Auth::check()) {

            // إذا هو Admin
            if (Auth::user()->utype == 'ADM') {
                return $next($request);
            }

            // إذا مسجل دخول لكن ليس Admin
            return redirect()->route('login')
                ->with('error', 'You are not authorized to access this page');

        }

        // إذا غير مسجل دخول
        return redirect()->route('login');
    }
}
