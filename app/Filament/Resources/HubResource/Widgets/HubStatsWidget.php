<?php

namespace App\Filament\Resources\HubResource\Widgets;

use App\Models\Hub;
use App\Models\Company;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Log;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Wallo\FilamentCompanies\FilamentCompanies;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class HubStatsWidget extends BaseWidget
{

    protected function getStats(): array
    {
        // Get the current panel & tenant id
        $panelID = Filament::getCurrentPanel()->getId();
        $tenantID = $panelID != 'admin' ? Filament::getTenant()->id : null;

        $totalUsage = Hub::when($tenantID, function ($query, $tenantID) {
            return $query->where('company_id', $tenantID);
        })->sum('usage');

        $totalConnections = Hub::when($tenantID, function ($query, $tenantID) {
            return $query->where('company_id', $tenantID);
        })->sum('connection');

        $averageUsage = $totalConnections > 0 ? round($totalUsage / $totalConnections, 2) : 0;

        return [
            Stat::make('Hubs', Hub::when($tenantID,
                function ($query, $tenantID)
                {
                    return $query->where('company_id', $tenantID);
                })
                ->count()),
            Stat::make('Usage', round($totalUsage, 3))
                ->description('Terabytes')
                ->descriptionIcon('heroicon-m-server-stack'),
            Stat::make( 'Avg Usage / Connection', $averageUsage )
                ->description('Total ' . Hub::where('company_id', $tenantID)->sum('connection') . ' connection(s).')
                ->descriptionIcon('heroicon-m-server-stack'),
        ];
    }
}
