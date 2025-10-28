<?php

namespace App\Filament\Resources\SocialMediaResource\Pages;

use App\Filament\Resources\SocialMediaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSocialMedia extends EditRecord
{
    protected static string $resource = SocialMediaResource::class;

   protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            
            Actions\Action::make('duplicar')
                ->label('Duplicar')
                ->icon('heroicon-o-document-duplicate')
                ->action(function () {
                    $newRecord = $this->record->replicate();
                    $newRecord->usuario = $newRecord->usuario . '_copia';
                    $newRecord->save();
                })
                ->color('gray'),
        ];
    }

    public function getTitle(): string
    {
        return 'Editar Red Social';
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Red social actualizada exitosamente';
    }
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // El modelo maneja automáticamente la limpieza en el evento saving()
        return $data;
    }
}
