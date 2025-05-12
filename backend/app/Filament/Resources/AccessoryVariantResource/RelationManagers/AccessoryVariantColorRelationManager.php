<?php

namespace App\Filament\Resources\AccessoryVariantResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AccessoryVariantColorRelationManager extends RelationManager
{
    protected static string $relationship = 'accessoryVariantColor';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
               
                Select::make('color_id')->
                relationship('color', 'name')
                ->searchable()->preload()->required(),

                TextInput::make('price')->numeric()->required(),
                TextInput::make('stock')->numeric()->required(),
                Select::make('status')->options([
                    'available'=>'Available',
                    'unavailable'=>'Unavailable',
                ]),

                 FileUpload::make('image')->image()->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('stock')
            ->columns([
                ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('stock'),
                Tables\Columns\TextColumn::make('color.name'),
                Tables\Columns\TextColumn::make('price'),
                Tables\Columns\TextColumn::make('status')->searchable(),
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
