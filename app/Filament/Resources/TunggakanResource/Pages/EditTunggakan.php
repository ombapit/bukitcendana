<?php

namespace App\Filament\Resources\TunggakanResource\Pages;

use App\Filament\Resources\TunggakanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTunggakan extends EditRecord
{
    protected static string $resource = TunggakanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
