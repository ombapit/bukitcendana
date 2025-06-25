<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IplResource\Pages;
use App\Filament\Resources\IplResource\RelationManagers;
use App\Models\Ipl;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class IplResource extends Resource
{
    protected static ?string $model = Ipl::class;

    protected static ?string $navigationGroup = 'Keuangan';
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Pembayaran IPL';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('view_any_ipl') ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('warga_id')
                    ->relationship('warga', 'nama')
                    ->searchable()
                    ->required()
                    ->label('Warga'),
                Select::make('bulan')
                    ->options([
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
                        4 => 'April', 5 => 'Mei', 6 => 'Juni',
                        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
                        10 => 'Oktober', 11 => 'November', 12 => 'Desember',
                    ])->required(),
                TextInput::make('tahun')->numeric()->required()->minValue(2000)->maxValue(2100)->default(now()->year)->readonly(),
                TextInput::make('jumlah')->numeric()->required()->label('Jumlah Pembayaran')->default(75000),
                Textarea::make('catatan')
                    ->label('Catatan')
                    ->rows(3)
                    ->maxLength(1000)
                    ->nullable(),                
                DatePicker::make('tanggal_bayar')->label('Tanggal Bayar')->default(date("Y-m-d")),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('warga.nama')->label('Nama Warga')->searchable(),
                TextColumn::make('bulan')->formatStateUsing(fn ($state) => \Carbon\Carbon::create()->month($state)->translatedFormat('F')),
                TextColumn::make('tahun'),
                TextColumn::make('jumlah')
                    ->label('Jumlah (Rp)')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.')),
                TextColumn::make('tanggal_bayar')->date()->label('Tanggal Bayar'),
                TextColumn::make('created_at')->label('Dibuat')->dateTime()->toggleable(),
            ])
            ->headerActions([
                ExportAction::make()
                    ->label('Download Excel'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('bulan')
                    ->label('Filter Bulan')
                    ->options([
                    1 => 'Januari',
                    2 => 'Februari',
                    3 => 'Maret',
                    4 => 'April',
                    5 => 'Mei',
                    6 => 'Juni',
                    7 => 'Juli',
                    8 => 'Agustus',
                    9 => 'September',
                    10 => 'Oktober',
                    11 => 'November',
                    12 => 'Desember',
                    ]),

                Tables\Filters\SelectFilter::make('tahun')
                    ->label('Filter Tahun')
                    ->options(
                        array_combine(
                            range(now()->year, now()->year - 4), // contoh: 2025 → 2021
                            range(now()->year, now()->year - 4)
                        )
                    )
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListIpls::route('/'),
            'create' => Pages\CreateIpl::route('/create'),
            'edit' => Pages\EditIpl::route('/{record}/edit'),
        ];
    }
}
