<?php

namespace App\Filament\Resources\Branches\Pages;

use App\Filament\Resources\Branches\BranchResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBranches extends ListRecords
{
    protected static string $resource = BranchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('buka_peta_gis')
                ->label('Buka Peta GIS Interaktif')
                ->icon('heroicon-o-map')
                ->color('gray')
                ->url(url('/peta')),
            CreateAction::make()
                ->label('+ Pin-Point Kantor / Posko Baru')
                ->icon('heroicon-o-map-pin'),
        ];
    }
}
