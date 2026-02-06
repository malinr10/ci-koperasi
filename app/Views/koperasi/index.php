<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Data Koperasi</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="fa-solid fa-plus me-1"></i> Tambah Koperasi</button>
    </div>

    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-success alert-dismissible fade show border-0" role="alert"><?= session()->getFlashdata('pesan'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm p-3">
        <table id="tableKoperasi" class="table table-hover">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No Telepon</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($koperasi as $k) : ?>
                    <tr>
                        <td><strong><?= $k['nama'] ?></strong></td>
                        <td><?= $k['email'] ?></td>
                        <td><?= $k['no_telepon'] ?></td>
                        <td><?= ucfirst($k['status']) ?></td>
                        <td class="d-flex gap-1">
                            <button class="btn btn-edit btn-sm btn-warning"
                                data-bs-toggle="modal" data-bs-target="#modalEdit"
                                data-id="<?= $k['id'] ?>" data-nama="<?= $k['nama'] ?>"
                                data-alamat="<?= $k['alamat'] ?>" data-lat="<?= $k['latitude'] ?>"
                                data-lng="<?= $k['longitude'] ?>"><i class="fa-solid fa-pen-to-square text-light"></i>
                            </button>
                            <form action="<?= base_url('koperasi/delete/' . $k['id']) ?>" method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm text-light" onclick="return confirm('Hapus koperasi ini?')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                            <button class="btn btn-detail btn-sm btn-info text-light"
                                data-bs-toggle="modal" data-bs-target="#modaldetail"
                                data-id="<?= $k['id'] ?>" data-nama="<?= $k['nama'] ?>"
                                data-alamat="<?= $k['alamat'] ?>" data-lat="<?= $k['latitude'] ?>"
                                data-lng="<?= $k['longitude'] ?>" ><i class="fa-solid fa-eye text-light"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="/koperasi/save" method="post">
                <div class="modal-header">
                    <h5>Tambah Koperasi</h5>
                </div>
                <div class="modal-body row">
                    <div class="col-md-5">
                        <label>Nama Koperasi</label><input type="text" value="<?= old('nama') ?>" name="nama" class="form-control mb-2" required>
                        <label>Email</label><input type="email" name="email" value="<?= old('email') ?>" class="form-control mb-2" required>
                        <label>No Telepon</label><input type="text" name="no_telepon" value="<?= old('no_telepon') ?>" class="form-control mb-2" required>
                        <label for="A">Alamat</label>
                        <div class="input-group mb-3">
                            <input type="text" id="searchTambah" class="form-control" placeholder="Ketik alamat...">
                            <button class="btn btn-dark" type="button" id="btnCariTambah">Cari</button>
                        </div>
                        <textarea name="alamat" id="alamatTambah" class="form-control mb-2" readonly><?= old('alamat') ?></textarea>
                        <input type="hidden" name="latitude" id="latTambah" value="<?= old('latitude') ?>">
                        <input type="hidden" name="longitude" id="lngTambah" value="<?= old('longitude') ?>">
                    </div>
                    <div class="col-md-7">
                        <div id="mapTambah" style="height: 400px; border-radius: 10px;"></div>
                    </div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary w-100">Simpan</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="" id="formEdit" method="post">
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-header bg-warning">
                    <h5>Update Lokasi</h5>
                </div>
                <div class="modal-body row">
                    <div class="col-md-5">
                        <label>Nama Koperasi</label><input type="text" name="nama" id="namaEdit" class="form-control mb-2">
                        <label>Email</label><input type="email" name="email" id="emailEdit" class="form-control mb-2" required>
                        <label>No Telepon</label><input type="text" name="no_telepon" id="noTelpEdit" class="form-control mb-2" required>
                        <label for="A">Alamat</label>
                        <div class="input-group mb-3">
                            <input type="text" id="searchEdit" class="form-control" placeholder="Ketik alamat...">
                            <button class="btn btn-dark" type="button" id="btnCariEdit">Cari</button>
                        </div>
                        <textarea name="alamat" id="alamatEdit" class="form-control mb-2" readonly></textarea>
                        <input type="hidden" name="latitude" id="latEdit"><input type="hidden" name="longitude" id="lngEdit">
                    </div>
                    <div class="col-md-7">
                        <div id="mapEdit" style="height: 400px; border-radius: 10px;"></div>
                    </div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-warning w-100">Update Data</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modaldetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fa-solid fa-building me-2"></i> Detail Koperasi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-md-5 bg-light p-4">
                        <h4 class="fw-bold text-dark mb-3" id="detailNama">Nama Koperasi</h4>

                        <div class="mb-3">
                            <label class="small text-muted text-uppercase fw-bold">Email</label>
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-envelope text-primary me-2"></i>
                                <span id="detailEmail" class="text-dark">-</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="small text-muted text-uppercase fw-bold">No Telepon</label>
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-phone text-success me-2"></i>
                                <span id="detailTelp" class="text-dark">-</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="small text-muted text-uppercase fw-bold">Alamat</label>
                            <p id="detailAlamat" class="mb-0 text-secondary">
                                -
                            </p>
                        </div>
                    </div>

                    <div class="col-md-7 position-relative">
                        <div id="mapDetail" style="height: 100%; min-height: 350px; width: 100%;"></div>
                        <div class="position-absolute bottom-0 start-0 m-3 bg-white px-3 py-1 rounded shadow-sm opacity-75 small">
                            <i class="fa-solid fa-location-dot text-danger"></i> Lokasi Peta
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-top-0">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script>
    // Definisikan variabel map dan marker untuk Tambah (T), Edit (E), dan Detail (D)
    let mapT, markerT, mapE, markerE, mapD, markerD;
    let geo;

    function initGoogleMaps() {
        geo = new google.maps.Geocoder();

        const defaultCenter = {
            lat: -6.9175,
            lng: 107.6191
        };

        // -------------------------
        // 1. MAP TAMBAH
        // -------------------------
        mapT = new google.maps.Map(document.getElementById("mapTambah"), {
            center: defaultCenter,
            zoom: 13,
            disableDefaultUI: false
        });
        markerT = new google.maps.Marker({
            position: defaultCenter,
            map: mapT,
            draggable: true,
            title: "Geser marker ini"
        });
        setupMarkerEvent(markerT, "Tambah");

        // -------------------------
        // 2. MAP EDIT
        // -------------------------
        mapE = new google.maps.Map(document.getElementById("mapEdit"), {
            center: defaultCenter,
            zoom: 13
        });
        markerE = new google.maps.Marker({
            map: mapE,
            draggable: true
        });
        setupMarkerEvent(markerE, "Edit");

        // -------------------------
        // 3. MAP DETAIL (Baru)
        // -------------------------
        mapD = new google.maps.Map(document.getElementById("mapDetail"), {
            center: defaultCenter,
            zoom: 15,
            disableDefaultUI: true, 
            gestureHandling: "cooperative"
        });
        markerD = new google.maps.Marker({
            map: mapD,
            draggable: false 
        });
    }

    function setupMarkerEvent(markerObj, type) {
        markerObj.addListener("dragend", () => {
            const pos = markerObj.getPosition();
            geo.geocode({
                location: pos
            }, (results, status) => {
                if (status === "OK") updateFields(type, pos.lat(), pos.lng(), results[0].formatted_address);
            });
        });
    }

    function updateFields(type, lat, lng, addr) {
        $(`#lat${type}`).val(lat);
        $(`#lng${type}`).val(lng);
        $(`#alamat${type}`).val(addr);
    }

    // Fungsi Cari Lokasi Manual
    function cariLokasi(inputSelector, mapObj, markerObj, type) {
        const alamat = $(inputSelector).val();
        if (alamat.length < 3) return alert("Masukkan alamat yang lebih lengkap!");

        geo.geocode({
            address: alamat
        }, (results, status) => {
            if (status === "OK") {
                const loc = results[0].geometry.location;
                mapObj.setCenter(loc);
                mapObj.setZoom(17);
                markerObj.setPosition(loc);
                if (type) updateFields(type, loc.lat(), loc.lng(), results[0].formatted_address);
            } else {
                alert("Lokasi tidak ditemukan: " + status);
            }
        });
    }

    // --- Event Listeners ---

    // 1. Pencarian
    $('#btnCariTambah').click(() => cariLokasi('#searchTambah', mapT, markerT, "Tambah"));
    $('#btnCariEdit').click(() => cariLokasi('#searchEdit', mapE, markerE, "Edit"));

    // Enter key support
    $('#searchTambah, #searchEdit').on('keypress', function(e) {
        if (e.which == 13) {
            e.preventDefault();
            $(this).attr('id') === 'searchTambah' ? $('#btnCariTambah').click() : $('#btnCariEdit').click();
        }
    });

    // 2. Tombol EDIT Click
    $('.btn-edit').on('click', function() {
        const d = $(this).data();
        // Isi form
        $('#namaEdit').val(d.nama);
        // Asumsi ada data-email dan data-telp di tombol edit (sesuaikan jika perlu)
        $('#emailEdit').val($(this).closest('tr').find('td:eq(1)').text()); // Ambil dari tabel jika attr data kurang
        $('#noTelpEdit').val($(this).closest('tr').find('td:eq(2)').text());

        $('#alamatEdit').val(d.alamat);
        $('#latEdit').val(d.lat);
        $('#lngEdit').val(d.lng);
        $('#formEdit').attr('action', '/koperasi/update/' + d.id);

        // Refresh Map Edit
        setTimeout(() => {
            const pos = {
                lat: parseFloat(d.lat),
                lng: parseFloat(d.lng)
            };
            mapE.setCenter(pos);
            mapE.setZoom(17);
            markerE.setPosition(pos);
            google.maps.event.trigger(mapE, "resize");
        }, 500);
    });

    // 3. Tombol DETAIL Click (Logic Baru)
    $('.btn-detail').on('click', function() {
        const d = $(this).data();

        // Isi Text
        $('#detailNama').text(d.nama);
        $('#detailAlamat').text(d.alamat);

        // Karena tombol detail di PHP kamu belum punya data-email/telp, 
        // kita ambil dari kolom tabel (DOM traversing)
        const row = $(this).closest('tr');
        $('#detailEmail').text(row.find('td:eq(1)').text());
        $('#detailTelp').text(row.find('td:eq(2)').text());

        // Refresh Map Detail
        // Delay sedikit agar modal render dulu baru map dirender
        setTimeout(() => {
            const pos = {
                lat: parseFloat(d.lat),
                lng: parseFloat(d.lng)
            };
            mapD.setCenter(pos);
            mapD.setZoom(16);
            markerD.setPosition(pos);
            google.maps.event.trigger(mapD, "resize");
        }, 300);
    });

    // Trigger resize saat modal tampil penuh (Fallback)
    document.getElementById('modalTambah').addEventListener('shown.bs.modal', () => google.maps.event.trigger(mapT, "resize"));
    document.getElementById('modalEdit').addEventListener('shown.bs.modal', () => google.maps.event.trigger(mapE, "resize"));
    document.getElementById('modaldetail').addEventListener('shown.bs.modal', () => google.maps.event.trigger(mapD, "resize"));
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=<?= $google_maps_api_key ?>&libraries=places&callback=initGoogleMaps" async defer></script>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        $('#tableKoperasi').DataTable();
    });
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>