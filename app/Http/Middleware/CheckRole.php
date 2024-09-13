<?php

namespace App\Http\Middleware;

use App\service\message;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role)
    {

//        if (!auth()->check()) {
//            return response()->json(['error' => 'You are not authenticated'], 403);
//        }
//
            if (auth()->user()->role !== $role) {
                return response()->json(['error' => 'You are not authorized '], 403);
            }

        return $next($request);
    }

}
