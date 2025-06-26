<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiKeuanganResource\Pages;
use App\Filament\Resources\TransaksiKeuanganResource\RelationManagers;
use App\Models\TransaksiKeuangan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class TransaksiKeuanganResource extends Resource
{
    protected static ?string $model = TransaksiKeuangan::class;

    protected static ?string $navigationGroup = 'Keuangan';
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Transaksi Keuangan';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('view_any_transaksi::keuangan') ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->required()
                    ->default(now()),

                Radio::make('tipe')
                    ->label('Tipe Transaksi')
                    ->options([
                        'pemasukan' => 'Pemasukan',
                        'pengeluaran' => 'Pengeluaran',
                    ])
                    ->inline()
                    ->required(),

                TextInput::make('kategori')
                    ->required()
                    ->maxLength(100),

                Textarea::make('deskripsi')
                    ->label('Catatan')
                    ->rows(3)
                    ->maxLength(500),

                TextInput::make('jumlah')
                    ->label('Jumlah (Rp)')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                FileUpload::make('bukti')
                    ->label('Upload Bukti')
                    ->directory('bukti-transaksi')
                    ->preserveFilenames()
                    ->maxSize(2048) // max 2MB
                    ->acceptedFileTypes(['application/pdf', 'image/*']) // PDF & gambar
                    ->downloadable()
                    ->openable()
                    ->previewable(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->default(date('Y-m-d'))
                    ->sortable(),

                TextColumn::make('tipe')
                    ->label('Tipe')
                    ->badge()
                    ->colors([
                        'success' => 'pemasukan',
                        'danger' => 'pengeluaran',
                    ])
                    ->sortable(),

                TextColumn::make('kategori')
                    ->label('Kategori')
                    ->searchable(),

                TextColumn::make('jumlah')
                    ->label('Jumlah (Rp)')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.'))
                    ->sortable(),

                TextColumn::make('deskripsi')
                    ->label('Catatan')
                    ->limit(30)
                    ->wrap()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('tipe')
                    ->label('Jenis Transaksi')
                    ->options([
                        'pemasukan' => 'Pemasukan',
                        'pengeluaran' => 'Pengeluaran',
                    ]),
            ])
            ->defaultSort('tanggal', 'desc')
            ->headerActions([
                Action::make('total')
                    ->label('Total Pemasukan & Pengeluaran')
                    ->disabled()
                    ->color('gray')
                    ->extraAttributes(['style' => 'cursor: default'])
                    ->label(function () {
                        $pemasukan = \App\Models\TransaksiKeuangan::where('tipe', 'pemasukan')->sum('jumlah');
                        $pengeluaran = \App\Models\TransaksiKeuangan::where('tipe', 'pengeluaran')->sum('jumlah');

                        return 'Pemasukan: Rp ' . number_format($pemasukan, 0, ',', '.') .
                            ' | Pengeluaran: Rp ' . number_format($pengeluaran, 0, ',', '.');
                    }),
                ExportAction::make()
                    ->label('Download Excel'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => $record->kategori !== 'Pembayaran IPL'),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => $record->kategori !== 'Pembayaran IPL'),
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
            'index' => Pages\ListTransaksiKeuangans::route('/'),
            'create' => Pages\CreateTransaksiKeuangan::route('/create'),
            'edit' => Pages\EditTransaksiKeuangan::route('/{record}/edit'),
        ];
    }
}
