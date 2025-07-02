<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Product Image & Barcode')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(200),
                        Forms\Components\TextInput::make('barcode')
                            ->required()
                            ->maxLength(200),
                        Select::make('status')
                            ->searchable()
                            ->options([
                                'no-contamination' => 'No Contamination',
                                'halal' => 'Halal',
                                'haram' => 'Haram',
                            ])
                            ->required(),
                        Forms\Components\Select::make('company_id')
                            ->searchable()
                            ->preload()
                            ->relationship('company', 'name')
                            ->required(),
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->required()
                            ->columnSpanFull(),
                    ]),
                Section::make('Product Details')
                    ->columns(1)
                    ->schema([
                        RichEditor::make('ingridients')
                            ->required()
                            ->columnSpanFull(),
                        RichEditor::make('allergens')
                            ->required()
                            ->columnSpanFull(),
                    ]),



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Grid::make()
                    ->columns(1)
                    ->schema([
                        Tables\Columns\ImageColumn::make('image')->width(200)->height(150),
                        Tables\Columns\TextColumn::make('name')
                            ->searchable()
                            ->weight('semibold'),
                        Tables\Columns\TextColumn::make('barcode')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('status')->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'no-contamination' => 'gray',
                                'halal' => 'success',
                                'haram' => 'danger',
                            }),
                        Tables\Columns\TextColumn::make('company.name')
                            ->sortable(),
                    ])
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->action(function (Product $record) {
                        // delete image from storage
                        if (Storage::disk('public')->exists($record->image)) {
                            Storage::disk('public')->delete($record->image);
                        }
                        // delete the record
                        $record->delete();
                        // send notification
                        Notification::make()
                            ->title('Product deleted successfully')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->paginated([3, 10, 50, 100, 'all']);
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
