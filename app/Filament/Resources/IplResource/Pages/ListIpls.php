<?php

namespace App\Filament\Resources\IplResource\Pages;

use App\Filament\Resources\IplResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIpls extends ListRecords
{
    protected static string $resource = IplResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
