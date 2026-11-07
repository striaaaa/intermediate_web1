<x-filament-widgets::widget>
    <div style="font-family: 'Plus Jakarta Sans', sans-serif; display: flex; flex-direction: column; gap: 20px;">

        <!-- Header -->
        <div style="background: #FFFFFF; border: 1px solid #DCE3DE; border-radius: 18px; padding: 20px 24px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px;">
            <div>
                <h1 style="margin: 0; font-size: 22px; letter-spacing: -0.02em; color: #111827; line-height: 1.25;">
                    <span style="font-weight: 800;">Selamat Datang, </span>
                    <span style="font-weight: 700; color: #09A46E;">{{ $user?->name ?? 'Sekretaris' }}</span>
                </h1>
                <p style="margin: 4px 0 0 0; font-size: 13px; color: #526158;">
                    Koperasi Konsumen Desa Peduli Buruh Migran Indramayu
                </p>
            </div>

            <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 10px;">
                <a href="/peta" style="display: inline-flex; align-items: center; gap: 7px; background: #F8FAF7; color: #111827; font-size: 12.5px; font-weight: 600; padding: 9px 14px; border-radius: 10px; border: 1px solid #DCE3DE; text-decoration: none;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" x2="9" y1="3" y2="18"/><line x1="15" x2="15" y1="6" y2="21"/></svg>
                    <span>Peta GIS</span>
                </a>

                <a href="/admin/branches/create" style="display: inline-flex; align-items: center; gap: 7px; background: #FFFFFF; color: #111827; font-size: 12.5px; font-weight: 600; padding: 9px 14px; border-radius: 10px; border: 1px solid #DCE3DE; text-decoration: none;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                    <span>Tambah Lokasi</span>
                </a>

                <a href="/admin/members" style="display: inline-flex; align-items: center; gap: 7px; background: #09A46E; color: #FFFFFF; font-size: 12.5px; font-weight: 600; padding: 9px 16px; border-radius: 10px; text-decoration: none;">
                    <span>Verifikasi Anggota ({{ $calonCount }})</span>
                </a>
            </div>
        </div>

        <!-- Bento Grid 3 Kolom -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(310px, 1fr)); gap: 20px; align-items: stretch;">

            <!-- Kolom 1: Keanggotaan & Simpanan Pokok -->
            <div style="display: flex; flex-direction: column; gap: 16px; justify-content: space-between;">
                <div style="background: #FFFFFF; border: 1px solid #DCE3DE; border-radius: 18px; padding: 20px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                    <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 14px;">
                        <div>
                            <h2 style="margin: 0; font-size: 14px; font-weight: 700; color: #111827;">Keanggotaan & Simpanan Pokok</h2>
                            <p style="margin: 2px 0 0 0; font-size: 12px; color: #6B7280;">{{ $activeCount }} anggota aktif • {{ $calonCount }} antrean calon</p>
                        </div>
                        <a href="/admin/members" style="width: 32px; height: 32px; border-radius: 9999px; background: #F2F6F4; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
                        </a>
                    </div>

                    <a href="/admin/members" style="position: relative; overflow: hidden; border-radius: 14px; background: linear-gradient(135deg, #09A46E 0%, #089664 55%, #31B285 100%); padding: 20px; color: #FFFFFF; text-decoration: none; display: block;">
                        <div style="position: relative; z-index: 2; display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                            <span style="font-weight: 700; font-size: 11px; letter-spacing: 0.06em; text-transform: uppercase;">KOPERASI PMI</span>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M8.5 14.5A4 4 0 0 1 8.5 9.5M12 17a7.5 7.5 0 0 1 0-10M15.5 19.5a11 11 0 0 1 0-15"/></svg>
                        </div>

                        <div style="position: relative; z-index: 2; margin-bottom: 18px;">
                            <div style="font-size: 11px; color: rgba(255,255,255,0.82); margin-bottom: 4px;">Total Simpanan Pokok Terkumpul</div>
                            <div style="font-size: 24px; font-weight: 800; letter-spacing: -0.02em;">
                                Rp {{ number_format($totalSimpananPokok, 0, ',', '.') }}
                            </div>
                        </div>

                        <div style="position: relative; z-index: 2; display: flex; align-items: center; justify-content: space-between; font-size: 11px; font-family: monospace; color: rgba(255,255,255,0.9);">
                            <span>{{ $activeCount }} ANGGOTA AKTIF</span>
                            <span>INDRAMAYU & JAKARTA</span>
                        </div>
                    </a>
                </div>

                <a href="/peta" style="background: #FFFFFF; border: 1px solid #DCE3DE; border-radius: 18px; padding: 18px 20px; display: flex; align-items: center; justify-content: space-between; text-decoration: none;">
                    <div>
                        <div style="font-size: 12px; color: #6B7280;">Titik Layanan Terdaftar</div>
                        <div style="font-size: 17px; font-weight: 700; color: #111827; margin-top: 3px;">
                            {{ $kantorCount }} Kantor • {{ $poskoCount }} Posko Layanan
                        </div>
                    </div>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#374151" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
                </a>
            </div>

            <!-- Kolom 2: Peta Sebaran Kantor & Posko -->
            <div style="background: #FFFFFF; border: 1px solid #DCE3DE; border-radius: 18px; padding: 20px; display: flex; flex-direction: column; justify-content: space-between;">
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 12px;">
                    <div>
                        <h2 style="margin: 0; font-size: 14px; font-weight: 700; color: #111827;">Peta Sebaran Kantor & Posko</h2>
                        <p style="margin: 2px 0 0 0; font-size: 12px; color: #6B7280;">Wilayah Indramayu dan DKI Jakarta</p>
                    </div>
                    <a href="/peta" style="width: 32px; height: 32px; border-radius: 9999px; background: #F2F6F4; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;" title="Buka Peta Penuh">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
                    </a>
                </div>

                <div
                    x-data="{
                        initMiniMap() {
                            if (!document.getElementById('leaflet-css-dash')) {
                                const link = document.createElement('link');
                                link.id = 'leaflet-css-dash';
                                link.rel = 'stylesheet';
                                link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
                                document.head.appendChild(link);
                            }
                            const run = () => {
                                if (typeof L === 'undefined') { setTimeout(run, 150); return; }
                                const m = L.map(this.$refs.dashMap, { zoomControl: false }).setView([-6.38, 107.60], 8);
                                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(m);
                                const pts = @js($branches);
                                const group = [];
                                pts.forEach(b => {
                                    const mk = L.marker([b.latitude, b.longitude]).addTo(m)
                                        .bindPopup(`<b>${b.nama}</b><br><span style='font-size:11px'>${b.alamat}</span>`);
                                    group.push(mk);
                                });
                                if (group.length) m.fitBounds(L.featureGroup(group).getBounds().pad(0.2));
                                setTimeout(() => m.invalidateSize(), 250);
                            };
                            if (!document.getElementById('leaflet-js-dash')) {
                                const s = document.createElement('script');
                                s.id = 'leaflet-js-dash';
                                s.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
                                s.onload = run;
                                document.head.appendChild(s);
                            } else {
                                run();
                            }
                        }
                    }"
                    x-init="initMiniMap()"
                    wire:ignore
                >
                    <div x-ref="dashMap" style="width: 100%; height: 225px; border-radius: 12px; border: 1px solid #E4EDE8; overflow: hidden; z-index: 1;"></div>
                </div>
            </div>

            <!-- Kolom 3: Ringkasan Verifikasi Sekretaris -->
            <div style="background: #FFFFFF; border: 1px solid #DCE3DE; border-radius: 18px; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; gap: 14px;">
                <div>
                    <h2 style="margin: 0; font-size: 14px; font-weight: 700; color: #111827;">Status Verifikasi Berkas</h2>
                    <p style="margin: 2px 0 0 0; font-size: 12px; color: #6B7280;">Pemeriksaan berkas fisik KTP dan simpanan pokok</p>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 14px;">
                        <div style="padding: 12px; border-radius: 12px; background: #F8FAF7; border: 1px solid #E4EDE8;">
                            <div style="font-size: 11.5px; color: #6B7280;">Tunggu Verifikasi</div>
                            <div style="font-size: 20px; font-weight: 800; color: #111827; margin-top: 2px;">{{ $pendingCount }}</div>
                        </div>
                        <div style="padding: 12px; border-radius: 12px; background: #F8FAF7; border: 1px solid #E4EDE8;">
                            <div style="font-size: 11.5px; color: #6B7280;">Tunggu Setoran</div>
                            <div style="font-size: 20px; font-weight: 800; color: #111827; margin-top: 2px;">{{ $paymentPendingCount }}</div>
                        </div>
                    </div>
                </div>

                <div style="background: #F8FBF9; border-radius: 14px; padding: 14px 16px; border: 1px solid #E4EDE8;">
                    <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 10px;">
                        <div>
                            <h3 style="margin: 0; font-size: 12.5px; font-weight: 700; color: #111827;">Daftar Anggota</h3>
                            <p style="margin: 2px 0 0 0; font-size: 11.5px; color: #6B7280;">Total {{ count($members) }} data tercatat</p>
                        </div>
                        <a href="/admin/members" style="width: 28px; height: 28px; border-radius: 9999px; background: #FFFFFF; border: 1px solid #E4EDE8; color: #111827; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
                        </a>
                    </div>

                    <div style="display: flex; align-items: center;">
                        @foreach($members->take(5) as $idx => $m)
                            <a href="/admin/members/{{ $m->id }}/edit"
                               title="{{ $m->full_name }}"
                               style="width: 34px; height: 34px; border-radius: 9999px; border: 2px solid #FFFFFF; background: #E8F7F1; color: #09A46E; font-weight: 700; font-size: 12px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; margin-left: {{ $idx === 0 ? '0' : '-8px' }};">
                                {{ strtoupper(substr($m->full_name, 0, 1)) }}
                            </a>
                        @endforeach
                        <a href="/admin/members" style="width: 34px; height: 34px; border-radius: 9999px; border: 2px solid #FFFFFF; background: #09A46E; color: #FFFFFF; font-weight: 700; font-size: 11px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; margin-left: -8px;">
                            +{{ count($members) }}
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Tabel Anggota Terbaru -->
        <div style="background: #FFFFFF; border: 1px solid #DCE3DE; border-radius: 18px; padding: 20px 24px;">
            <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 14px;">
                <div>
                    <h2 style="margin: 0; font-size: 15px; font-weight: 700; color: #111827;">
                        Data Anggota Terbaru
                    </h2>
                    <p style="margin: 2px 0 0 0; font-size: 12px; color: #6B7280;">
                        Daftar pendaftaran calon anggota dan anggota aktif koperasi
                    </p>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="/admin/members/create" style="padding: 7px 13px; border-radius: 8px; background: #09A46E; color: #FFFFFF; font-size: 12px; font-weight: 600; text-decoration: none;">
                        Tambah Anggota
                    </a>
                    <a href="/admin/members" style="padding: 7px 13px; border-radius: 8px; background: #F2F6F4; color: #111827; font-size: 12px; font-weight: 600; text-decoration: none;">
                        Semua Anggota
                    </a>
                </div>
            </div>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 12.5px;">
                    <thead>
                        <tr style="border-bottom: 1px solid #F0F3EF; color: #6B7280; font-size: 11px; text-transform: uppercase; letter-spacing: 0.04em;">
                            <th style="padding: 10px 12px; font-weight: 600;">Nama & NIK</th>
                            <th style="padding: 10px 12px; font-weight: 600;">Pekerjaan</th>
                            <th style="padding: 10px 12px; font-weight: 600;">Alamat</th>
                            <th style="padding: 10px 12px; font-weight: 600;">Status</th>
                            <th style="padding: 10px 12px; font-weight: 600; text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members->take(5) as $m)
                            @php
                                $statusInfo = match($m->status) {
                                    'ACTIVE' => ['color' => '#09A46E', 'label' => 'Aktif'],
                                    'PAYMENT_PENDING' => ['color' => '#0284C7', 'label' => 'Menunggu Simpanan'],
                                    'PENDING_VERIFICATION' => ['color' => '#D97706', 'label' => 'Menunggu Verifikasi'],
                                    default => ['color' => '#4B5563', 'label' => $m->status],
                                };
                            @endphp
                            <tr style="border-bottom: 1px solid #F8FAF7;">
                                <td style="padding: 12px;">
                                    <div style="font-weight: 700; color: #111827;">{{ $m->full_name }}</div>
                                    <div style="font-size: 11px; color: #6B7280; font-family: monospace;">{{ $m->member_number }} • {{ $m->nik }}</div>
                                </td>
                                <td style="padding: 12px; color: #374151;">{{ $m->occupation ?? '-' }}</td>
                                <td style="padding: 12px; color: #6B7280; max-width: 240px;">{{ \Illuminate\Support\Str::limit($m->address, 42) }}</td>
                                <td style="padding: 12px;">
                                    <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; color: #111827;">
                                        <span style="width: 7px; height: 7px; border-radius: 50%; background: {{ $statusInfo['color'] }};"></span>
                                        {{ $statusInfo['label'] }}
                                    </span>
                                </td>
                                <td style="padding: 12px; text-align: right;">
                                    <a href="/admin/members/{{ $m->id }}/edit" style="color: #09A46E; font-size: 12px; font-weight: 600; text-decoration: none;">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-filament-widgets::widget>
