<?php

namespace App\Filament\Resources\BikeVariantResource\Pages;

use App\Filament\Resources\BikeVariantResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBikeVariants extends ListRecords
{
    protected static string $resource = BikeVariantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
