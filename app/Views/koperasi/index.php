<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">Data Lokasi Koperasi</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Koperasi</button>
    </div>

    

    <div class="card shadow-sm p-3">
        <table id="tableKoperasi" class="table table-hover">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($koperasi as $k) : ?>
                    <tr>
                        <td><strong><?= $k['nama'] ?></strong></td>
                        <td><?= $k['alamat'] ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm btn-edit"
                                data-bs-toggle="modal" data-bs-target="#modalEdit"
                                data-id="<?= $k['id'] ?>" data-nama="<?= $k['nama'] ?>"
                                data-alamat="<?= $k['alamat'] ?>" data-lat="<?= $k['latitude'] ?>"
                                data-lng="<?= $k['longitude'] ?>">Edit</button>
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
                        <label>Nama</label><input type="text" name="nama" class="form-control mb-2" required>
                        <div class="input-group">
                            <input type="text" id="searchTambah" class="form-control" placeholder="Ketik alamat...">
                            <button class="btn btn-dark" type="button" id="btnCariTambah">Cari</button>
                        </div>
                        <label>Alamat Detail</label><textarea name="alamat" id="alamatTambah" class="form-control mb-2" readonly></textarea>
                        <input type="hidden" name="latitude" id="latTambah"><input type="hidden" name="longitude" id="lngTambah">
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
                        <label>Nama</label><input type="text" name="nama" id="namaEdit" class="form-control mb-2">
                        <div class="input-group">
                            <input type="text" id="searchEdit" class="form-control" placeholder="Ketik alamat...">
                            <button class="btn btn-dark" type="button" id="btnCariEdit">Cari</button>
                        </div>
                        <label>Alamat Detail</label><textarea name="alamat" id="alamatEdit" class="form-control mb-2" readonly></textarea>
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

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script>
    let mapT, markerT, mapE, markerE, geo;

    function initGoogleMaps() {
        geo = new google.maps.Geocoder();
        // Setup Modal Tambah
        const center = {
            lat: -6.9175,
            lng: 107.6191
        };
        mapT = new google.maps.Map(document.getElementById("mapTambah"), {
            center: center,
            zoom: 13
        });
        markerT = new google.maps.Marker({
            position: center,
            map: mapT,
            draggable: true
        });

        setupMarkerEvent(markerT, "Tambah");

        mapE = new google.maps.Map(document.getElementById("mapEdit"), {
            center: center,
            zoom: 13
        });

        markerE = new google.maps.Marker({
            map: mapE,
            draggable: true
        });

        setupMarkerEvent(markerE, "Edit");
    }

    // Fungsi General untuk Mencari Alamat
    function cariLokasi(inputSelector, mapObj, markerObj, type) {
        const alamat = $(inputSelector).val();
        if (alamat.length < 3) return alert("Masukkan alamat yang lebih lengkap!");

        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({
            address: alamat
        }, (results, status) => {
            if (status === "OK") {
                const loc = results[0].geometry.location;

                // Pindahkan Peta dan Marker
                mapObj.setCenter(loc);
                mapObj.setZoom(17);
                markerObj.setPosition(loc);

                // Update Input Hidden/Text
                updateFields(type, loc.lat(), loc.lng(), results[0].formatted_address);
            } else {
                alert("Lokasi tidak ditemukan: " + status);
            }
        });
    }

    // Event Klik Tombol Cari di Modal Tambah
    $('#btnCariTambah').on('click', function() {
        cariLokasi('#searchTambah', mapT, markerT, "Tambah");
    });

    // Event Klik Tombol Cari di Modal Edit
    $('#btnCariEdit').on('click', function() {
        cariLokasi('#searchEdit', mapE, markerE, "Edit");
    });

    // Tips: Agar bisa tekan "Enter" juga untuk mencari
    $('#searchTambah, #searchEdit').on('keypress', function(e) {
        if (e.which == 13) {
            e.preventDefault();
            const id = $(this).attr('id');
            if (id === 'searchTambah') $('#btnCariTambah').click();
            else $('#btnCariEdit').click();
        }
    });

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

    // Handle Tombol Edit
    $('.btn-edit').on('click', function() {
        const d = $(this).data();
        $('#namaEdit').val(d.nama);
        $('#alamatEdit').val(d.alamat);
        $('#latEdit').val(d.lat);
        $('#lngEdit').val(d.lng);
        $('#lngEdit').val(d.lng);
        $('#searchEdit').val('');
        $('#formEdit').attr('action', '/koperasi/update/' + d.id);

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

    // Load Map saat Modal Terbuka
    document.getElementById('modalTambah').addEventListener('shown.bs.modal', () => google.maps.event.trigger(mapT, "resize"));

    document.getElementById('modalEdit').addEventListener('shown.bs.modal', () => google.maps.event.trigger(mapE, "resize"));
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