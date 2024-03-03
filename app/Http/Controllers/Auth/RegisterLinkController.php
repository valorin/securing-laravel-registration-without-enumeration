<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessRegistrationAttempt;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegisterLinkController extends Controller
{
    public function create(Request $request): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
        ]);

        ProcessRegistrationAttempt::dispatch($request->email);

        return redirect()
            ->route('register')
            ->with('status', 'Check your email for the next steps!');
    }
}
