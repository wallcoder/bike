<?php

namespace App\Filament\Resources\AccessoryVariantResource\Pages;

use App\Filament\Resources\AccessoryVariantResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccessoryVariants extends ListRecords
{
    protected static string $resource = AccessoryVariantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
