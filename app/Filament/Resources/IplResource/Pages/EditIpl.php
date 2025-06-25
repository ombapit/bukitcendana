<?php

namespace App\Filament\Resources\IplResource\Pages;

use App\Filament\Resources\IplResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIpl extends EditRecord
{
    protected static string $resource = IplResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
