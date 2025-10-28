<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;


class LoginPage extends Component
{
    #[Rule('required|email')]
    public string $email = '';

    #[Rule('required|string|min:6')]
    public string $password = '';

    public bool $remember = false;

    public function mount()
    {
        // Redirigir si ya está autenticado
        if (Auth::check()) {
            return redirect()->intended('/');
        }
    }

    public function login()
    {
        $this->validate();

        // Rate limiting
        $key = Str::transliterate(Str::lower($this->email) . '|' . request()->ip());

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            
            throw ValidationException::withMessages([
                'email' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]);
        }

        // Intentar autenticación
        if (Auth::attempt([
            'email' => $this->email,
            'password' => $this->password
        ], $this->remember)) {
            
            // Limpiar rate limiting en login exitoso
            RateLimiter::clear($key);
            
            // Regenerar sesión por seguridad
            request()->session()->regenerate();
            
            // Mensaje de éxito
            session()->flash('status', '¡Bienvenido! Has iniciado sesión correctamente.');
            
            // Redirigir al dashboard o página intended
            return redirect()->intended('/');
        }

        // Incrementar rate limiting en fallo
        RateLimiter::hit($key, 60);

        // Error de credenciales
        $this->addError('email', 'Las credenciales proporcionadas no coinciden con nuestros registros.');
        
        // Limpiar contraseña por seguridad
        $this->reset('password');
    }

    public function resetPassword()
    {
        $this->validate([
            'email' => 'required|email'
        ]);

        // Aquí puedes implementar la lógica de reset de contraseña
        // Por ejemplo, enviar un email con el link de reset
        
        session()->flash('status', 'Te hemos enviado un enlace para restablecer tu contraseña.');
    }

    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
