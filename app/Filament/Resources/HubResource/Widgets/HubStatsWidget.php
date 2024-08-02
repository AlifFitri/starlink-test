<?php

namespace App\Filament\Resources\HubResource\Widgets;

use App\Models\Hub;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Log;

class HubStatsWidget extends BaseWidget
{

    protected function getStats(): array
    {
        return [
            Stat::make('Hub', Hub::count()),
            Stat::make('Usage', round(Hub::sum('usage'), 3))
                ->description('Terabytes')
                ->descriptionIcon('heroicon-m-server-stack'),
            Stat::make( 'Avg Usage / Connection', round(Hub::sum('usage')/Hub::sum('connection'), 2) )
                ->description('Total ' . Hub::sum('connection') . ' connection(s).')
                ->descriptionIcon('heroicon-m-server-stack'),
        ];
    }
}
