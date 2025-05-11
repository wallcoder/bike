<?php

namespace App\Filament\Resources\AccessoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AccessoryVariantRelationManager extends RelationManager
{
    protected static string $relationship = 'accessoryVariant';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                 TextInput::make('name'),
                Forms\Components\TextInput::make('material')
                    ->required()
                    ->maxLength(255),
                TextInput::make('weight')->numeric(),
               
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('material')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('material'),
                Tables\Columns\TextColumn::make('weight'),
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
