<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WargaResource\Pages;
use App\Filament\Resources\WargaResource\RelationManagers;
use App\Models\Warga;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;

class WargaResource extends Resource
{
    protected static ?string $model = Warga::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Data Warga';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('view_any_warga') ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')->required()->maxLength(255)->unique(ignoreRecord: true),
                TextInput::make('alamat')->maxLength(255),
                TextInput::make('no_hp')->label('No. HP')->maxLength(20),
                DatePicker::make('tanggal_lahir')->label('Tanggal Lahir'),
                Select::make('jenis_kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ])->label('Jenis Kelamin')->required(),
                Select::make('status_keluarga')
                    ->options([
                        'ayah' => 'Ayah',
                        'ibu' => 'Ibu',
                        'anak' => 'Anak',
                        'lainnya' => 'Lainnya',
                    ])->label('Status Keluarga')->required(),
                Toggle::make('is_kepala_keluarga')
                    ->label('Kepala Keluarga')
                    ->inline(false),
            ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->searchable()->sortable(),
                TextColumn::make('alamat')->limit(20)->searchable()->toggleable(),
                TextColumn::make('no_hp')->label('No. HP')->toggleable(),
                TextColumn::make('status_keluarga')->label('Status')->sortable(),
                BooleanColumn::make('is_kepala_keluarga')->label('Kepala Keluarga?')->sortable(),                
                TextColumn::make('created_at')->label('Dibuat')->dateTime()->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([                
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
            'index' => Pages\ListWargas::route('/'),
            'create' => Pages\CreateWarga::route('/create'),
            'edit' => Pages\EditWarga::route('/{record}/edit'),
        ];
    }
}
