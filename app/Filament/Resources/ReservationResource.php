<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Models\Reservation;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\AppointmentConfirmed;
use App\Mail\AppointmentCanceled;
use App\Mail\AppointmentFinished;
use Carbon\Carbon;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    
    protected static ?string $navigationLabel = 'Reservaciones';
    
    protected static ?string $modelLabel = 'Reservación';
    
    protected static ?string $pluralModelLabel = 'Reservaciones';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información de la Reservación')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Usuario')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\DatePicker::make('appointment_date')
                            ->label('Fecha de la Cita')
                            ->required()
                            ->minDate(now())
                            ->displayFormat('d/m/Y'),

                        Forms\Components\TimePicker::make('appointment_time')
                            ->label('Hora de la Cita')
                            ->required()
                            ->seconds(false)
                            ->displayFormat('H:i'),

                        Forms\Components\Select::make('status')
                            ->label('Estado')
                            ->options([
                                Reservation::ESTADO_PENDIENTE => 'Pendiente',
                                Reservation::ESTADO_CONFIRMADO => 'Confirmado',
                                Reservation::ESTADO_CANCELADO => 'Cancelado',
                                Reservation::ESTADO_FINALIZADO => 'Finalizado',
                            ])
                            ->default(Reservation::ESTADO_PENDIENTE)
                            ->required()
                            ->afterStateUpdated(function ($state, $record, $get) {
                                if (!$record || !$record->exists) {
                                    return; // No enviar emails en registros nuevos
                                }

                                // Obtener el estado anterior
                                $oldState = $record->getOriginal('status');
                                
                                // Solo enviar email si el estado realmente cambió
                                if ($oldState === $state) {
                                    return;
                                }

                                $user = $record->user;
                                $date = $record->date;
                                if (!$user || !$user->email) {
                                    return;
                                }

                                try {
                                    switch ($state) {
                                        case Reservation::ESTADO_CANCELADO:
                                            Mail::to($user->email)->send(new AppointmentCanceled($record->user,$record->date,$record->time));
                                            break;
                                        case Reservation::ESTADO_FINALIZADO:
                                            Mail::to($user->email)->send(new AppointmentFinished($record->user,$record->date,$record->time));
                                            break;
                                    }
                                } catch (\Exception $e) {
                                    // Log del error pero no interrumpir el flujo
                                    Log::error('Error enviando email de reservación: ' . $e->getMessage());
                                }
                            })
                            ->live() // Para que se actualice en tiempo real
                            ->helperText(function ($record) {
                                if (!$record) return '';
                                
                                $messages = [];
                                
                                if ($record->sePuedeCancelar()) {
                                    $messages[] = '✅ Se puede cancelar';
                                } else {
                                    $messages[] = '❌ No se puede cancelar';
                                }
                                
                                if ($record->sePuedeFinalizar()) {
                                    $messages[] = '✅ Se puede finalizar';
                                } else {
                                    $messages[] = '❌ No se puede finalizar';
                                }
                                
                                return implode(' | ', $messages);
                            }),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Información Adicional')
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Creado')
                            ->content(fn ($record): string => $record?->created_at?->diffForHumans() ?? '-'),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Actualizado')
                            ->content(fn ($record): string => $record?->updated_at?->diffForHumans() ?? '-'),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuario')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('appointment_date')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('appointment_time')
                    ->label('Hora')
                    ->time('H:i')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Estado')
                    ->colors([
                        'warning' => Reservation::ESTADO_PENDIENTE,
                        'success' => Reservation::ESTADO_CONFIRMADO,
                        'danger' => Reservation::ESTADO_CANCELADO,
                        'secondary' => Reservation::ESTADO_FINALIZADO,
                    ])
                    ->icons([
                        'heroicon-o-clock' => Reservation::ESTADO_PENDIENTE,
                        'heroicon-o-check-circle' => Reservation::ESTADO_CONFIRMADO,
                        'heroicon-o-x-circle' => Reservation::ESTADO_CANCELADO,
                        'heroicon-o-archive-box' => Reservation::ESTADO_FINALIZADO,
                    ])
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            Reservation::ESTADO_PENDIENTE => 'Pendiente',
                            Reservation::ESTADO_CONFIRMADO => 'Confirmado',
                            Reservation::ESTADO_CANCELADO => 'Cancelado',
                            Reservation::ESTADO_FINALIZADO => 'Finalizado',
                            default => $state,
                        };
                    }),

                Tables\Columns\IconColumn::make('es_hoy')
                    ->label('Hoy')
                    ->getStateUsing(fn ($record) => $record->esHoy())
                    ->boolean()
                    ->trueIcon('heroicon-o-calendar')
                    ->falseIcon('')
                    ->trueColor('warning'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options(Reservation::getEstados()),

                Tables\Filters\Filter::make('fecha_rango')
                    ->form([
                        Forms\Components\DatePicker::make('desde')
                            ->label('Desde'),
                        Forms\Components\DatePicker::make('hasta')
                            ->label('Hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['desde'],
                                fn (Builder $query, $date): Builder => $query->whereDate('appointment_date', '>=', $date),
                            )
                            ->when(
                                $data['hasta'],
                                fn (Builder $query, $date): Builder => $query->whereDate('appointment_date', '<=', $date),
                            );
                    }),

                Tables\Filters\TernaryFilter::make('es_hoy')
                    ->label('Es Hoy')
                    ->queries(
                        true: fn (Builder $query) => $query->whereDate('appointment_date', today()),
                        false: fn (Builder $query) => $query->whereDate('appointment_date', '!=', today()),
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                
                Tables\Actions\Action::make('cancelar')
                    ->label('Cancelar')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn ($record) => $record->sePuedeCancelar())
                    ->requiresConfirmation()
                    ->modalHeading('Cancelar Reservación')
                    ->modalDescription('¿Estás seguro de que deseas cancelar esta reservación? Se enviará un email de notificación al cliente.')
                    ->action(function ($record) {
                        $record->cancelar();
                        
                        if ($record->user && $record->user->email) {
                            try {
                                Mail::to($record->user->email)->send(new AppointmentCanceled($record->user,$record->appointment_date,$record->appointment_time));
                            } catch (\Exception $e) {
                                Log::error('Error enviando email de cancelación: ' . $e->getMessage());
                            }
                        }
                    }),

                Tables\Actions\Action::make('finalizar')
                    ->label('Finalizar')
                    ->icon('heroicon-o-archive-box')
                    ->color('secondary')
                    ->visible(fn ($record) => $record->sePuedeFinalizar())
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->finalizar();
                        
                        if ($record->user && $record->user->email) {
                            try {
                                Mail::to($record->user->email)->send(new AppointmentFinished($record->user,$record->appointment_date,$record->appointment_time));
                            } catch (\Exception $e) {
                                Log::error('Error enviando email de finalización: ' . $e->getMessage());
                            }
                        }
                    }),
            ])
            ->bulkActions([
               
            ])
            ->defaultSort('appointment_date', 'desc');
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
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['user']);
    }
}