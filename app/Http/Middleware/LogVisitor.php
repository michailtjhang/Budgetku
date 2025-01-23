<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\Visitors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class LogVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Catat pengunjung
        $today = Carbon::today();
        Visitors::updateOrCreate(
            ['date' => $today],
            ['count' => DB::raw('count + 1')] // Increment count
        );
        
        return $next($request);
    }
}