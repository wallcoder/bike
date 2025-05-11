<?php

namespace App\Filament\Resources\AccessoryVariantResource\Pages;

use App\Filament\Resources\AccessoryVariantResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccessoryVariant extends EditRecord
{
    protected static string $resource = AccessoryVariantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
