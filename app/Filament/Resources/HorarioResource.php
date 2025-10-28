<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HorarioResource\Pages;
use App\Models\Horario;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class HorarioResource extends Resource
{
    protected static ?string $model = Horario::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationLabel = 'Horarios';

    protected static ?string $modelLabel = 'Horario';

    protected static ?string $pluralModelLabel = 'Horarios';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('dia_de_la_semana')
                    ->label('Día de la Semana')
                    ->options([
                        'Lunes' => 'Lunes',
                        'Martes' => 'Martes',
                        'Miércoles' => 'Miércoles',
                        'Jueves' => 'Jueves',
                        'Viernes' => 'Viernes',
                        'Sábado' => 'Sábado',
                        'Domingo' => 'Domingo',
                    ])
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\Toggle::make('laborable')
                    ->label('Día Laborable')
                    ->default(true)
                    ->inline(false),

                Forms\Components\Section::make('Horario de Mañana')
                    ->schema([
                        Forms\Components\TimePicker::make('horario_ini_manana')
                            ->label('Hora Inicio')
                            ->seconds(false)
                            ->nullable(),

                        Forms\Components\TimePicker::make('horario_final_manana')
                            ->label('Hora Final')
                            ->seconds(false)
                            ->nullable()
                            ->after('horario_ini_manana'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Forms\Components\Section::make('Horario de Tarde')
                    ->schema([
                        Forms\Components\TimePicker::make('horario_ini_tarde')
                            ->label('Hora Inicio')
                            ->seconds(false)
                            ->nullable(),

                        Forms\Components\TimePicker::make('horario_final_tarde')
                            ->label('Hora Final')
                            ->seconds(false)
                            ->nullable()
                            ->after('horario_ini_tarde'),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('dia_de_la_semana')
                    ->label('Día')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Lunes' => 'primary',
                        'Martes' => 'success',
                        'Miércoles' => 'warning',
                        'Jueves' => 'danger',
                        'Viernes' => 'info',
                        'Sábado' => 'gray',
                        'Domingo' => 'gray',
                        default => 'gray',
                    }),

                Tables\Columns\IconColumn::make('laborable')
                    ->label('Laborable')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('horario_manana')
                    ->label('Horario Mañana')
                    ->getStateUsing(function (Horario $record): ?string {
                        if ($record->horario_ini_manana && $record->horario_final_manana) {
                            return $record->horario_ini_manana . ' - ' . $record->horario_final_manana;
                        }
                        return 'No definido';
                    })
                    ->color(fn ($state) => $state === 'No definido' ? 'gray' : 'success'),

                Tables\Columns\TextColumn::make('horario_tarde')
                    ->label('Horario Tarde')
                    ->getStateUsing(function (Horario $record): ?string {
                        if ($record->horario_ini_tarde && $record->horario_final_tarde) {
                            return $record->horario_ini_tarde . ' - ' . $record->horario_final_tarde;
                        }
                        return 'No definido';
                    })
                    ->color(fn ($state) => $state === 'No definido' ? 'gray' : 'success'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('laborable')
                    ->label('Día laborable')
                    ->boolean()
                    ->trueLabel('Solo días laborables')
                    ->falseLabel('Solo días no laborables')
                    ->native(false),

                Tables\Filters\Filter::make('con_horario_manana')
                    ->label('Con horario de mañana')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('horario_ini_manana')->whereNotNull('horario_final_manana')),

                Tables\Filters\Filter::make('con_horario_tarde')
                    ->label('Con horario de tarde')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('horario_ini_tarde')->whereNotNull('horario_final_tarde')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('dia_de_la_semana')
            ->striped();
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
            'index' => Pages\ListHorarios::route('/'),
            'create' => Pages\CreateHorario::route('/create'),
        
            'edit' => Pages\EditHorario::route('/{record}/edit'),
        ];
    }
}