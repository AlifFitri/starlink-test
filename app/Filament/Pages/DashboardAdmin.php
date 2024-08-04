<?php

namespace App\Filament\Pages;

use App\Models\Hub;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\HubResource;
use App\Filament\Resources\HubResource\Widgets\HubStatsWidget;
// use Illuminate\Contracts\View\View;
// use Doctrine\DBAL\Schema\View;

class DashboardAdmin extends \Filament\Pages\Dashboard
{
    protected static string $resource = DashboardAdmin::class;

    protected static string $view = 'filament.pages.custom-map';

    public $tenantID;
    public array $hubGrids = [];
    public string $hubURLPrefix;
    public $testData = 'test';

    public function mount()
    {
        // Fetch and assign hub grids based on tenantID
        $this->hubGrids = Hub::select('name', 'latitude', 'longitude', 'usage','id')
                             ->get()
                             ->toArray();

        $this->hubURLPrefix = url(HubResource::getUrl());

        Log::info($this->hubURLPrefix);
    }

    protected function getHeaderWidgets(): array
    {

        return [
            HubStatsWidget::class,
        ];
    }
}
