<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4 mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Dashboard</h2>
            <p class="text-gray-500 mb-0">Overview statistik & ringkasan koperasi</p>
        </div>

        <div class="d-flex gap-2">
            <div class="dropdown">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    2026
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item" href="#">2025</a></li>
                    <li><a class="dropdown-item" href="#">2024</a></li>
                    <li><a class="dropdown-item" href="#">2023</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card card-material border-top-purple h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase fw-bold text-muted small mb-1">Total Anggota</div>
                        <div class="h3 fw-bold mb-0 text-dark"><?= number_format($totalAnggota, 0, ',', '.') ?></div>
                        <div class="small text-success mt-1"><i class="bi bi-arrow-up"></i> Aktif</div>
                    </div>
                    <div class="icon-circle bg-purple-soft">
                        <i class="fa-solid fa-people-group"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-material border-top-warning h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase fw-bold text-muted small mb-1">Total Transaksi</div>
                        <div class="h3 fw-bold mb-0 text-dark"><?= number_format($totalTransaksi, 0, ',', '.') ?></div>
                        <div class="small text-muted mt-1">Record kas</div>
                    </div>
                    <div class="icon-circle bg-warning-soft">
                        <i class="fa-solid fa-money-bill"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-material border-top-teal h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase fw-bold text-muted small mb-1">Total Omzet</div>
                        <div class="h3 fw-bold mb-0 text-dark">Rp <?= number_format($totalOmzet, 0, ',', '.') ?></div>
                        <div class="small text-success mt-1"><i class="bi bi-graph-up"></i> Profit</div>
                    </div>
                    <div class="icon-circle bg-teal-soft">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-6">
            <div class="card card-material h-100">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 d-flex justify-content-between">
                    <h5 class="fw-bold text-dark mb-0">Trend Omzet Bulanan</h5>
                </div>
                <div class="card-body">
                    <div style="height: 350px; width: 100%;">
                        <canvas id="omzetChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card card-material h-100">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 d-flex justify-content-between">
                    <h5 class="fw-bold text-dark mb-0">Lokasi Cabang</h5>
                    <div class="dropdown no-caret">
                        <button class="btn btn-transparent btn-sm text-muted" type="button"><i class="bi bi-three-dots-vertical"></i></button>
                    </div>
                </div>
                <div class="card-body d-flex flex-column">
                    <div id="mapDashboard" class="flex-grow-1"></div>
                    <div class="mt-3 small text-muted text-center">
                        <i class="bi bi-info-circle me-1"></i> Data lokasi diambil dari database
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 1. Logika Chart.js (Diubah ke Bar Chart agar mirip gambar referensi)
    const ctx = document.getElementById('omzetChart').getContext('2d');
    const chartDataDb = <?= json_encode($chartData) ?>;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Omzet',
                data: chartDataDb,
                backgroundColor: '#6f42c1',
                borderColor: '#6f42c1', 
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#000',
                    bodyColor: '#000',
                    borderColor: '#e3e6f0',
                    borderWidth: 1,
                    displayColors: false,
                    padding: 10,
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        borderDash: [2],
                        color: '#e3e6f0',
                        drawBorder: false
                    },
                    ticks: {
                        padding: 10,
                        callback: function(value) {
                            return 'Rp ' + (value / 1000000) + ' Jt';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        maxRotation: 0,
                        autoSkip: true
                    }
                }
            }
        }
    });

    function initMap() {
        const locations = <?= json_encode($lokasiKoperasi) ?>;
        const center = locations.length > 0 ?
            {
                lat: parseFloat(locations[0].latitude),
                lng: parseFloat(locations[0].longitude)
            } :
            {
                lat: -6.9175,
                lng: 107.6191
            };

        const map = new google.maps.Map(document.getElementById("mapDashboard"), {
            zoom: 11,
            center: center,
            disableDefaultUI: true,
            zoomControl: true
        });

        const infoWindow = new google.maps.InfoWindow();

        locations.forEach(loc => {
            const marker = new google.maps.Marker({
                position: {
                    lat: parseFloat(loc.latitude),
                    lng: parseFloat(loc.longitude)
                },
                map: map,
                title: loc.nama,
                animation: google.maps.Animation.DROP
            });

            marker.addListener("click", () => {
                infoWindow.setContent(`<strong>${loc.nama}</strong><br>${loc.alamat}`);
                infoWindow.open(map, marker);
            });
        });
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=<?= $google_maps_key ?>&callback=initMap" async defer></script>

<?= $this->endSection() ?>