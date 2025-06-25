<?php

namespace App\Filament\Resources\TunggakanResource\Pages;

use App\Filament\Resources\TunggakanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTunggakans extends ListRecords
{
    protected static string $resource = TunggakanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
