<?php

namespace App\Filament\Resources\Branches\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BranchesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Kantor / Posko')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('jenis')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'kantor' => 'success',
                        'posko' => 'info',
                        'rumah_aman' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'kantor' => 'Kantor Operasional',
                        'posko' => 'Posko Layanan PMI',
                        'rumah_aman' => 'Rumah Aman',
                        'mitra' => 'Mitra Komunitas',
                        default => ucfirst($state),
                    }),
                TextColumn::make('alamat')
                    ->label('Alamat Wilayah')
                    ->limit(45)
                    ->tooltip(fn ($record) => $record->alamat)
                    ->searchable(),
                TextColumn::make('telepon')
                    ->label('Hotline')
                    ->searchable(),
                TextColumn::make('latitude')
                    ->label('Latitude')
                    ->numeric(decimalPlaces: 6)
                    ->sortable(),
                TextColumn::make('longitude')
                    ->label('Longitude')
                    ->numeric(decimalPlaces: 6)
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('jenis')
                    ->label('Kategori Lokasi')
                    ->options([
                        'kantor' => 'Kantor Operasional / Sekretariat',
                        'posko' => 'Posko Layanan PMI',
                        'rumah_aman' => 'Rumah Aman',
                        'mitra' => 'Mitra Komunitas',
                    ]),
            ])
            ->recordActions([
                Action::make('lihat_di_peta')
                    ->label('Lihat GIS')
                    ->icon('heroicon-o-map-pin')
                    ->color('success')
                    ->url(fn ($record) => url('/peta?lat=' . $record->latitude . '&lng=' . $record->longitude))
                    ->openUrlInNewTab(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
