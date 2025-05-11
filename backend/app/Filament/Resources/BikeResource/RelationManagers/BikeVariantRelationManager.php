<?php

namespace App\Filament\Resources\BikeResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BikeVariantRelationManager extends RelationManager
{
    protected static string $relationship = 'bikeVariant';

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('mileage')->required()->numeric(),
                Forms\Components\TextInput::make('engine_capacity')->required()->numeric(),
                Forms\Components\TextInput::make('transmission')->required()->numeric(),
                Forms\Components\TextInput::make('kerb_weight')->required()->numeric(),
                Forms\Components\TextInput::make('fuel_tank_capacity')->required()->numeric(),
                Forms\Components\TextInput::make('seat_height')->required()->numeric(),
                
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('mileage')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('mileage'),
                Tables\Columns\TextColumn::make('engine_capacity'),
                Tables\Columns\TextColumn::make('transmission'),
                Tables\Columns\TextColumn::make('kerb_weight'),
                Tables\Columns\TextColumn::make('fuel_tank_capacity'),
                Tables\Columns\TextColumn::make('seat_height'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
