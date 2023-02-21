<?php

namespace App\Http\Middleware;

use App\Helpers\HasEnsure;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class isAdmin
{
    use HasEnsure;
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse|null
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse|null
    {
        $user = $this->ensureIsNotNullUser(Auth::user());
        if ($user->admin == 1) {
            return $next($request);
        }
        return $request->expectsJson()
            ? abort(403, 'Your are not admin!')
            : Redirect::guest(URL::route('profile.settings'));
    }
}
