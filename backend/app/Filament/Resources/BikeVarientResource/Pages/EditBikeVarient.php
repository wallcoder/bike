<?php

namespace App\Filament\Resources\BikeVarientResource\Pages;

use App\Filament\Resources\BikeVarientResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBikeVarient extends EditRecord
{
    protected static string $resource = BikeVarientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
