<?php

namespace App\Http\Middleware;

use App\Services\ContentCacheService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiCacheMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Hanya cache respons GET yang berhasil (200 OK)
        if ($request->isMethod('GET') && $response->getStatusCode() === 200) {
            $content = $response->getContent() ?: '';
            $etag = 'W/"'.md5($content).'"';
            $version = ContentCacheService::getVersion();

            $response->headers->set('Cache-Control', 'public, max-age=300, must-revalidate');
            $response->headers->set('ETag', $etag);
            $response->headers->set('X-Content-Version', (string) $version);

            $ifNoneMatch = $request->header('If-None-Match');
            if ($ifNoneMatch && (trim($ifNoneMatch) === $etag || trim($ifNoneMatch, '"') === trim($etag, 'W/"'))) {
                return response('', 304, [
                    'Cache-Control' => 'public, max-age=300, must-revalidate',
                    'ETag' => $etag,
                    'X-Content-Version' => (string) $version,
                ]);
            }
        }

        return $response;
    }
}
