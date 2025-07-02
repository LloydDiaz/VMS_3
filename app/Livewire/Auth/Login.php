<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

#[Layout('components.layouts.auth')]
class Login extends Component
{
    public string $user_login = '';
    public string $password = '';
    public bool $remember = false;

    public function login(): void
    {
        logger('Login method triggered');

        $this->validate([
            'user_login' => 'required|string',
            'password' => 'required|string',
        ]);

        logger('Validation passed');

        $field = filter_var($this->user_login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (!Auth::attempt([$field => $this->user_login, 'password' => $this->password], $this->remember)) {
            throw ValidationException::withMessages([
                'user_login' => __('auth.failed'),
            ]);
        }

        logger('Login successful');

        Session::regenerate();
        $this->redirectIntended(route('dashboard'));
    }

    protected function throttleKey(): string
    {
        return Str::lower($this->user_login) . '|' . request()->ip();
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) return;

        event(new Lockout(request()));
        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
