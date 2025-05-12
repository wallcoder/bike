<?php

namespace App\Filament\Resources\BikeVarientResource\Pages;

use App\Filament\Resources\BikeVarientResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBikeVarients extends ListRecords
{
    protected static string $resource = BikeVarientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
