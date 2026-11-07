<?php

namespace App\Filament\Resources\Members\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MembersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('member_number')
                    ->label('No. Anggota')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),
                TextColumn::make('full_name')
                    ->label('Nama Calon / Anggota')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => 'NIK: ' . $record->nik),
                TextColumn::make('phone')
                    ->label('No. Telepon')
                    ->searchable(),
                TextColumn::make('gender')
                    ->label('L/P')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Laki-laki' => 'info',
                        'Perempuan' => 'primary',
                        default => 'gray',
                    }),
                TextColumn::make('status')
                    ->label('Status Keanggotaan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'PENDING_VERIFICATION' => 'warning',
                        'PAYMENT_PENDING' => 'info',
                        'ACTIVE' => 'success',
                        'INACTIVE' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'PENDING_VERIFICATION' => 'Menunggu Verifikasi',
                        'PAYMENT_PENDING' => 'Menunggu Simpanan',
                        'ACTIVE' => 'Aktif',
                        'INACTIVE' => 'Nonaktif',
                        default => $state,
                    }),
                TextColumn::make('verified_at')
                    ->label('Tgl Verifikasi')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->placeholder('Belum diverifikasi'),
                TextColumn::make('registration_date')
                    ->label('Tgl Daftar')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Keanggotaan')
                    ->options([
                        'PENDING_VERIFICATION' => 'Menunggu Verifikasi (Sekretaris)',
                        'PAYMENT_PENDING' => 'Menunggu Simpanan (Bendahara)',
                        'ACTIVE' => 'Aktif',
                        'INACTIVE' => 'Nonaktif',
                    ]),
                SelectFilter::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                    ]),
            ])
            ->recordActions([
                Action::make('verifikasi')
                    ->label('Verifikasi Berkas')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(fn ($record) => $record->status === 'PENDING_VERIFICATION')
                    ->requiresConfirmation()
                    ->modalHeading('Verifikasi Berkas Fisik Calon Anggota')
                    ->modalDescription(fn ($record) => "Apakah Sekretaris telah memvalidasi KTP dan dokumen fisik calon anggota {$record->full_name}?")
                    ->modalSubmitActionLabel('Ya, Verifikasi Berkas')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'PAYMENT_PENDING',
                            'verified_at' => now(),
                            'verified_by' => auth()->user()?->name ?? 'Sekretaris',
                        ]);

                        Notification::make()
                            ->title('Berkas Berhasil Diverifikasi!')
                            ->body("Calon anggota {$record->full_name} telah diverifikasi oleh Sekretaris. Status kini beralih ke Menunggu Pembayaran Simpanan Pokok.")
                            ->success()
                            ->send();
                    }),

                Action::make('aktifkan')
                    ->label('Jadikan Aktif')
                    ->icon('heroicon-o-user-plus')
                    ->color('primary')
                    ->visible(fn ($record) => $record->status === 'PAYMENT_PENDING')
                    ->requiresConfirmation()
                    ->modalHeading('Aktivasi Anggota')
                    ->modalDescription(fn ($record) => "Aktifkan keanggotaan {$record->full_name}?")
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'ACTIVE',
                        ]);

                        Notification::make()
                            ->title('Anggota Berhasil Diaktifkan!')
                            ->success()
                            ->send();
                    }),

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
