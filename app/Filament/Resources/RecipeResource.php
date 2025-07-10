<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecipeResource\Pages;
use App\Filament\Resources\RecipeResource\RelationManagers;
use App\Models\Recipe;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RecipeResource extends Resource
{
    protected static ?string $model = Recipe::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Recipe Information')
                    ->columns(1)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(200),
                        Forms\Components\TextInput::make('video')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Radio::make('status')
                            ->inline()
                            ->inlineLabel(false)
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                            ])
                            ->required(),
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->required(),

                    ]),

                Section::make('Recipe Detail')
                    ->columns(1)
                    ->schema([
                        Forms\Components\RichEditor::make('description')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('ingridients')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('allergens')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make('Recipe Steps')
                    ->columns(1)
                    ->schema([
                        Forms\Components\Repeater::make('steps')
                            ->relationship()
                            ->schema([
                                Forms\Components\RichEditor::make('description')
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\FileUpload::make('image')
                                    ->image()
                                    ->columnSpanFull(),
                            ]),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('steps_count')->counts('steps')
                    ->label('Steps'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListRecipes::route('/'),
            'create' => Pages\CreateRecipe::route('/create'),
            'edit' => Pages\EditRecipe::route('/{record}/edit'),
        ];
    }
}
