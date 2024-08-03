<?php

namespace App\Filament\Pages;

use App\Filament\Resources\HubResource\Widgets\HubStatsWidget;
// use Illuminate\Contracts\View\View;
// use Doctrine\DBAL\Schema\View;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static string $resource = Dashboard::class;

    protected static string $view = 'filament.pages.custom-map';

    public string $testData = 'Hello world';
    
    protected function getHeaderWidgets(): array
    {

        return [
            HubStatsWidget::class,
        ];
    }
}
