<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\HasEnsure;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    use HasEnsure;

    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        $user = $this->ensureIsNotNullUser($request->user());

        return $user->hasVerifiedEmail()
            ? redirect()->intended(RouteServiceProvider::HOME)
            : view('auth.verify-email')->with('title', 'Verify your e-mail');
    }
}
