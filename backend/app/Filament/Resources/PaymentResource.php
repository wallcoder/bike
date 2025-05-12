<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
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

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Transactions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('order_id')->relationship('order', 'id')
                ->getOptionLabelFromRecordUsing(fn ($record)=>
                "{$record->id} - {$record->user->email} - {$record->created_at}"
            )->required()->preload()->searchable(),

            TextInput::make('ref_id'),
            Select::make('method')->options([
                'upi'=>'UPI',
                'card'=>'Card',
                'cash'=>'Cash',

            ])->required()->preload(),

             Select::make('status')->options([
                'pending'=>'Pending',
                'success'=>'Success',
                'failure'=>'Failure',

            ])->required()->preload(),

            TextInput::make('amount')->numeric()->required()

            
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                
                TextColumn::make('order_id')->searchable(),
                TextColumn::make('order.user.name')->searchable(),
                TextColumn::make('order.user.email')->searchable(),
                TextColumn::make('ref_id')->searchable(),
                TextColumn::make('method')->searchable(),
                TextColumn::make('status')->searchable(),
                TextColumn::make('amount'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
