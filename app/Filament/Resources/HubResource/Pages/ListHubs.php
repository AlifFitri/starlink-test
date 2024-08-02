<?php

namespace App\Filament\Resources\HubResource\Pages;

use App\Filament\Resources\HubResource;
use App\Filament\Resources\HubResource\Widgets\HubStatsWidget;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

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
