<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Filament\Resources\BlogResource\RelationManagers;
use App\Models\Blog;
use Filament\Forms\Components\TextInput;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Set;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

     public static function form(Form $form): Form
    {
        return $form
            ->schema([
               TextInput::make('titulo_blog')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (string $operation, $state, Set $set) => 
                            $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                            TextInput::make('slug')
                                ->maxLength(255)
                                ->required()
                                ->unique(Blog::class, 'slug', ignoreRecord: true),


                Forms\Components\DatePicker::make('fecha')
                    ->required(),

                Forms\Components\FileUpload::make('imagen_destacada')
                    ->image()
                    ->directory('blogs')
                    ->nullable(),

                TinyEditor::make('texto_blog')
                    ->fileAttachmentsDisk('public')
                    ->fileAttachmentsVisibility('public')
                    ->fileAttachmentsDirectory('uploads')
                    ->profile('default|simple|full|minimal|none|custom')
                    ->rtl() // Set RTL or use ->direction('auto|rtl|ltr')
                    ->resize('both')
                    ->columnSpan('full')
                    ->required()
            ]);
    }

    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('imagen_destacada'),
                \Filament\Tables\Columns\TextColumn::make('titulo_blog')->searchable()->sortable(),
                \Filament\Tables\Columns\TextColumn::make('slug')->searchable()->sortable(),
                \Filament\Tables\Columns\TextColumn::make('fecha')->date(),
            ])
            ->filters([])
            ->actions([
                \Filament\Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\DeleteBulkAction::make(),
            ]);
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
