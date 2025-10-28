<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SocialMediaResource\Pages;
use App\Filament\Resources\SocialMediaResource\RelationManagers;
use App\Models\SocialMedia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SocialMediaResource extends Resource
{
    protected static ?string $model = SocialMedia::class;

     protected static ?string $navigationIcon = 'heroicon-o-share';
    
    protected static ?string $navigationLabel = 'Redes Sociales';
    
    protected static ?string $modelLabel = 'Red Social';
    
    protected static ?string $pluralModelLabel = 'Redes Sociales';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información de la Red Social')
                    ->schema([
                        Forms\Components\TextInput::make('nombre')
                            ->label('Nombre de la Red Social')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-hashtag')
                            ->placeholder('Instagram, Facebook, Twitter, LinkedIn...')
                            ->datalist([
                                'Instagram',
                                'Facebook', 
                                'Twitter/X',
                                'LinkedIn',
                                'TikTok',
                                'YouTube',
                                'WhatsApp',
                                'Telegram',
                                'Discord',
                                'Twitch'
                            ])
                            ->columnSpan(1),
                            
                        Forms\Components\TextInput::make('usuario')
                            ->label('Usuario/Handle')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-at-symbol')
                            ->placeholder('@miusuario, usuario123, mi.usuario...')
                            ->helperText('Incluye el @ si es necesario')
                            ->columnSpan(1),
                            
                        Forms\Components\Textarea::make('icono_svg')
                            ->label('Código del Icono')
                            ->rows(4)
                            ->placeholder('Pega aquí el código SVG, FontAwesome, o URL del icono')
                            ->helperText('Puede ser código SVG, clase de FontAwesome (fa-instagram), o URL de imagen')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                    
                Forms\Components\Section::make('Vista Previa')
                    ->schema([
                        Forms\Components\Placeholder::make('preview')
                            ->label('')
                            ->content(function (Forms\Get $get) {
                                $nombre = $get('nombre');
                                $usuario = $get('usuario');
                                $icono = $get('icono_svg');
                                
                                if (!$nombre || !$usuario) {
                                    return 'Complete los campos para ver la vista previa';
                                }
                                
                                $iconoHtml = '';
                                if ($icono) {
                                    if (str_contains($icono, '<svg')) {
                                        $iconoHtml = $icono;
                                    } elseif (str_starts_with($icono, 'fa-')) {
                                        $iconoHtml = "<i class='fas {$icono}'></i>";
                                    } elseif (filter_var($icono, FILTER_VALIDATE_URL)) {
                                        $iconoHtml = "<img src='{$icono}' alt='{$nombre}' style='width: 24px; height: 24px;'>";
                                    } else {
                                        $iconoHtml = "<span>{$icono}</span>";
                                    }
                                }
                                
                                return new \Illuminate\Support\HtmlString("
                                    <div style='display: flex; align-items: center; gap: 10px; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; background: #f8fafc;'>
                                        <div style='width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;'>
                                            {$iconoHtml}
                                        </div>
                                        <div>
                                            <div style='font-weight: bold;'>{$nombre}</div>
                                            <div style='color: #6b7280; font-size: 14px;'>{$usuario}</div>
                                        </div>
                                    </div>
                                ");
                            })
                    ])
                    ->collapsible()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Red Social')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->color('primary'),
                    
                Tables\Columns\TextColumn::make('usuario')
                    ->label('Usuario')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Usuario copiado')
                    ->badge()
                    ->color('gray'),
                    
                Tables\Columns\TextColumn::make('icono_svg')
                    ->label('Icono')
                    ->limit(30)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (!$state || strlen($state) <= 30) {
                            return null;
                        }
                        return $state;
                    })
                    ->placeholder('Sin icono')
                    ->formatStateUsing(function ($state) {
                        if (!$state) return 'Sin icono';
                        
                        if (str_contains($state, '<svg')) {
                            return 'Código SVG';
                        } elseif (str_starts_with($state, 'fa-')) {
                            return "FontAwesome ({$state})";
                        } elseif (filter_var($state, FILTER_VALIDATE_URL)) {
                            return 'URL de imagen';
                        }
                        
                        return 'Código personalizado';
                    }),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Creación')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Última Actualización')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('nombre')
                    ->label('Red Social')
                    ->options(function () {
                        return SocialMedia::distinct('nombre')
                            ->pluck('nombre', 'nombre')
                            ->toArray();
                    })
                    ->searchable(),
                    
                Tables\Filters\Filter::make('con_icono')
                    ->label('Con icono')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('icono_svg')),
                    
                Tables\Filters\Filter::make('sin_icono')
                    ->label('Sin icono')
                    ->query(fn (Builder $query): Builder => $query->whereNull('icono_svg')),
                    
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Creado desde'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Creado hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                
                Tables\Actions\Action::make('copiar_info')
                    ->label('Copiar Info')
                    ->icon('heroicon-o-clipboard')
                    ->action(function ($record) {
                        // Aquí podrías implementar lógica para copiar la información completa
                    })
                    ->color('gray'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    
                    Tables\Actions\BulkAction::make('export')
                        ->label('Exportar seleccionados')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->action(function ($records) {
                            // Implementar lógica de exportación
                        }),
                        
                    Tables\Actions\BulkAction::make('generar_tarjetas')
                        ->label('Generar Tarjetas')
                        ->icon('heroicon-o-credit-card')
                        ->action(function ($records) {
                            // Implementar generación de tarjetas de redes sociales
                        })
                        ->color('success'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordUrl(null); // Deshabilita el clic en filas para ir a edit
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSocialMedia::route('/'),
            'create' => Pages\CreateSocialMedia::route('/create'),
            'edit' => Pages\EditSocialMedia::route('/{record}/edit'),
        ];
    }
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    
    public static function getNavigationSort(): ?int
    {
        return 2;
    }
}
