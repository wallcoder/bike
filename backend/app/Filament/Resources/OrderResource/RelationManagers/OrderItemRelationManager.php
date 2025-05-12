<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderItemRelationManager extends RelationManager
{
    protected static string $relationship = 'orderItem';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
        Forms\Components\TextInput::make('name')
            ->label('Product Name')
            ->required()
            ->maxLength(255),

        Forms\Components\Select::make('accessory_variant_color_id')
            ->relationship('accessoryVariantColor', 'id')
            ->getOptionLabelFromRecordUsing(fn ($record) =>
                "{$record->accessoryVariant->accessory->model} - {$record->accessoryVariant->name} - {$record->color->name}"
            )
            ->searchable()
            ->required()
            ->preload()
            ->label('Accessory')
            ->reactive() // make it reactive to state changes
            ->afterStateUpdated(function ($state, callable $set) {
                // $state is the selected accessory_variant_color_id
                $variantColor = \App\Models\AccessoryVariantColor::find($state);
                if ($variantColor) {
                    $set('price', $variantColor->price);
                }
            }),

        Forms\Components\TextInput::make('description')
            ->required(),

        Forms\Components\TextInput::make('price')
            ->required()
            ->readOnly(),

        Forms\Components\TextInput::make('quantity')
            ->required()->numeric(),
    ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                TextColumn::make('description'),
                TextColumn::make('price'),
                TextColumn::make('quantity'),
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
