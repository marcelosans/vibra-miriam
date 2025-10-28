<?php

namespace App\Filament\Resources\SocialMediaResource\Pages;

use App\Filament\Resources\SocialMediaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSocialMedia extends CreateRecord
{
    protected static string $resource = SocialMediaResource::class;
     public function getTitle(): string
    {
        return 'Crear Red Social';
    }

    
    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Red social creada exitosamente';
    }
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // El modelo ahora maneja automáticamente el formateo en el evento saving()
        // Pero podemos hacer validaciones adicionales aquí si es necesario
        
        return $data;
    }
}
