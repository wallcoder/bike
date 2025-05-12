<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
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

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';
    protected static ?string $navigationGroup = 'Transactions';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')->relationship('user', 'id')->getOptionLabelFromRecordUsing(fn ($record)=>
                "{$record->name} - {$record->email}"
                )->searchable()->required()->preload(),
                TextInput::make('total')->numeric()->required(),
                Select::make('status')->options([
                    'pending'=>'pending',
                    'shipped'=>'shipped',
                    'delivered'=>'delivered',
                    'cancelled'=>'cancelled'
                ]),
                TextInput::make('full_name')->required(),
                TextInput::make('phone')->numeric()->required(),
                TextInput::make('street')->required(),
                TextInput::make('city')->required(),
                TextInput::make('state')->required(),
                TextInput::make('postal_code')->required(),
                TextInput::make('country')->required(),
            
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name'),
                TextColumn::make('phone')->label('Phone'),
                TextColumn::make('user.email')->label('Email'),
                TextColumn::make('total'),
                TextColumn::make('status'),
                TextColumn::make('street'),
                TextColumn::make('city'),
                TextColumn::make('state'),
                TextColumn::make('postal_code'),
                TextColumn::make('country'),
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
            RelationManagers\OrderItemRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
