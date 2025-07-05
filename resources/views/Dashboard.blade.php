@extends('layout.master')

@section('title', 'Dashboard')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="m-0">Dashboard</h1>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $data['total_customers'] }}</h3>
                                <p>Pelanggan</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <a href="{{ route('stores.index') }}" class="small-box-footer">Lihat Detail <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $data['total_leads'] }}</h3>
                                <p>Prospek</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-bullseye"></i>
                            </div>
                            <a href="{{ route('leads.index') }}" class="small-box-footer">Lihat Detail <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $data['total_activities'] }}</h3>
                                <p>Aktivitas</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <a href="{{ route('activities.index') }}" class="small-box-footer">Lihat Detail <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $data['total_closing'] }}</h3>
                                <p>Closing</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <a href="{{ route('leads.index') }}" class="small-box-footer">Lihat Detail <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                </div>
                @if (auth()->user()->role === 'admin')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="filterTahun">Filter Tahun:</label>
                                                <select id="filterTahun" class="form-control">
                                                    @for ($i = now()->year; $i >= 2020; $i--)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="filterBulan">Filter Bulan:</label>
                                                <select id="filterBulan" class="form-control">
                                                    @for ($m = 1; $m <= 12; $m++)
                                                        <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}">
                                                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Jumlah Toko per Sales</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="grafikTokoPerSales" height="200"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Toko Baru per Bulan</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="grafikTokoPerBulan" height="200"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Prospek per Sales</h3>
                                </div>
                                <div class="card-body"><canvas id="grafikProspekSales" height="200"></canvas></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Prospek Baru per Bulan</h3>
                                </div>
                                <div class="card-body"><canvas id="grafikProspekBulan" height="200"></canvas></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Aktivitas per Sales</h3>
                                </div>
                                <div class="card-body"><canvas id="grafikAktivitasSales" height="200"></canvas></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Aktivitas per Bulan</h3>
                                </div>
                                <div class="card-body"><canvas id="grafikAktivitasBulan" height="200"></canvas></div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Distribusi Toko per Sales (Pie)</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="salesMatrixPie" height="220"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4"></script>
    <script>
        const BASE_URL = '{{ url('/') }}';
        let charts = [];

        const randColor = (alpha = 0.9) =>
            `rgba(${Math.floor(Math.random()*256)},${Math.floor(Math.random()*256)},${Math.floor(Math.random()*256)},${alpha})`;

        function clearCharts() {
            charts.forEach(c => c && c.destroy());
            charts = [];
        }

        function renderGrafik(tahun) {
            $.get(`${BASE_URL}/grafik/${tahun}`).done(d => {
                clearCharts();

                const makeBar = (canvasId, labels, data) => new Chart(
                    document.getElementById(canvasId), {
                        type: 'bar',
                        data: {
                            labels,
                            datasets: [{
                                label: '# Data',
                                data,
                                backgroundColor: labels.map(() => randColor()),
                                borderColor: labels.map(() => randColor(1)),
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });

                const makeLine = (canvasId, labels, data) => {
                    const color = randColor(1);
                    return new Chart(document.getElementById(canvasId), {
                        type: 'line',
                        data: {
                            labels,
                            datasets: [{
                                label: '# Data',
                                data,
                                borderColor: color,
                                backgroundColor: 'transparent',
                                borderWidth: 2,
                                pointBackgroundColor: color
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });
                };

                charts.push(
                    makeBar('grafikTokoPerSales', d.toko_sales.map(x => x.sales), d.toko_sales.map(x => x
                        .jumlah)),
                    makeLine('grafikTokoPerBulan', d.toko_bulan.map(x => x.bulan), d.toko_bulan.map(x => x
                        .jumlah))
                );

                charts.push(
                    makeBar('grafikProspekSales', d.prospek_sales.map(x => x.sales), d.prospek_sales.map(x => x
                        .jumlah)),
                    makeLine('grafikProspekBulan', d.prospek_bulan.map(x => x.bulan), d.prospek_bulan.map(x => x
                        .jumlah))
                );

                charts.push(
                    makeBar('grafikAktivitasSales', d.aktiv_sales.map(x => x.sales), d.aktiv_sales.map(x => x
                        .jumlah)),
                    makeLine('grafikAktivitasBulan', d.aktiv_bulan.map(x => x.bulan), d.aktiv_bulan.map(x => x
                        .jumlah))
                );

            }).fail(() => alert('Gagal memuat data grafik!'));
        }

        $(function() {
            renderGrafik($('#filterTahun').val());
            $('#filterTahun').on('change', function() {
                renderGrafik($(this).val());
            });
        });

        let pieMatrix = null;

        function loadPie() {
            const bulan = $('#filterBulan').val();
            const tahun = $('#filterTahun').val();

            $.get('{{ route('matrix.pie') }}', {
                bulan,
                tahun
            }, rows => {
                const labels = rows.map(r => r.label);
                const data = rows.map(r => r.value);
                const colors = labels.map(() =>
                    `rgba(${~~(Math.random()*255)},${~~(Math.random()*255)},${~~(Math.random()*255)},0.8)`);

                if (pieMatrix) pieMatrix.destroy();
                pieMatrix = new Chart(document.getElementById('salesMatrixPie'), {
                    type: 'pie',
                    data: {
                        labels,
                        datasets: [{
                            data,
                            backgroundColor: colors
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'right'
                        }
                    }
                });
            });
        }

        $(function() {
            loadPie();
            $('#filterBulan, #filterTahun').on('change', loadPie);
        });
    </script>
@endpush
