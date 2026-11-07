<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Member;
use Illuminate\Http\Request;

class BranchMapController extends Controller
{
    public function index()
    {
        $branches = Branch::select(
            'id', 'nama', 'jenis', 'alamat', 'telepon', 'latitude', 'longitude'
        )->orderBy('id', 'asc')->get();

        $stats = [
            'total_branches' => $branches->count(),
            'kantor_count' => $branches->where('jenis', 'kantor')->count(),
            'posko_count' => $branches->whereIn('jenis', ['posko', 'rumah_aman', 'mitra'])->count(),
            'active_members' => Member::where('status', 'ACTIVE')->count(),
            'pending_members' => Member::whereIn('status', ['PENDING_VERIFICATION', 'PAYMENT_PENDING'])->count(),
        ];

        return view('peta', compact('branches', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:50',
            'alamat' => 'required|string',
            'telepon' => 'nullable|string|max:50',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $branch = Branch::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Titik lokasi berhasil ditambahkan ke GIS Migrant CARE!',
                'branch' => $branch,
            ]);
        }

        return redirect()->route('peta.index', [
            'lat' => $branch->latitude,
            'lng' => $branch->longitude,
        ])->with('success', 'Titik lokasi "' . $branch->nama . '" berhasil ditambahkan!');
    }
}
