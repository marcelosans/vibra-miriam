<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

class RegisterPage extends Component
{
    #[Rule('required|string|max:255|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/')]
    public string $nombre = '';

    #[Rule('required|string|max:255|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/')]
    public string $primer_apellido = '';

    #[Rule('nullable|string|max:255|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/')]
    public string $segundo_apellido = '';

    #[Rule('required|string|email|max:255|unique:users')]
    public string $email = '';

   
    #[Rule('required|string|regex:/^\+34[67]\d{8}$/')]
    public string $telefono = '';  

    #[Rule('required|string|min:8')]
    public string $password = '';

    #[Rule('required|string|same:password')]
    public string $password_confirmation = '';

    #[Rule('accepted')]
    public bool $terms = false;

    protected $messages = [
        'nombre.required' => 'El nombre es obligatorio.',
        'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
        'primer_apellido.required' => 'El primer apellido es obligatorio.',
        'primer_apellido.regex' => 'El apellido solo puede contener letras y espacios.',
        'segundo_apellido.regex' => 'El segundo apellido solo puede contener letras y espacios.',
        'email.required' => 'El correo electrónico es obligatorio.',
        'email.email' => 'El correo electrónico debe ser válido.',
        'email.unique' => 'Este correo electrónico ya está registrado.',
        'telefono.required' => 'El número de teléfono es obligatorio.',
        'telefono.regex' => 'El formato del teléfono no es válido. Usa formato: +34XXXXXXXXX',
        'password.required' => 'La contraseña es obligatoria.',
        'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        'password_confirmation.required' => 'Debes confirmar la contraseña.',
        'password_confirmation.same' => 'Las contraseñas no coinciden.',
        'terms.accepted' => 'Debes aceptar los términos y condiciones.',
    ];

    public function mount()
    {
        // Redirigir si ya está autenticado
        if (Auth::check()) {
            return redirect()->route('homepage');
        }
    }

    public function updatedEmail()
    {
        $this->validateOnly('email');
    }

    public function updatedTelefono()
    {
        // Formatear teléfono automáticamente
        $telefono = preg_replace('/[^0-9+]/', '', $this->telefono);
        
        if (strlen($telefono) === 9 && !str_starts_with($telefono, '+')) {
            $this->telefono = '+34' . $telefono;
        }
    }

    public function updatedPassword()
    {
        $this->validateOnly('password');
        
        // Revalidar confirmación si ya se escribió
        if (!empty($this->password_confirmation)) {
            $this->validateOnly('password_confirmation');
        }
    }

    public function updatedPasswordConfirmation()
    {
        $this->validateOnly('password_confirmation');
    }

    public function register()
    {
        $validated = $this->validate();

        // Formatear teléfono
        $telefono = $this->formatTelefono($validated['telefono']);

        // Crear usuario
        $user = User::create([
            'name' => trim($validated['nombre'] . ' ' . $validated['primer_apellido'] . ' ' . ($validated['segundo_apellido'] ?? '')),
            'nombre' => $validated['nombre'],
            'primer_apellido' => $validated['primer_apellido'],
            'segundo_apellido' => $validated['segundo_apellido'] ?? null,
            'email' => $validated['email'],
            'telefono' => $telefono,
            'password' => Hash::make($validated['password']),
            'email_verified_at' => now(), // Puedes cambiar esto si quieres verificación por email
        ]);

        // Autenticar automáticamente
        Auth::login($user);

        // Regenerar sesión por seguridad
        request()->session()->regenerate();

        // Mensaje de éxito
        session()->flash('status', '¡Bienvenido! Tu cuenta ha sido creada exitosamente.');

        // Redirigir al dashboard
        return redirect()->route('homepage');
    }

    private function formatTelefono(string $telefono): string
    {
        // Limpiar el teléfono
        $telefono = preg_replace('/[^0-9+]/', '', $telefono);
        
        // Si no tiene prefijo, agregar +34
        if (strlen($telefono) === 9 && !str_starts_with($telefono, '+')) {
            return '+34' . $telefono;
        }
        
        // Si tiene 0034, convertir a +34
        if (str_starts_with($telefono, '0034')) {
            return '+34' . substr($telefono, 4);
        }
        
        // Si tiene 34 al inicio, agregar +
        if (str_starts_with($telefono, '34') && strlen($telefono) === 11) {
            return '+' . $telefono;
        }
        
        return $telefono;
    }

    public function getPasswordStrengthProperty()
    {
        if (empty($this->password)) {
            return ['strength' => 0, 'text' => '', 'color' => ''];
        }

        $score = 0;
        $feedback = [];

        // Longitud
        if (strlen($this->password) >= 8) $score++;
        if (strlen($this->password) >= 12) $score++;

        // Caracteres
        if (preg_match('/[a-z]/', $this->password)) $score++;
        if (preg_match('/[A-Z]/', $this->password)) $score++;
        if (preg_match('/[0-9]/', $this->password)) $score++;
        if (preg_match('/[^A-Za-z0-9]/', $this->password)) $score++;

        $strength = min(4, $score);
        
        $levels = [
            0 => ['text' => '', 'color' => ''],
            1 => ['text' => 'Muy débil', 'color' => 'text-red-500'],
            2 => ['text' => 'Débil', 'color' => 'text-orange-500'],
            3 => ['text' => 'Buena', 'color' => 'text-yellow-500'],
            4 => ['text' => 'Fuerte', 'color' => 'text-green-500'],
        ];

        return array_merge($levels[$strength], ['strength' => $strength]);
    }

    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
