<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BikeVariantResource\Pages;
use App\Filament\Resources\BikeVariantResource\RelationManagers;
use App\Models\BikeVariant;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BikeVariantResource extends Resource
{
    protected static ?string $model = BikeVariant::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Bikes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('bike_id')->relationship('bike', 'model')
                ->searchable()->preload(),

                 Forms\Components\TextInput::make('mileage')->required()->numeric(),
                Forms\Components\TextInput::make('engine_capacity')->required()->numeric(),
                Forms\Components\TextInput::make('transmission')->required()->numeric(),
                Forms\Components\TextInput::make('kerb_weight')->required()->numeric(),
                Forms\Components\TextInput::make('fuel_tank_capacity')->required()->numeric(),
                Forms\Components\TextInput::make('seat_height')->required()->numeric(),
                
    
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('bike.model')->label('Bike Model')->searchable(),
                Tables\Columns\TextColumn::make('mileage'),
                Tables\Columns\TextColumn::make('engine_capacity'),
                Tables\Columns\TextColumn::make('transmission'),
                Tables\Columns\TextColumn::make('kerb_weight'),
                Tables\Columns\TextColumn::make('fuel_tank_capacity'),
                Tables\Columns\TextColumn::make('seat_height'),
                //
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
            RelationManagers\BikeVariantColorRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBikeVariants::route('/'),
            'create' => Pages\CreateBikeVariant::route('/create'),
            'edit' => Pages\EditBikeVariant::route('/{record}/edit'),
        ];
    }
}
