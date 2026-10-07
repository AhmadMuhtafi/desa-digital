@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    <div class="page-head">
        <div>
            <div class="breadcrumb"><a href="#">Beranda</a><span>/</span><span>Dashboard</span></div>
            <h1>Selamat datang kembali, {{ explode(' ', auth()->user()->name ?? 'Admin')[0] }} 👋</h1>
            <p>Ringkasan performa toko Anda hari ini.</p>
        </div>
        <div style="display:flex;gap:10px">
            <button class="btn btn-ghost" type="button" onclick="toast('Laporan sedang diunduh...', 'bi-download')">
                <i class="bi bi-download"></i> Ekspor
            </button>
            <button class="btn btn-primary" type="button" onclick="toast('Fitur tambah pesanan belum dihubungkan', 'bi-info-circle')">
                <i class="bi bi-plus-lg"></i> Pesanan baru
            </button>
        </div>
    </div>

    {{-- ============ Kartu statistik ============
         Ganti angka statis dengan variabel dari controller, mis. {{ $stats['revenue'] }} --}}
    <section class="grid grid-stats">
        <article class="card stat">
            <div class="stat-top">
                <span class="stat-label">Total Pendapatan</span>
                <span class="stat-icon tone-primary"><i class="bi bi-wallet2"></i></span>
            </div>
            <div class="stat-value">Rp 128,4 jt</div>
            <div class="stat-trend"><span class="trend up"><i class="bi bi-arrow-up-short"></i>12,5%</span> dari bulan lalu</div>
        </article>

        <article class="card stat">
            <div class="stat-top">
                <span class="stat-label">Pesanan</span>
                <span class="stat-icon tone-success"><i class="bi bi-bag-check"></i></span>
            </div>
            <div class="stat-value">1.284</div>
            <div class="stat-trend"><span class="trend up"><i class="bi bi-arrow-up-short"></i>8,2%</span> dari bulan lalu</div>
        </article>

        <article class="card stat">
            <div class="stat-top">
                <span class="stat-label">Pelanggan Baru</span>
                <span class="stat-icon tone-info"><i class="bi bi-people"></i></span>
            </div>
            <div class="stat-value">342</div>
            <div class="stat-trend"><span class="trend down"><i class="bi bi-arrow-down-short"></i>2,4%</span> dari bulan lalu</div>
        </article>

        <article class="card stat">
            <div class="stat-top">
                <span class="stat-label">Tingkat Konversi</span>
                <span class="stat-icon tone-warning"><i class="bi bi-graph-up-arrow"></i></span>
            </div>
            <div class="stat-value">3,8%</div>
            <div class="stat-trend"><span class="trend up"><i class="bi bi-arrow-up-short"></i>0,6%</span> dari bulan lalu</div>
        </article>
    </section>

    {{-- ============ Grafik ============ --}}
    <section class="grid grid-charts">
        <div class="card">
            <div class="card-head">
                <h3>Pendapatan <small>Perbandingan tahun ini dan tahun lalu</small></h3>
                <div class="segmented" id="rangeSwitch" data-segmented>
                    <button type="button" class="active" data-value="year">Tahunan</button>
                    <button type="button" data-value="half">6 Bulan</button>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-wrap"><canvas id="revenueChart"></canvas></div>
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <h3>Sumber Trafik <small>30 hari terakhir</small></h3>
            </div>
            <div class="card-body">
                <div class="chart-wrap sm"><canvas id="trafficChart"></canvas></div>
                <ul class="legend" id="trafficLegend"></ul>
            </div>
        </div>
    </section>

    {{-- ============ Tabel & aktivitas ============ --}}
    <section class="grid grid-bottom">
        <div class="card">
            <div class="card-head">
                <h3>Pesanan Terbaru <small>5 transaksi terakhir</small></h3>
                <div class="search" style="max-width:240px">
                    <i class="bi bi-search"></i>
                    <input type="search" placeholder="Filter pesanan..." data-table-filter="#ordersTable" style="height:36px;padding-right:12px">
                </div>
            </div>
            <div class="table-wrap">
                <table class="table" id="ordersTable">
                    <thead>
                        <tr>
                            <th>Pelanggan</th>
                            <th>Invoice</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Contoh dinamis:
                        @forelse($orders as $order)
                            <tr>...</tr>
                        @empty
                            <tr class="empty-row"><td colspan="5">Belum ada pesanan.</td></tr>
                        @endforelse --}}
                        <tr>
                            <td><div class="cell-user"><span class="avatar tone-primary">AR</span><div><strong>Andi Rahman</strong><small>andi@mail.com</small></div></div></td>
                            <td>#INV-2041</td><td>07 Okt 2026</td><td>Rp 1.250.000</td>
                            <td><span class="badge tone-success">Dibayar</span></td>
                        </tr>
                        <tr>
                            <td><div class="cell-user"><span class="avatar tone-info">SD</span><div><strong>Sari Dewi</strong><small>sari@mail.com</small></div></div></td>
                            <td>#INV-2040</td><td>07 Okt 2026</td><td>Rp 480.000</td>
                            <td><span class="badge tone-warning">Menunggu</span></td>
                        </tr>
                        <tr>
                            <td><div class="cell-user"><span class="avatar tone-success">BP</span><div><strong>Budi Prasetyo</strong><small>budi@mail.com</small></div></div></td>
                            <td>#INV-2039</td><td>06 Okt 2026</td><td>Rp 2.730.000</td>
                            <td><span class="badge tone-success">Dibayar</span></td>
                        </tr>
                        <tr>
                            <td><div class="cell-user"><span class="avatar tone-warning">NK</span><div><strong>Nina Kusuma</strong><small>nina@mail.com</small></div></div></td>
                            <td>#INV-2038</td><td>06 Okt 2026</td><td>Rp 315.000</td>
                            <td><span class="badge tone-danger">Dibatalkan</span></td>
                        </tr>
                        <tr>
                            <td><div class="cell-user"><span class="avatar tone-danger">RH</span><div><strong>Rizky Hidayat</strong><small>rizky@mail.com</small></div></div></td>
                            <td>#INV-2037</td><td>05 Okt 2026</td><td>Rp 920.000</td>
                            <td><span class="badge tone-info">Dikirim</span></td>
                        </tr>
                        <tr class="empty-row" style="display:none"><td colspan="5">Tidak ada pesanan yang cocok.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-head"><h3>Aktivitas Terbaru</h3></div>
            <div class="card-body">
                <ul class="timeline">
                    <li>
                        <span class="t-icon tone-success"><i class="bi bi-check2"></i></span>
                        <div><p><strong>Andi Rahman</strong> menyelesaikan pembayaran #INV-2041</p><small>5 menit lalu</small></div>
                    </li>
                    <li>
                        <span class="t-icon tone-primary"><i class="bi bi-box-seam"></i></span>
                        <div><p>Produk <strong>Tas Ransel Urban</strong> ditambahkan</p><small>1 jam lalu</small></div>
                    </li>
                    <li>
                        <span class="t-icon tone-info"><i class="bi bi-truck"></i></span>
                        <div><p>Pesanan #INV-2037 dalam pengiriman</p><small>3 jam lalu</small></div>
                    </li>
                    <li>
                        <span class="t-icon tone-danger"><i class="bi bi-x-lg"></i></span>
                        <div><p>Pesanan #INV-2038 dibatalkan pelanggan</p><small>Kemarin</small></div>
                    </li>
                </ul>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
(function () {
    // Ganti data berikut dengan data dari controller, contoh:
    var labels   = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    var thisYear = [32, 41, 38, 52, 61, 58, 72, 80, 76, 91, 98, 112];
    var lastYear = [24, 30, 33, 38, 45, 44, 52, 58, 60, 66, 71, 79];

    var traffic = [
        { label: 'Pencarian organik', value: 46 },
        { label: 'Media sosial',      value: 27 },
        { label: 'Langsung',          value: 18 },
        { label: 'Referral',          value: 9  }
    ];

    function css(name) {
        return getComputedStyle(document.documentElement).getPropertyValue(name).trim();
    }
    function palette() {
        return [css('--primary'), '#22c55e', '#f59e0b', '#06b6d4'];
    }

    var revenueChart, trafficChart;

    function build() {
        if (revenueChart) revenueChart.destroy();
        if (trafficChart) trafficChart.destroy();

        Chart.defaults.font.family = css('--font');
        Chart.defaults.color = css('--muted');

        var ctx = document.getElementById('revenueChart').getContext('2d');
        var grad = ctx.createLinearGradient(0, 0, 0, 300);
        grad.addColorStop(0, css('--primary') + '40');
        grad.addColorStop(1, css('--primary') + '00');

        var half = document.querySelector('#rangeSwitch .active').dataset.value === 'half';
        var from = half ? 6 : 0;

        revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels.slice(from),
                datasets: [
                    { label: 'Tahun ini', data: thisYear.slice(from), borderColor: css('--primary'), backgroundColor: grad,
                      fill: true, tension: .4, borderWidth: 2.5, pointRadius: 0, pointHoverRadius: 5 },
                    { label: 'Tahun lalu', data: lastYear.slice(from), borderColor: css('--muted'), borderDash: [5, 5],
                      tension: .4, borderWidth: 2, pointRadius: 0, pointHoverRadius: 4 }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { position: 'top', align: 'end', labels: { usePointStyle: true, boxWidth: 8, boxHeight: 8 } },
                    tooltip: { callbacks: { label: function (c) { return ' ' + c.dataset.label + ': Rp ' + c.parsed.y + ' jt'; } } }
                },
                scales: {
                    x: { grid: { display: false }, border: { display: false } },
                    y: { grid: { color: css('--border') }, border: { display: false }, ticks: { callback: function (v) { return v + ' jt'; } } }
                }
            }
        });

        trafficChart = new Chart(document.getElementById('trafficChart'), {
            type: 'doughnut',
            data: {
                labels: traffic.map(function (t) { return t.label; }),
                datasets: [{ data: traffic.map(function (t) { return t.value; }), backgroundColor: palette(),
                             borderColor: css('--surface'), borderWidth: 3, hoverOffset: 4 }]
            },
            options: { responsive: true, maintainAspectRatio: false, cutout: '72%', plugins: { legend: { display: false } } }
        });

        document.getElementById('trafficLegend').innerHTML = traffic.map(function (t, i) {
            return '<li><span class="swatch" style="background:' + palette()[i] + '"></span>' + t.label +
                   '<strong>' + t.value + '%</strong></li>';
        }).join('');
    }

    build();
    window.addEventListener('themechange', build);
    document.getElementById('rangeSwitch').addEventListener('segment', build);
})();
</script>
@endpush
