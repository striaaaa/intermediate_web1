<?php

namespace App\Filament\Resources\Members\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Calon Anggota (Buruh Migran / Keluarga)')
                    ->description('Data identitas pribadi sesuai KTP yang diverifikasi oleh Sekretaris.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('member_number')
                                ->label('Nomor Anggota')
                                ->default(fn () => 'AGT-' . date('Y') . '-' . str_pad((string) (\App\Models\Member::count() + 1), 3, '0', STR_PAD_LEFT))
                                ->required()
                                ->maxLength(50),
                            TextInput::make('nik')
                                ->label('NIK (16 Digit)')
                                ->required()
                                ->minLength(16)
                                ->maxLength(16)
                                ->regex('/^[0-9]{16}$/')
                                ->validationMessages([
                                    'regex' => 'NIK harus berupa 16 digit angka.',
                                ]),
                        ]),
                        TextInput::make('full_name')
                            ->label('Nama Lengkap (Sesuai KTP)')
                            ->required()
                            ->maxLength(255),
                        Grid::make(2)->schema([
                            Select::make('gender')
                                ->label('Jenis Kelamin')
                                ->options([
                                    'Laki-laki' => 'Laki-laki',
                                    'Perempuan' => 'Perempuan',
                                ])
                                ->default('Perempuan')
                                ->required(),
                            TextInput::make('occupation')
                                ->label('Pekerjaan / Status Migrasi')
                                ->placeholder('Contoh: Purna PMI, Keluarga PMI, dsb.')
                                ->maxLength(100),
                        ]),
                        Grid::make(2)->schema([
                            TextInput::make('birth_place')
                                ->label('Tempat Lahir')
                                ->maxLength(100),
                            DatePicker::make('birth_date')
                                ->label('Tanggal Lahir')
                                ->maxDate(now()),
                        ]),
                    ]),

                Section::make('Kontak & Alamat Domisili')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('phone')
                                ->label('No. Telepon / WhatsApp')
                                ->tel()
                                ->required()
                                ->maxLength(30),
                            TextInput::make('email')
                                ->label('Alamat Email')
                                ->email()
                                ->maxLength(255),
                        ]),
                        Textarea::make('address')
                            ->label('Alamat Lengkap Domisili (Desa/Kecamatan/Kabupaten)')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('Verifikasi & Administrasi Keanggotaan (Sekretaris)')
                    ->description('Pembaruan status kelayakan berkas fisik calon anggota oleh Sekretaris.')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('status')
                                ->label('Status Keanggotaan')
                                ->options([
                                    'PENDING_VERIFICATION' => 'Menunggu Verifikasi Berkas (Sekretaris)',
                                    'PAYMENT_PENDING' => 'Menunggu Pembayaran Simpanan Pokok (Bendahara)',
                                    'ACTIVE' => 'Aktif (Anggota Sah)',
                                    'INACTIVE' => 'Nonaktif / Keluar',
                                ])
                                ->default('PENDING_VERIFICATION')
                                ->required(),
                            DatePicker::make('registration_date')
                                ->label('Tanggal Pendaftaran')
                                ->default(now()),
                        ]),
                        Grid::make(2)->schema([
                            DateTimePicker::make('verified_at')
                                ->label('Tanggal Diverifikasi Sekretaris'),
                            TextInput::make('verified_by')
                                ->label('Diverifikasi Oleh')
                                ->placeholder('Nama Sekretaris'),
                        ]),
                        Grid::make(2)->schema([
                            Toggle::make('simpanan_pokok_paid')
                                ->label('Simpanan Pokok Lunas'),
                            Select::make('simpanan_pokok_status')
                                ->label('Status Simpanan Pokok')
                                ->options([
                                    'UNPAID' => 'Belum Bayar (UNPAID)',
                                    'PARTIAL_500K' => 'Sebagian / 500rb (PARTIAL)',
                                    'PAID_FULL' => 'Lunas Penuh (PAID_FULL)',
                                ])
                                ->default('UNPAID'),
                        ]),
                    ]),
            ]);
    }
}
