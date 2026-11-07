<?php

namespace App\Filament\Resources\Members\Pages;

use App\Filament\Resources\Members\MemberResource;
use App\Models\Member;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListMembers extends ListRecords
{
    protected static string $resource = MemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Calon / Anggota'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua')
                ->badge(Member::count()),

            'calon' => Tab::make('Perlu Verifikasi (Sekretaris)')
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'PENDING_VERIFICATION'))
                ->badge(Member::where('status', 'PENDING_VERIFICATION')->count())
                ->badgeColor('warning'),

            'payment_pending' => Tab::make('Menunggu Simpanan')
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'PAYMENT_PENDING'))
                ->badge(Member::where('status', 'PAYMENT_PENDING')->count())
                ->badgeColor('info'),

            'active' => Tab::make('Anggota Aktif')
                ->modifyQueryUsing(fn ($query) => $query->where('status', 'ACTIVE'))
                ->badge(Member::where('status', 'ACTIVE')->count())
                ->badgeColor('success'),
        ];
    }
}
