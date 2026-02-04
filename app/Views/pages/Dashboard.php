<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<style>
    .stat-card {
        border: none;
        border-radius: 15px;
        color: white;
        transition: 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .gradient-blue {
        background: linear-gradient(135deg, #4e73df, #224abe);
    }

    .gradient-green {
        background: linear-gradient(135deg, #1cc88a, #13855c);
    }

    .gradient-orange {
        background: linear-gradient(135deg, #f6c23e, #dda20a);
    }
</style>

<div class="container-fluid">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Dashboard Koperasi</h3>
            <small class="text-muted">Overview statistik dan performa</small>
        </div>
        <span class="badge bg-primary p-2">Tahun 2026</span>
    </div>

    <!-- STAT CARDS -->
    <div class="row g-4 mb-4">

        <div class="col-md-4">
            <div class="card stat-card gradient-blue shadow">
                <div class="card-body">
                    <h6>Total Anggota</h6>
                    <h2 class="fw-bold">245</h2>
                    <small>+12% dari bulan lalu</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-card gradient-green shadow">
                <div class="card-body">
                    <h6>Total Transaksi</h6>
                    <h2 class="fw-bold">1.240</h2>
                    <small>+8% dari bulan lalu</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-card gradient-orange shadow">
                <div class="card-body">
                    <h6>Total Omzet</h6>
                    <h2 class="fw-bold">Rp 125 JT</h2>
                    <small>-3% dari bulan lalu</small>
                </div>
            </div>
        </div>

    </div>

    <!-- CHART CARD -->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-4">
                    <h5 class="mb-4 fw-bold">Trend Omzet 2026</h5>
                    <canvas id="omzetChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-4">
                    <h5 class="mb-4 fw-bold">Lokasi Cabang Koperasi</h5>
                    <canvas id="omzetChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>



</div>

<script>
    const ctx = document.getElementById('omzetChart').getContext('2d');

    // Gradient fill
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(78, 115, 223, 0.5)');
    gradient.addColorStop(1, 'rgba(78, 115, 223, 0.05)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Omzet (Juta)',
                data: [12, 19, 15, 25, 22, 30, 35, 40, 38, 45, 50, 55],
                borderColor: '#4e73df',
                backgroundColor: gradient,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#4e73df',
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1f2937',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    padding: 10,
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>

<?= $this->endSection('content') ?>