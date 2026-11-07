<?php

namespace App\Filament\Resources\Branches\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;

class BranchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Pin-Point Lokasi pada Peta (Otomatis Isi Koordinat & Alamat)')
                    ->description('Klik titik lokasi pada peta di bawah atau cari nama desa/jalan. Latitude, Longitude, dan Alamat Lengkap akan terisi secara otomatis.')
                    ->schema([
                        View::make('filament.components.map-picker')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                Section::make('Identitas Kantor / Posko Layanan Migrant CARE')
                    ->description('Detail informasi titik layanan buruh migran (Indramayu / DKI Jakarta) beserta koordinat yang terkunci dari peta.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('nama')
                                ->label('Nama Kantor / Posko Layanan')
                                ->placeholder('Contoh: Posko Layanan PMI Desa Juntinyuat')
                                ->required()
                                ->maxLength(255),
                            Select::make('jenis')
                                ->label('Kategori Entitas / Posko')
                                ->options([
                                    'kantor' => 'Kantor Operasional / Sekretariat',
                                    'posko' => 'Posko Layanan & Aduan PMI (DESBUMI)',
                                    'rumah_aman' => 'Rumah Aman & Konseling PMI',
                                    'mitra' => 'Mitra Komunitas / Balai Desa',
                                ])
                                ->default('posko')
                                ->required(),
                        ]),

                        Grid::make(3)->schema([
                            TextInput::make('telepon')
                                ->label('Hotline / Kontak PIC')
                                ->placeholder('+62 813-2385-0043')
                                ->tel()
                                ->maxLength(50),
                            TextInput::make('latitude')
                                ->label('Latitude (Otomatis dari Pin Peta)')
                                ->required()
                                ->numeric()
                                ->minValue(-90)
                                ->maxValue(90)
                                ->helperText('Terisi otomatis saat klik peta'),
                            TextInput::make('longitude')
                                ->label('Longitude (Otomatis dari Pin Peta)')
                                ->required()
                                ->numeric()
                                ->minValue(-180)
                                ->maxValue(180)
                                ->helperText('Terisi otomatis saat klik peta'),
                        ]),

                        Textarea::make('alamat')
                            ->label('Alamat Lengkap Wilayah (Otomatis / Dapat Diedit)')
                            ->placeholder('Alamat otomatis terisi dari klik peta, atau sesuaikan detail RT/RW...')
                            ->rows(3)
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
