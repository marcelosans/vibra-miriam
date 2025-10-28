<?php

namespace App\Filament\Resources\SocialMediaResource\Pages;

use App\Filament\Resources\SocialMediaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSocialMedia extends ListRecords
{
    protected static string $resource = SocialMediaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nueva Red Social')
                ->icon('heroicon-o-plus'),
                
            Actions\Action::make('importar')
                ->label('Importar Redes')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('gray')
                ->action(function () {
                    // Implementar lógica de importación
                }),
        ];
    }

    public function getTitle(): string
    {
        return 'Redes Sociales';
    }
    
    protected function getHeaderWidgets(): array
    {
        return [
            // Aquí podrías agregar widgets de estadísticas
        ];
    }
}
