<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-x-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('phone')->required(),
                TextInput::make('email')->required(),
                Textarea::make('note')->required(),
                DateTimePicker::make('appointment_time'),
                Select::make('bike_variant_color_id')->label('Bike')
                ->relationship('bikeVariantColor', 'id') // or any column, doesn't matter when using getOptionLabelFromRecordUsing
                ->getOptionLabelFromRecordUsing(fn ($record) => 
                    "{$record->bikeVariant->bike->brand->name} - {$record->bikeVariant->bike->model} - {$record->bikeVariant->name} - {$record->color->name}"
                )->preload()
                ->searchable(),
                Select::make('type')->options([
                    'purchase'=>'Purchase',
                    'servicing'=>'Servicing'
                ])->default('purchase')->required(),
                Select::make('status')->options([

                    'pending'=>'Pending',
                    'confirmed'=>'Confirmed',
                    'waiting'=>'Waiting',
                    'cancelled'=>'Cancelled',
                    'completed'=>'Completed',
                    'absent'=>'Absent'
                ])->required()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                 ImageColumn::make('bikeVariantColor.image')->label("Image"),
                TextColumn::make('name'),
                TextColumn::make('phone'),
                TextColumn::make('email'),
                TextColumn::make('bikeVariantColor.bikeVariant.bike.model')->label('Model'),
                TextColumn::make('type'),
                TextColumn::make('status'),
                ColorColumn::make('bikeVariantColor.color.code')->label("color"),
                TextColumn::make('appointment_time')
               
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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
