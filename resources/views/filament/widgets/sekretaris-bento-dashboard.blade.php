<x-filament-widgets::widget>
    <div style="font-family: 'Plus Jakarta Sans', sans-serif; display: flex; flex-direction: column; gap: 20px;">

        <!-- ─── 1. BENTO EXECUTIVE HEADER (Persis AdminDashboard.tsx OpsiProyek1) ─── -->
        <div style="background: #FFFFFF; border: 1px solid #DCE3DE; border-radius: 20px; padding: 20px 24px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px; box-shadow: 0 2px 12px rgba(9, 164, 110, 0.04);">
            <div>
                <div style="display: inline-flex; align-items: center; gap: 6px; padding: 3px 11px; border-radius: 9999px; background: #E8F7F1; color: #09A46E; font-size: 11px; font-weight: 800; margin-bottom: 6px; border: 1px solid rgba(9, 164, 110, 0.2);">
                    <span style="width: 6px; height: 6px; border-radius: 9999px; background: #09A46E; display: inline-block;"></span>
                    <span>Ringkasan Eksekutif Sekretaris • Koperasi Konsumen Desa Peduli Buruh Migran</span>
                </div>
                <h1 style="margin: 0; font-size: 24px; letter-spacing: -0.02em; color: #111827; line-height: 1.25;">
                    <span style="font-weight: 800;">Selamat Datang, </span>
                    <span style="font-weight: 700; color: #09A46E;">{{ $user?->name ?? 'Sekretaris Koperasi' }}</span>
                </h1>
            </div>

            <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 10px;">
                <a href="/peta" style="display: inline-flex; align-items: center; gap: 8px; background: #F8FAF7; color: #111827; font-size: 12px; font-weight: 700; padding: 9px 15px; border-radius: 12px; border: 1px solid #DCE3DE; text-decoration: none; transition: all 0.2s;">
                    <span>🗺️</span>
                    <span>Buka Peta GIS Interaktif ({{ count($branches) }} Titik)</span>
                </a>

                <a href="/admin/branches/create" style="display: inline-flex; align-items: center; gap: 6px; background: #E8F7F1; color: #09A46E; font-size: 12px; font-weight: 800; padding: 9px 15px; border-radius: 12px; border: 1px solid rgba(9,164,110,0.3); text-decoration: none;">
                    <span>📍</span>
                    <span>+ Pin-Point Lokasi Baru</span>
                </a>

                <a href="/admin/members" style="display: inline-flex; align-items: center; gap: 6px; background: #09A46E; color: #FFFFFF; font-size: 12px; font-weight: 800; padding: 9px 16px; border-radius: 12px; text-decoration: none; box-shadow: 0 4px 12px rgba(9, 164, 110, 0.25);">
                    <span>✓</span>
                    <span>Verifikasi Anggota ({{ $calonCount }})</span>
                </a>
            </div>
        </div>

        <!-- ─── 2. MAIN BENTO GRID (3 KOLOM ATAS) ─── -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(310px, 1fr)); gap: 20px; align-items: stretch;">

            <!-- KOLOM 1: EMERALD CARD KEANGGOTAAN & SIMPANAN POKOK -->
            <div style="display: flex; flex-direction: column; gap: 16px; justify-content: space-between;">
                <div style="background: #FFFFFF; border: 1px solid #DCE3DE; border-radius: 20px; padding: 20px; box-shadow: 0 2px 12px rgba(9, 164, 110, 0.04); flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                    <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 14px;">
                        <div>
                            <h2 style="margin: 0; font-size: 14px; font-weight: 800; color: #111827;">Portofolio Keanggotaan & Simpanan Pokok</h2>
                            <p style="margin: 2px 0 0 0; font-size: 11px; color: #6B7280;">{{ $activeCount }} Anggota Aktif • {{ $calonCount }} Calon Menunggu</p>
                        </div>
                        <a href="/admin/members" style="width: 32px; height: 32px; border-radius: 9999px; background: #F2F6F4; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none; font-weight: 800;">↗</a>
                    </div>

                    <!-- Emerald Gradient Card (Persis AdminDashboard.tsx) -->
                    <a href="/admin/members" style="position: relative; overflow: hidden; border-radius: 16px; background: linear-gradient(135deg, #09A46E 0%, #089664 55%, #31B285 100%); padding: 20px; color: #FFFFFF; text-decoration: none; box-shadow: 0 10px 25px rgba(9, 164, 110, 0.24); display: block;">
                        <div style="position: absolute; right: -28px; top: -28px; width: 120px; height: 120px; border-radius: 9999px; background: rgba(255,255,255,0.10);"></div>
                        <div style="position: absolute; left: -20px; bottom: -36px; width: 100px; height: 100px; border-radius: 9999px; background: rgba(0,0,0,0.06);"></div>

                        <div style="position: relative; z-index: 2; display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                            <span style="font-weight: 800; font-size: 11px; letter-spacing: 0.08em; text-transform: uppercase; font-style: italic;">KOPERASI PMI • MIGRANT CARE</span>
                            <span style="font-size: 16px;">🛡️</span>
                        </div>

                        <div style="position: relative; z-index: 2; margin-bottom: 18px;">
                            <div style="font-size: 11px; color: rgba(255,255,255,0.82); font-weight: 500; margin-bottom: 4px;">Akumulasi Simpanan Pokok Anggota</div>
                            <div style="font-size: 24px; font-weight: 800; letter-spacing: -0.02em;">
                                Rp {{ number_format($totalSimpananPokok, 0, ',', '.') }}
                            </div>
                        </div>

                        <div style="position: relative; z-index: 2; display: flex; align-items: center; justify-content: space-between; font-size: 11px; font-family: monospace; color: rgba(255,255,255,0.9);">
                            <span>•••• {{ $activeCount }} ANGGOTA SAH</span>
                            <span>INDRAMAYU & JKT</span>
                        </div>
                    </a>
                </div>

                <!-- Compact Stat Card: Jaringan GIS -->
                <a href="/peta" style="background: #FFFFFF; border: 1px solid #DCE3DE; border-radius: 20px; padding: 18px 20px; display: flex; align-items: center; justify-content: space-between; text-decoration: none; box-shadow: 0 2px 12px rgba(9, 164, 110, 0.04);">
                    <div>
                        <div style="font-size: 11px; color: #6B7280; font-weight: 600;">Jaringan Kantor & Posko DESBUMI</div>
                        <div style="font-size: 19px; font-weight: 800; color: #111827; margin-top: 3px;">
                            {{ $kantorCount }} Kantor Pusat/Cabang • {{ $poskoCount }} Posko
                        </div>
                    </div>
                    <span style="padding: 5px 11px; border-radius: 9999px; background: #E8F7F1; color: #09A46E; font-size: 11px; font-weight: 800; border: 1px solid rgba(9,164,110,0.2);">
                        GIS Aktif
                    </span>
                </a>
            </div>

            <!-- KOLOM 2: PETA GIS LIVE PREVIEW BENTO CARD -->
            <div style="background: #FFFFFF; border: 1px solid #DCE3DE; border-radius: 20px; padding: 20px; box-shadow: 0 2px 12px rgba(9, 164, 110, 0.04); display: flex; flex-direction: column; justify-content: space-between;">
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 12px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 36px; height: 36px; border-radius: 12px; background: #E8F7F1; color: #09A46E; display: flex; align-items: center; justify-content: center; font-size: 16px;">🗺️</div>
                        <div>
                            <h2 style="margin: 0; font-size: 14px; font-weight: 800; color: #111827;">Peta Sebaran Kantor & Posko</h2>
                            <p style="margin: 1px 0 0 0; font-size: 11px; color: #6B7280;">Indramayu (Karangampel, Juntinyuat, Krangkeng) & Jakarta</p>
                        </div>
                    </div>
                    <div style="display: flex; gap: 6px;">
                        <a href="/admin/branches/create" style="padding: 5px 10px; border-radius: 9999px; background: #09A46E; color: #FFFFFF; font-size: 11px; font-weight: 700; text-decoration: none;">+ Pin-Point</a>
                        <a href="/peta" style="width: 30px; height: 30px; border-radius: 9999px; background: #F2F6F4; color: #111827; display: flex; align-items: center; justify-content: center; text-decoration: none; font-weight: 800;" title="Buka Peta Penuh">↗</a>
                    </div>
                </div>

                <!-- Mini Leaflet Map inside Dashboard -->
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
                    <div x-ref="dashMap" style="width: 100%; height: 215px; border-radius: 14px; border: 1px solid #E4EDE8; overflow: hidden; z-index: 1;"></div>
                </div>
            </div>

            <!-- KOLOM 3: ANTREAN VERIFIKASI SEKRETARIS & AVATAR STACK (Persis AdminDashboard.tsx) -->
            <div style="background: #FFFFFF; border: 1px solid #DCE3DE; border-radius: 20px; padding: 20px; box-shadow: 0 2px 12px rgba(9, 164, 110, 0.04); display: flex; flex-direction: column; justify-content: space-between; gap: 14px;">
                <div>
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                        <div>
                            <h2 style="margin: 0; font-size: 14px; font-weight: 800; color: #111827;">Status Verifikasi Berkas Sekretaris</h2>
                            <p style="margin: 2px 0 0 0; font-size: 11px; color: #6B7280;">Validasi KTP fisik & kelengkapan administrasi PMI</p>
                        </div>
                        <span style="padding: 4px 10px; border-radius: 9999px; background: #FEF3C7; color: #92400E; font-size: 11px; font-weight: 800;">
                            {{ $pendingCount }} Berkas Baru
                        </span>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 12px;">
                        <div style="padding: 12px; border-radius: 14px; background: #F8FAF7; border: 1px solid #E4EDE8;">
                            <div style="font-size: 11px; color: #6B7280; font-weight: 600;">Verifikasi Fisik</div>
                            <div style="font-size: 20px; font-weight: 800; color: #D97706; margin-top: 2px;">{{ $pendingCount }} Calon</div>
                        </div>
                        <div style="padding: 12px; border-radius: 14px; background: #F8FAF7; border: 1px solid #E4EDE8;">
                            <div style="font-size: 11px; color: #6B7280; font-weight: 600;">Tunggu Simpanan</div>
                            <div style="font-size: 20px; font-weight: 800; color: #0284C7; margin-top: 2px;">{{ $paymentPendingCount }} Calon</div>
                        </div>
                    </div>
                </div>

                <!-- Inner Card: Avatar Stack + Audit Pill (Persis Baris 610-676 AdminDashboard.tsx) -->
                <div style="background: #F8FBF9; border-radius: 16px; padding: 14px 16px; border: 1px solid #E4EDE8;">
                    <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 10px;">
                        <div>
                            <h3 style="margin: 0; font-size: 12.5px; font-weight: 800; color: #111827;">Direktori Anggota & Antrean</h3>
                            <p style="margin: 2px 0 0 0; font-size: 11px; color: #6B7280;">{{ $calonCount }} calon anggota • {{ $activeCount }} anggota sah</p>
                        </div>
                        <a href="/admin/members" style="width: 28px; height: 28px; border-radius: 9999px; background: #FFFFFF; border: 1px solid #E4EDE8; color: #111827; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 12px; font-weight: 800;">↗</a>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                        <div style="display: flex; align-items: center;">
                            @foreach($members->take(5) as $idx => $m)
                                <a href="/admin/members/{{ $m->id }}/edit"
                                   title="{{ $m->full_name }} ({{ $m->status }})"
                                   style="width: 34px; height: 34px; border-radius: 9999px; border: 2px solid #FFFFFF; background: #E8F7F1; color: #09A46E; font-weight: 800; font-size: 12px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; margin-left: {{ $idx === 0 ? '0' : '-8px' }};">
                                    {{ strtoupper(substr($m->full_name, 0, 1)) }}
                                </a>
                            @endforeach
                            <a href="/admin/members" style="width: 34px; height: 34px; border-radius: 9999px; border: 2px solid #FFFFFF; background: #09A46E; color: #FFFFFF; font-weight: 800; font-size: 11px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; margin-left: -8px;">
                                +{{ count($members) }}
                            </a>
                        </div>

                        <div style="display: flex; align-items: center; gap: 7px; padding: 6px 12px; border-radius: 9999px; background: #FFFFFF; border: 1px solid #E4EDE8;">
                            <span style="width: 7px; height: 7px; border-radius: 9999px; background: #09A46E;"></span>
                            <div>
                                <div style="font-size: 10px; font-weight: 800; color: #111827; line-height: 1;">Sekretariat Aktif</div>
                                <div style="font-size: 9px; font-weight: 700; color: #09A46E; margin-top: 2px;">{{ count($branches) }} Titik GIS</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- ─── 3. BOTTOM WIDE BENTO CARD: ANTREAN VERIFIKASI TERBARU ─── -->
        <div style="background: #FFFFFF; border: 1px solid #DCE3DE; border-radius: 20px; padding: 20px 24px; box-shadow: 0 2px 12px rgba(9, 164, 110, 0.04);">
            <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 14px;">
                <div>
                    <h2 style="margin: 0; font-size: 15px; font-weight: 800; color: #111827;">
                        Antrean Verifikasi Fisik & Buku Anggota Terbaru
                    </h2>
                    <p style="margin: 2px 0 0 0; font-size: 12px; color: #6B7280;">
                        Alur SOP Sekretaris: Periksa kesesuaian NIK 16 digit & berkas fisik KTP sebelum aktivasi Simpanan Pokok.
                    </p>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="/admin/members/create" style="padding: 7px 14px; border-radius: 9999px; background: #E8F7F1; color: #09A46E; font-size: 12px; font-weight: 800; text-decoration: none; border: 1px solid rgba(9,164,110,0.25);">
                        + Daftar Anggota Baru
                    </a>
                    <a href="/admin/members" style="padding: 7px 14px; border-radius: 9999px; background: #F2F6F4; color: #111827; font-size: 12px; font-weight: 700; text-decoration: none;">
                        Lihat Semua Anggota →
                    </a>
                </div>
            </div>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 12.5px;">
                    <thead>
                        <tr style="border-bottom: 1px solid #F0F3EF; color: #9CA3AF; font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em;">
                            <th style="padding: 10px 12px; font-weight: 700;">Anggota / NIK</th>
                            <th style="padding: 10px 12px; font-weight: 700;">Pekerjaan / Penempatan</th>
                            <th style="padding: 10px 12px; font-weight: 700;">Domisili</th>
                            <th style="padding: 10px 12px; font-weight: 700;">Status Verifikasi</th>
                            <th style="padding: 10px 12px; font-weight: 700; text-align: right;">Aksi Sekretaris</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members->take(5) as $m)
                            @php
                                $statusBadge = match($m->status) {
                                    'ACTIVE' => ['bg' => '#E8F7F1', 'text' => '#09A46E', 'label' => 'Aktif (Anggota Sah)'],
                                    'PAYMENT_PENDING' => ['bg' => '#E0F2FE', 'text' => '#0284C7', 'label' => 'Terverifikasi • Tunggu Simpanan'],
                                    'PENDING_VERIFICATION' => ['bg' => '#FEF3C7', 'text' => '#B45309', 'label' => 'Menunggu Verifikasi Berkas'],
                                    default => ['bg' => '#F3F4F6', 'text' => '#4B5563', 'label' => $m->status],
                                };
                            @endphp
                            <tr style="border-bottom: 1px solid #F8FAF7;">
                                <td style="padding: 12px;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 34px; height: 34px; border-radius: 9999px; background: #E8F7F1; color: #09A46E; font-weight: 800; font-size: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            {{ strtoupper(substr($m->full_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div style="font-weight: 800; color: #111827;">{{ $m->full_name }}</div>
                                            <div style="font-size: 11px; color: #6B7280; font-family: monospace;">{{ $m->member_number }} • NIK: {{ $m->nik }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 12px; color: #374151; font-weight: 600;">{{ $m->occupation ?? '-' }}</td>
                                <td style="padding: 12px; color: #6B7280; max-width: 240px;">{{ \Illuminate\Support\Str::limit($m->address, 42) }}</td>
                                <td style="padding: 12px;">
                                    <span style="padding: 4px 10px; border-radius: 9999px; background: {{ $statusBadge['bg'] }}; color: {{ $statusBadge['text'] }}; font-size: 11px; font-weight: 800;">
                                        {{ $statusBadge['label'] }}
                                    </span>
                                </td>
                                <td style="padding: 12px; text-align: right;">
                                    <a href="/admin/members/{{ $m->id }}/edit" style="padding: 6px 12px; border-radius: 10px; background: #F0F3EF; color: #17211C; font-size: 11.5px; font-weight: 700; text-decoration: none;">
                                        Periksa / Edit →
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

