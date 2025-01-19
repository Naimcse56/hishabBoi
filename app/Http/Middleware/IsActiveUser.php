<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Modules\Base\App\Services\SecurityService;

class IsActiveUser
{
    protected $securityService;

    public function __construct(SecurityService $securityService)
    {
        $this->securityService = $securityService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (\Auth::user()->is_active != 1) {
            auth()->logout();
            return redirect()->route('login');
        }
        $this->securityService->verify(env("APP_URL"), env("PURCHASE_CODE"));
        return $next($request);
    }
}
