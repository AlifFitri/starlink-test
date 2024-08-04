<?php

namespace App\Filament\Company\Resources\HubResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Company\Resources\HubResource;
use App\Filament\Resources\HubResource\Widgets\HubStatsWidget;

class ListHubs extends ListRecords
{
    protected static string $resource = HubResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            HubStatsWidget::class
        ];
    }
}
