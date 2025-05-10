<?php

namespace App\Filament\Resources\BikeVariantResource\Pages;

use App\Filament\Resources\BikeVariantResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBikeVariant extends EditRecord
{
    protected static string $resource = BikeVariantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
