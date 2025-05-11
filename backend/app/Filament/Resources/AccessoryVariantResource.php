<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccessoryVariantResource\Pages;
use App\Filament\Resources\AccessoryVariantResource\RelationManagers;
use App\Models\AccessoryVariant;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AccessoryVariantResource extends Resource
{
    protected static ?string $model = AccessoryVariant::class;

    protected static ?string $navigationIcon = 'heroicon-o-face-frown';
    protected static ?string $navigationGroup = 'Accessories';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('accessory_id')->relationship('accessory', 'model')
                ->searchable()->preload()->required(),
                TextInput::make('weight')->numeric()->required(),
                TextInput::make('material')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('accessory.model'),
                TextColumn::make('weight'),
                TextColumn::make('material'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
           RelationManagers\AccessoryVariantColorRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccessoryVariants::route('/'),
            'create' => Pages\CreateAccessoryVariant::route('/create'),
            'edit' => Pages\EditAccessoryVariant::route('/{record}/edit'),
        ];
    }
}
