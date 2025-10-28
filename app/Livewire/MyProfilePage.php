<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class MyProfilePage extends Component
{
    use WithFileUploads;

    // Propiedades para información personal
    public $nombre = '';
    public $primerApellido = '';
    public $segundoApellido = '';
    public $email = '';
    public $telefono = '';
    public $foto;
    public $fotoActual = null;

    // Propiedades para cambio de contraseña
    public $currentPassword = '';
    public $newPassword = '';
    public $newPasswordConfirmation = '';

    // Pestaña activa
    public $activeTab = 'profile';

    protected function rules()
    {
        $rules = [
            'nombre' => 'required|string|min:2|max:50',
            'primerApellido' => 'required|string|min:2|max:50',
            'segundoApellido' => 'nullable|string|min:2|max:50',
            'telefono' => 'required|string|min:9|max:15',
            'foto' => 'nullable|image|max:1024', // max 1MB
        ];

        // Validación de email solo si ha cambiado
        if ($this->email !== auth()->user()->email) {
            $rules['email'] = 'required|email|max:100|unique:users,email,' . auth()->id();
        } else {
            $rules['email'] = 'required|email|max:100';
        }

        return $rules;
    }

    protected function passwordRules()
    {
        return [
            'currentPassword' => 'required',
            'newPassword' => [
                'required',
                'string',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
                'different:currentPassword'
            ],
            'newPasswordConfirmation' => 'required|same:newPassword',
        ];
    }

    protected $messages = [
        // Mensajes para información personal
        'nombre.required' => 'El nombre es obligatorio',
        'nombre.min' => 'El nombre debe tener al menos 2 caracteres',
        'nombre.max' => 'El nombre no puede tener más de 50 caracteres',
        'primerApellido.required' => 'El primer apellido es obligatorio',
        'primerApellido.min' => 'El primer apellido debe tener al menos 2 caracteres',
        'primerApellido.max' => 'El primer apellido no puede tener más de 50 caracteres',
        'segundoApellido.min' => 'El segundo apellido debe tener al menos 2 caracteres',
        'segundoApellido.max' => 'El segundo apellido no puede tener más de 50 caracteres',
        'email.required' => 'El correo electrónico es obligatorio',
        'email.email' => 'El correo electrónico debe ser válido',
        'email.unique' => 'Este correo electrónico ya está en uso',
        'telefono.required' => 'El número de teléfono es obligatorio',
        'telefono.min' => 'El teléfono debe tener al menos 9 dígitos',
        'telefono.max' => 'El teléfono no puede tener más de 15 caracteres',
        'foto.image' => 'El archivo debe ser una imagen',
        'foto.max' => 'La imagen no puede ser mayor a 1MB',

        // Mensajes para cambio de contraseña
        'currentPassword.required' => 'La contraseña actual es obligatoria',
        'newPassword.required' => 'La nueva contraseña es obligatoria',
        'newPassword.min' => 'La nueva contraseña debe tener al menos 8 caracteres',
        'newPassword.different' => 'La nueva contraseña debe ser diferente a la actual',
        'newPasswordConfirmation.required' => 'Debes confirmar la nueva contraseña',
        'newPasswordConfirmation.same' => 'Las contraseñas no coinciden',
    ];

    public function mount()
    {
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Cargar datos del usuario actual basándose en la estructura del modelo User
        // Dividir el campo 'name' si contiene el nombre completo
        $nombreCompleto = explode(' ', $user->name, 3);
        
        $this->nombre = $nombreCompleto[0] ?? '';
        $this->primerApellido = $user->apellido ?? ($nombreCompleto[1] ?? '');
        $this->segundoApellido = $user->segundo_apellido ?? ($nombreCompleto[2] ?? '');
        $this->email = $user->email;
        $this->telefono = $user->telefono ?? '';
        
        // Cargar foto de perfil si existe
        if (isset($user->foto_de_perfil) && $user->foto_de_perfil && Storage::exists('public/' . $user->foto_de_perfil)) {
            $this->fotoActual = Storage::url($user->foto_de_perfil);
        }
    }

    public function updatedFoto()
    {
        $this->validate([
            'foto' => 'image|max:1024',
        ]);
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        
        // Limpiar errores al cambiar de pestaña
        $this->resetErrorBag();
        $this->resetValidation();
        
        // Si cambiamos a la pestaña de contraseña, limpiar los campos
        if ($tab === 'password') {
            $this->resetPasswordFields();
        }
    }

    public function guardarPerfil()
    {
        $this->validate();

        try {
            $user = auth()->user();
            
            // Manejar subida de foto
            if ($this->foto) {
                // Eliminar foto anterior si existe
                if (isset($user->foto_perfil) && $user->foto_perfil && Storage::exists('public/' . $user->foto_perfil)) {
                    Storage::delete('public/' . $user->foto_perfil);
                }
                
                // Guardar nueva foto
                $fotoPath = $this->foto->store('fotos-perfil', 'public');
                $this->fotoActual = Storage::url($fotoPath);
                $this->foto = null;
            } else {
                $fotoPath = $user->foto_perfil ?? null;
            }

            // Crear nombre completo
            $nombreCompleto = trim($this->nombre . ' ' . $this->primerApellido . ' ' . $this->segundoApellido);

            // Actualizar datos del usuario según la estructura del modelo
            $user->update([
                'name' => $nombreCompleto,
                'apellido' => $this->primerApellido,
                'segundo_apellido' => $this->segundoApellido,
                'email' => $this->email,
                'telefono' => $this->telefono,
                'foto_de_perfil' => $fotoPath,
            ]);

            session()->flash('success', '¡Perfil actualizado correctamente! 🌸');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar el perfil. Inténtalo nuevamente.');
            \Log::error('Error al actualizar perfil: ' . $e->getMessage());
        }
    }

    public function cambiarContrasena()
    {
        $this->validate($this->passwordRules());

        try {
            $user = auth()->user();

            // Verificar que la contraseña actual sea correcta
            if (!Hash::check($this->currentPassword, $user->password)) {
                $this->addError('currentPassword', 'La contraseña actual es incorrecta');
                return;
            }

            // Actualizar la contraseña
            $user->update([
                'password' => Hash::make($this->newPassword)
            ]);

            // Limpiar campos
            $this->resetPasswordFields();

            session()->flash('success', '¡Contraseña cambiada correctamente! 🔒');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al cambiar la contraseña. Inténtalo nuevamente.');
            \Log::error('Error al cambiar contraseña: ' . $e->getMessage());
        }
    }

    private function resetPasswordFields()
    {
        $this->currentPassword = '';
        $this->newPassword = '';
        $this->newPasswordConfirmation = '';
    }

    public function getPasswordStrength()
    {
        if (empty($this->newPassword)) {
            return 0;
        }

        $score = 0;
        $password = $this->newPassword;

        // Longitud
        if (strlen($password) >= 8) $score += 25;
        
        // Minúsculas
        if (preg_match('/[a-z]/', $password)) $score += 25;
        
        // Mayúsculas
        if (preg_match('/[A-Z]/', $password)) $score += 25;
        
        // Números
        if (preg_match('/[0-9]/', $password)) $score += 25;
        
        // Símbolos
        if (preg_match('/[^A-Za-z0-9]/', $password)) $score += 25;

        return min($score, 100);
    }

    public function getPasswordStrengthText()
    {
        $strength = $this->getPasswordStrength();
        
        if ($strength === 0) return 'Ingresa una contraseña';
        if ($strength <= 25) return 'Muy débil';
        if ($strength <= 50) return 'Débil';
        if ($strength <= 75) return 'Buena';
        return 'Muy fuerte';
    }

    public function getPasswordStrengthColor()
    {
        $strength = $this->getPasswordStrength();
        
        if ($strength <= 25) return 'red';
        if ($strength <= 50) return 'orange';
        if ($strength <= 75) return 'yellow';
        if ($strength > 75) return 'green';
        return 'gray';
    }

    public function render()
    {
        return view('livewire.my-profile-page');
    }
}