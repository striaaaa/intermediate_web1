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
                Section::make('Titik Koordinat Peta')
                    ->description('Klik lokasi pada peta atau cari nama desa/jalan untuk mengisi koordinat dan alamat secara otomatis.')
                    ->schema([
                        View::make('filament.components.map-picker')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                Section::make('Informasi Kantor / Posko')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('nama')
                                ->label('Nama Kantor / Posko')
                                ->placeholder('Contoh: Posko Layanan PMI Desa Juntinyuat')
                                ->required()
                                ->maxLength(255),
                            Select::make('jenis')
                                ->label('Kategori Lokasi')
                                ->options([
                                    'kantor' => 'Kantor Operasional / Sekretariat',
                                    'posko' => 'Posko Layanan & Aduan PMI',
                                    'rumah_aman' => 'Rumah Aman & Konseling',
                                    'mitra' => 'Mitra Komunitas / Balai Desa',
                                ])
                                ->default('posko')
                                ->required(),
                        ]),

                        Grid::make(3)->schema([
                            TextInput::make('telepon')
                                ->label('Nomor Telepon')
                                ->placeholder('+62 813-2385-0043')
                                ->tel()
                                ->maxLength(50),
                            TextInput::make('latitude')
                                ->label('Latitude')
                                ->required()
                                ->numeric()
                                ->minValue(-90)
                                ->maxValue(90),
                            TextInput::make('longitude')
                                ->label('Longitude')
                                ->required()
                                ->numeric()
                                ->minValue(-180)
                                ->maxValue(180),
                        ]),

                        Textarea::make('alamat')
                            ->label('Alamat Lengkap')
                            ->placeholder('Alamat otomatis terisi saat memilih titik di peta, atau ketik manual...')
                            ->rows(3)
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
