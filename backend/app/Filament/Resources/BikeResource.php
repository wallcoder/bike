<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BikeResource\Pages;
use App\Filament\Resources\BikeResource\RelationManagers;
use App\Models\Bike;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BikeResource extends Resource
{
    protected static ?string $model = Bike::class;

    protected static ?string $navigationIcon = 'heroicon-o-square-2-stack';
    protected static ?string $navigationGroup = 'Bikes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('model')->required(),
                Select::make('brand_id')->relationship('brand', 'name')
                ->searchable()->preload()
                ->createOptionForm([
                    TextInput::make('name')->required(),
                    FileUpload::make('image')->image()->required(),
                ]),
                Textarea::make('description')->required(),
                
                FileUpload::make('image')->image()->required(),
                TextInput::make('base_price')->numeric()->required()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image'),
                TextColumn::make('model'),
                TextColumn::make('brand.name'),
                TextColumn::make('description'),
                TextColumn::make('slug'),
                TextColumn::make('base_price'),
                
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
            RelationManagers\BikeVariantRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBikes::route('/'),
            'create' => Pages\CreateBike::route('/create'),
            'edit' => Pages\EditBike::route('/{record}/edit'),
        ];
    }
}
