<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('X-GPS-Token') ?? $request->query('api_token');

        if (!$token || !DB::table('api_tokens')->where('token', $token)->exists()) {
            return response()->json(['error' => 'Unauthorized. Invalid or missing API token.'], 401);
        }

        return $next($request);
    }
}
