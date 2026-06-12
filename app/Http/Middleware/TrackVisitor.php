<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\VisitorLog;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        
        if ($request->isMethod('GET') && $response->getStatusCode() === 200 && !$request->ajax() && !str_starts_with($request->path(), 'admin')) {
            $ip = $request->ip();
            $path = $request->path() === '/' ? '/' : '/' . $request->path();
            
            
            $exists = VisitorLog::where('ip_address', $ip)
                ->where('path', $path)
                ->where('visited_at', '>=', now()->subHour())
                ->exists();

            if (!$exists) {
                VisitorLog::create([
                    'ip_address' => $ip,
                    'user_agent' => $request->userAgent(),
                    'path' => $path,
                    'visited_at' => now(),
                ]);
            }
        }

        return $response;
    }
}
