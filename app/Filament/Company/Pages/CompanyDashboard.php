<?php

namespace App\Filament\Company\Pages;

use App\Models\Hub;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Filament\Company\Resources\HubResource;
use App\Filament\Resources\HubResource\Widgets\HubStatsWidget;

class CompanyDashboard extends \Filament\Pages\Dashboard
{
    protected static string $resource = CompanyDashboard::class;

    public $tenantID;
    public array $hubGrids = [];
    public string $hubURLPrefix;
    public $testData = 'test';

    public function mount()
    {
        // Initialize tenantID using Filament's method
        $this->tenantID = Filament::getTenant()->id;

        // Fetch and assign hub grids based on tenantID
        $this->hubGrids = Hub::select('name', 'latitude', 'longitude', 'usage','id')
                             ->where('company_id', $this->tenantID)
                             ->get()
                             ->toArray();

        $this->hubURLPrefix = url(HubResource::getUrl(panel: 'company', tenant: Auth::user()?->personalCompany()));

        Log::info($this->hubURLPrefix);
    }

    protected static string $view = 'filament.pages.custom-map';

    protected function getHeaderWidgets(): array
    {

        return [
            HubStatsWidget::class,
        ];
    }
}
