<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TunggakanResource\Pages;
use App\Filament\Resources\TunggakanResource\RelationManagers;
use App\Models\Tunggakan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class TunggakanResource extends Resource
{
    protected static ?string $model = Tunggakan::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-refund';
    protected static ?string $navigationGroup = 'Keuangan';
    protected static ?string $navigationLabel = 'Tunggakan IPL';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('alamat')
                    ->limit(20)
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('jumlah_tunggakan')
                    ->label('Tunggakan (bulan)')
                    ->alignCenter()
                    ->sortable()
                    ->numeric(), // agar sorting numerik
            ])
            ->filters([
                SelectFilter::make('jumlah_tunggakan')
                    ->label('Filter Tunggakan')
                    ->options([
                        '1' => '1 Bulan',
                        '2' => '2 Bulan',
                        '3' => '3 Bulan',
                        '3+' => 'Lebih dari 3 Bulan',
                    ])
                    ->modifyQueryUsing(function (Builder $query, $state): Builder {
                        if (blank($state['value'] ?? null)) {
                            return $query;
                        }

                        $value = $state['value'];

                        if ($value === '3+') {
                            return $query->where('jumlah_tunggakan', '>', 3);
                        }

                        return $query->where('jumlah_tunggakan', '=', (int)$value);
                    })
            ])
            ->headerActions([
                ExportAction::make()
                    ->label('Download Excel'),
            ])
            ->defaultSort('jumlah_tunggakan', 'desc') // Default sorting by tunggakan desc
            ->actions([
                // Tambahkan tombol edit jika perlu
            ])
            ->bulkActions([
                // Bulk actions jika diperlukan
            ]);
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTunggakans::route('/'),
            // 'create' => Pages\CreateTunggakan::route('/create'),
            // 'edit' => Pages\EditTunggakan::route('/{record}/edit'),
        ];
    }
}
