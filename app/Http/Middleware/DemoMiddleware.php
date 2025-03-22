<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DemoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return RedirectResponse|JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!config('app.demo_mode')) {
            return $next($request);
        }

        $uri = $request->getRequestUri();

        // Check if the request should be allowed
        if ($this->shouldAllowRequest($uri, $request)) {
            return $next($request);
        }

        // Log and return error response for restricted actions
        return $this->restrictedResponse($uri, Auth::user());
    }

    /**
     * Determine if the request should be allowed.
     *
     * @param string $uri
     * @param Request $request
     * @return bool
     */
    private function shouldAllowRequest(string $uri, Request $request): bool
    {
        $excludedUris = [
            '/comments/store',
            '/comments/update',
            '/comments/delete',
            '/user-signup',
            '/api/user-signup',
            '/logout',
            '/api/manage-favourite',
        ];

        $restrictedPatterns = [
            '*edit*',  // Block URIs containing "edit"
            '*update*', // Block URIs containing "update"
            '*delete*', // Block URIs containing "delete"
        ];

        // APIs should always be allowed
        if ($request->is('api/*')) {
            return true;
        }

        // Allow excluded URIs
        if (in_array($uri, $excludedUris)) {
            return true;
        }

        // Block URIs that match restricted patterns
        foreach ($restrictedPatterns as $pattern) {
            if (fnmatch($pattern, $uri)) {
                return false; // Deny the request if it matches any restricted pattern
            }
        }

        // Allow specific users or GET requests
        $user = Auth::user();
        return $this->isAllowedUser($user) || $request->isMethod('get');
    }

    /**
     * Determine if the user is allowed to perform actions.
     *
     * @param mixed $user
     * @return bool
     */
    private function isAllowedUser($user): bool
    {
        if (!$user) {
            return true; // Allow if no user is logged in
        }

        $demoMobile = config('demo.demo_mobile', '9876598765');
        $demoAdminEmail = config('demo.demo_admin_email', 'user@gmail.com');

        if ($user->mobile !== $demoMobile && $user->hasRole('User')) {
            return true;
        }

        return $user->email === $demoAdminEmail && $user->hasRole('Admin');
    }

    /**
     * Build the restricted response for disallowed actions.
     *
     * @param string $uri
     * @param mixed $user
     * @return \Illuminate\Http\JsonResponse
     */
    private function restrictedResponse(string $uri, $user)
    {
        Log::warning('Blocked action in demo mode', [
            'uri' => $uri,
            'user_id' => $user ? $user->id : null, // Log user ID only
        ]);

        return response()->json([
            'error' => true,
            'message' => "This is not allowed in the Demo Version.",
            'code' => 112,
        ]);
    }
}
