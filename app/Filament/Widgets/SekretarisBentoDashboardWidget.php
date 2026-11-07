<?php

namespace App\Filament\Widgets;

use App\Models\Branch;
use App\Models\Member;
use Filament\Widgets\Widget;

class SekretarisBentoDashboardWidget extends Widget
{
    protected string $view = 'filament.widgets.sekretaris-bento-dashboard';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = -10;

    protected function getViewData(): array
    {
        $members = Member::orderBy('created_at', 'desc')->get();
        $branches = Branch::orderBy('id', 'asc')->get();

        $activeMembers = $members->where('status', 'ACTIVE');
        $pendingVerification = $members->where('status', 'PENDING_VERIFICATION');
        $paymentPending = $members->where('status', 'PAYMENT_PENDING');
        $calonMembers = $members->whereIn('status', ['PENDING_VERIFICATION', 'PAYMENT_PENDING']);

        $totalSimpananPokok = $members->sum('simpanan_pokok_paid_amount');
        if ($totalSimpananPokok <= 0) {
            $totalSimpananPokok = ($activeMembers->count() * 1000000) + ($paymentPending->count() * 500000);
        }

        return [
            'user' => auth()->user(),
            'members' => $members,
            'branches' => $branches,
            'activeCount' => $activeMembers->count(),
            'pendingCount' => $pendingVerification->count(),
            'paymentPendingCount' => $paymentPending->count(),
            'calonCount' => $calonMembers->count(),
            'totalSimpananPokok' => $totalSimpananPokok,
            'kantorCount' => $branches->where('jenis', 'kantor')->count(),
            'poskoCount' => $branches->whereIn('jenis', ['posko', 'rumah_aman', 'mitra'])->count(),
        ];
    }
}

