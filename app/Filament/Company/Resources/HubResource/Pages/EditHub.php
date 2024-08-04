<?php

namespace App\Filament\Company\Resources\HubResource\Pages;

use App\Filament\Company\Resources\HubResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHub extends EditRecord
{
    protected static string $resource = HubResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
