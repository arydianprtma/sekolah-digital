<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPageView
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track GET requests for public pages (not portal/api)
        if ($request->isMethod('GET')
            && ! $request->is('portal*')
            && ! $request->is('api/*')
            && ! $request->is('livewire/*')
            && $response->getStatusCode() === 200
        ) {
            $userAgent = $request->userAgent() ?? '';

            PageView::create([
                'url'         => $request->path(),
                'ip_address'  => $request->ip(),
                'user_agent'  => substr($userAgent, 0, 500),
                'referer'     => substr((string) $request->header('referer', ''), 0, 1000),
                'device_type' => PageView::detectDevice($userAgent),
                'tanggal'     => now()->toDateString(),
            ]);
        }

        return $response;
    }
}
