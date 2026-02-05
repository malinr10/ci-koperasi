<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Data Anggota Koperasi</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Koperasi</button>
    </div>

    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-success"><?= session()->getFlashdata('pesan'); ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm p-3">
        <table id="tabelAnggota" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Anggota</th>
                    <th>Alamat</th>
                    <th>No HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($anggota as $a) : ?>
                    <tr>
                        <th><?= $i++ ?></th>
                        <td><?= $a['nama'] ?></td>
                        <td><?= $a['alamat'] ?></td>
                        <td><?= $a['no_hp'] ?></td>
                        <td class="d-flex gap-1">
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $a['id'] ?>"><i class="fa-solid fa-pen-to-square" style="color: white;"></i></button>

                            <form action="/anggota/<?= $a['id'] ?>" method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data?')"><i class="fa-solid fa-trash"></i></button>
                            </form>

                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $a['id'] ?>"><i class="fa-solid fa-eye" style="color: white;"></i></button>
                        </td>
                    </tr>

                    <!-- Modal Update -->
                    <div class="modal fade" id="modalEdit<?= $a['id'] ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="/anggota/update/<?= $a['id'] ?>" method="post">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="PUT">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Anggota: <?= $a['nama'] ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label>Nama Lengkap</label>
                                                <input type="text" name="nama" class="form-control" value="<?= $a['nama'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>NIK</label>
                                                <input type="text" name="nik" class="form-control" value="<?= $a['nik'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Alamat</label>
                                                <input type="text" name="alamat" class="form-control" value="<?= $a['alamat'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                                <input type="date" name="tanggal_lahir" class="form-control" value="<?= $a['tanggal_lahir'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="no_hp">No HP</label>
                                                <input type="text" name="no_hp" class="form-control" value="<?= $a['no_hp'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                                <select name="jenis_kelamin" class="form-select">
                                                    <option value="L" <?= ($a['jenis_kelamin'] == 'L') ? 'selected' : '' ?>>Laki-laki</option>
                                                    <option value="P" <?= ($a['jenis_kelamin'] == 'P') ? 'selected' : '' ?>>Perempuan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <dic class="mb-3">
                                            <label class="form-label">Pilih Koperasi Induk</label>
                                            <select name="koperasi_id" class="form-select">
                                                <?php foreach ($list_koperasi as $k) : ?>
                                                    <option value="<?= $k['id'] ?>" <?= ($a['koperasi_id'] == $k['id']) ? 'selected' : '' ?>><?= $k['nama'] ?> - <?= $k['kota'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </dic>
                                        <div class="mb-3">
                                            <label>Status</label>
                                            <select name="status" class="form-select">
                                                <option value="aktif" <?= ($a['status'] == 'aktif') ? 'selected' : '' ?>>Aktif</option>
                                                <option value="nonaktif" <?= ($a['status'] == 'nonaktif') ? 'selected' : '' ?>>Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-warning">Update Data</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- modal detail -->
                    <div class="modal fade" id="modalDetail<?= $a['id'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content shadow-lg border-0">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title">
                                        <i class="bi bi-person-vcard me-2"></i> Profil Anggota: <?= $a['nama'] ?>
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body p-4">
                                    <div class="row">
                                        <div class="col-md-6 border-end">
                                            <h6 class="text-muted fw-bold text-uppercase mb-3 small">Identitas Diri</h6>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between align-items-start border-0 px-0">
                                                    <div class="ms-2 me-auto">
                                                        <div class="small text-muted">Nomor Anggota</div>
                                                        <div class="fw-bold"><?= $a['nomor_anggota'] ?></div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-start border-0 px-0">
                                                    <div class="ms-2 me-auto">
                                                        <div class="small text-muted">NIK</div>
                                                        <div class="fw-bold"><?= $a['nik'] ?></div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-start border-0 px-0">
                                                    <div class="ms-2 me-auto">
                                                        <div class="small text-muted">Jenis Kelamin</div>
                                                        <div class="fw-bold"><?= ($a['jenis_kelamin'] == 'L') ? 'Laki-laki' : 'Perempuan' ?></div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-start border-0 px-0">
                                                    <div class="ms-2 me-auto">
                                                        <div class="small text-muted">Tanggal Lahir</div>
                                                        <div class="fw-bold"><?= date('d F Y', strtotime($a['tanggal_lahir'])) ?></div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-md-6 ps-md-4">
                                            <h6 class="text-muted fw-bold text-uppercase mb-3 small">Kontak & Keanggotaan</h6>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item border-0 px-0">
                                                    <div class="ms-2">
                                                        <div class="small text-muted">No. Handphone</div>
                                                        <div class="fw-bold text-primary"><?= $a['no_hp'] ?></div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item border-0 px-0">
                                                    <div class="ms-2">
                                                        <div class="small text-muted">Alamat</div>
                                                        <div class="fw-bold small"><?= $a['alamat'] ?></div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item border-0 px-0">
                                                    <div class="ms-2">
                                                        <div class="small text-muted">Terdaftar Sejak</div>
                                                        <div class="fw-bold"><?= date('d F Y', strtotime($a['tanggal_daftar'])) ?></div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item border-0 px-0">
                                                    <div class="ms-2">
                                                        <div class="small text-muted">Terdaftar di Koperasi</div>
                                                        <div class="fw-bold"><?= $a['nama_koperasi'] ?></div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item border-0 px-0">
                                                    <div class="ms-2">
                                                        <div class="small text-muted">Status Akun</div>
                                                        <span class="badge rounded-pill bg-<?= ($a['status'] == 'aktif') ? 'success' : 'danger' ?>">
                                                            <?= ucfirst($a['status']) ?>
                                                        </span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer border-top-0 p-3">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Anggota -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/anggota/save" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Anggota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-6">
                        <input type="hidden" name="koperasi_id" value="1">
                        <div class="mb-3">
                            <label>NIK</label>
                            <input type="text" name="nik" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Alamat</label>
                            <input type="text" name="alamat" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>No HP</label>
                            <input type="text" name="no_hp" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="nama_koperasi">Nama Koperasi</label>
                        <select name="koperasi_id" class="form-select">
                            <?php foreach ($list_koperasi as $k) : ?>
                                <option value="<?= $k['id'] ?>"><?= $k['nama'] ?> - <?= $k['kota'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>
</div>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        $('#tabelAnggota').DataTable();
    });
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>