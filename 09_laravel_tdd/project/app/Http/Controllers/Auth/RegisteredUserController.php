<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\HasEnsure;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    use HasEnsure;

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): View
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'city' => ['nullable', 'string', 'max:255'],
            'age' => [ 'nullable' ,'integer'],
        ]);

        $password = $this->ensureIsString($request->password);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($password),
            'city' => $request->city,
            'age' => $request->age,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return view('auth.verify-email')->with('message', 'Verification e-mail sent');
    }
}
