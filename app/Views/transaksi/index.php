<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Data Transaksi Koperasi</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTransaksi">
            <i class="fa-solid fa-plus me-1"></i> Tambah Transaksi
        </button>
    </div>

    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-success alert-dismissible fade show border-0" role="alert"><?= session()->getFlashdata('pesan'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm p-3">
        <div class="table-responsive">
            <table id="tableTransaksi" class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Jenis</th>
                        <th>Nominal</th>
                        <th>Koperasi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($transaksi as $t) : ?>
                        <tr>
                            <td class="small fw-bold"><?= $no++ ?></td>
                            <td><?= date('d M Y', strtotime($t['tanggal'])) ?></td>
                            <td><span class="badge bg-light text-dark border"><?= $t['kategori'] ?></span></td>
                            <td>
                                <?php if ($t['jenis'] == 'pemasukan') : ?>
                                    <span class="badge bg-success-subtle text-success">Masuk</span>
                                <?php else : ?>
                                    <span class="badge bg-danger-subtle text-danger">Keluar</span>
                                <?php endif; ?>
                            </td>
                            <td class="fw-bold">Rp <?= number_format($t['nominal'], 0, ',', '.') ?></td>
                            
                            <td><?= esc($t['nama_koperasi'] ?? 'Koperasi Pusat') ?></td>
                            <td class="d-flex gap-1 justify-content-center">
                                <button class="btn btn-warning btn-sm btn-edit"
                                    data-id="<?= $t['id'] ?>"
                                    data-kode="<?= esc($t['kode_transaksi']) ?>"
                                    data-anggota="<?= $t['anggota_id'] ?? '' ?>"
                                    data-koperasi="<?= $t['koperasi_id'] ?>"
                                    data-jenis="<?= esc($t['jenis']) ?>"
                                    data-kategori="<?= esc($t['kategori']) ?>"
                                    data-sumber="<?= esc($t['sumber']) ?>"
                                    data-nominal="<?= $t['nominal'] ?>"
                                    data-tanggal="<?= $t['tanggal'] ?>"
                                    data-keterangan="<?= esc($t['keterangan'] ?? '') ?>">
                                    <i class="fa-solid fa-pen-to-square text-light"></i>
                                </button>

                                <form action="/transaksi/delete/<?= $t['id'] ?>" method="post" class="d-inline">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger btn-sm text-light" onclick="return confirm('Hapus transaksi ini?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>

                                <button class="btn btn-info btn-sm btn-detail"
                                    data-kode="<?= esc($t['kode_transaksi']) ?>"
                                    data-anggota="<?= esc($t['nama_anggota'] ?? '-') ?>"
                                    data-koperasi="<?= esc($t['nama_koperasi'] ?? 'Koperasi Pusat') ?>"
                                    data-jenis="<?= esc($t['jenis']) ?>"
                                    data-kategori="<?= esc($t['kategori']) ?>"
                                    data-sumber="<?= esc($t['sumber']) ?>"
                                    data-nominal="<?= number_format($t['nominal'], 0, ',', '.') ?>"
                                    data-tanggal="<?= date('d M Y', strtotime($t['tanggal'])) ?>"
                                    data-keterangan="<?= esc($t['keterangan'] ?? '') ?>">
                                    <i class="fa-solid fa-eye text-light"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Transaksi -->
<div class="modal fade" id="modalTransaksi" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="/transaksi/save" method="post">
                <?= csrf_field() ?>
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Catat Transaksi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold small mb-1">Kode Transaksi</label>
                            <input type="text" name="kode_transaksi" class="form-control bg-light" value="<?= $auto_code ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold small mb-1">Metode Pembayaran</label>
                            <select name="sumber" class="form-select" required>
                                <option value="transfer" <?= old('sumber') === 'transfer' ? 'selected' : '' ?>>Transfer</option>
                                <option value="cash" <?= old('sumber') === 'cash' ? 'selected' : '' ?>>Cash</option>
                                <option value="e-wallet" <?= old('sumber') === 'e-wallet' ? 'selected' : '' ?>>E-wallet</option>
                                <option value="lainnya" <?= old('sumber') === 'lainnya' ? 'selected' : '' ?>>Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold small mb-1">Jenis Transaksi</label>
                            <select name="jenis" class="form-select" required>
                                <option value="pemasukan" <?= old('jenis') === 'pemasukan' ? 'selected' : '' ?>>Uang Masuk (Pemasukan)</option>
                                <option value="pengeluaran" <?= old('jenis') === 'pengeluaran' ? 'selected' : '' ?>>Uang Keluar (Pengeluaran)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold small mb-1">Kategori</label>
                            <input type="text" name="kategori" class="form-control" placeholder="Simpanan, Bunga, Listrik, ATK..." value="<?= old('kategori') ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold small mb-1">Nominal (RP)</label>
                            <input type="number" name="nominal" class="form-control form-control-lg text-primary fw-bold" placeholder="0" value="<?= old('nominal') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold small mb-1">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="<?= old('tanggal') ?? date('Y-m-d') ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold small mb-1">Koperasi Induk</label>
                            <select name="koperasi_id" class="form-select" required>
                                <?php foreach ($list_koperasi as $k) : ?>
                                    <option value="<?= $k['id'] ?>" <?= old('koperasi_id') == $k['id'] ? 'selected' : '' ?>><?= $k['nama'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold small mb-1">Oleh Anggota : </label>
                            <select name="anggota_id" class="form-select">
                                <option value="">-- Pilih Anggota --</option>
                                <?php foreach ($list_anggota as $a) : ?>
                                    <option value="<?= $a['id'] ?>" <?= old('anggota_id') == $a['id'] ? 'selected' : '' ?>>
                                        <?= $a['nama'] ?> (<?= $a['nama_koperasi'] ?? 'Koperasi Pusat' ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="">
                        <label class="fw-bold small mb-1">Keterangan (OPTIONAL)</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Catatan tambahan..."><?= old('keterangan') ?></textarea>
                    </div>

                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Transaksi -->
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="" id="formEdit" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold small mb-1">Kode Transaksi</label>
                            <input type="text" name="kode_transaksi" id="edit_kode" class="form-control bg-light" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold small mb-1">Metode Pembayaran</label>
                            <select name="sumber" id="edit_sumber" class="form-select" required>
                                <option value="transfer">Transfer</option>
                                <option value="cash">Cash</option>
                                <option value="e-wallet">E-wallet</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold small mb-1">Jenis Transaksi</label>
                            <select name="jenis" id="edit_jenis" class="form-select" required>
                                <option value="pemasukan">Uang Masuk (Pemasukan)</option>
                                <option value="pengeluaran">Uang Keluar (Pengeluaran)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold small mb-1">Kategori</label>
                            <input type="text" name="kategori" id="edit_kategori" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold small mb-1">Nominal (RP)</label>
                            <input type="number" name="nominal" id="edit_nominal" class="form-control form-control-lg text-primary fw-bold" required>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold small mb-1">Tanggal Transaksi</label>
                            <input type="date" name="tanggal" id="edit_tanggal" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold small mb-1">Koperasi Induk</label>
                            <select name="koperasi_id" id="edit_koperasi" class="form-select" required>
                                <?php foreach ($list_koperasi as $k) : ?>
                                    <option value="<?= $k['id'] ?>"><?= $k['nama'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold small mb-1">Oleh Anggota : </label>
                            <select name="anggota_id" id="edit_anggota" class="form-select">
                                <option value="">-- Pilih Anggota --</option>
                                <?php foreach ($list_anggota as $a) : ?>
                                    <option value="<?= $a['id'] ?>">
                                        <?= $a['nama'] ?> (<?= $a['nama_koperasi'] ?? 'Koperasi Pusat' ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold small mb-1">Keterangan</label>
                        <textarea name="keterangan" id="edit_keterangan" class="form-control" rows="3" placeholder="Catatan tambahan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-warning w-100 py-2 fw-bold shadow text-dark">UPDATE DATA</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail Transaksi -->
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-primary text-white border-bottom-0">
                <h5 class="modal-title"><i class="fa-solid fa-circle-info me-2"></i>Detail Transaksi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="bg-light p-4 text-center border-bottom">
                    <h6 class="text-uppercase text-muted fw-bold small mb-2">Total Nominal</h6>
                    <h2 class="fw-bold text-dark display-6 mb-0">Rp <span id="detail_nominal">0</span></h2>
                    <span class="badge mt-2 px-3 py-2 rounded-pill" id="detail_jenis_badge">Jenis</span>
                </div>
                <div class="p-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Kode Transaksi</span>
                            <span class="fw-bold font-monospace" id="detail_kode">-</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Tanggal</span>
                            <span class="fw-bold" id="detail_tanggal">-</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Kategori</span>
                            <span class="fw-bold text-end" id="detail_kategori">-</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Sumber Dana</span>
                            <span class="fw-bold" id="detail_sumber">-</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Unit Koperasi</span>
                            <span class="fw-bold text-end" id="detail_koperasi_nama">-</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Nama Anggota</span>
                            <span class="fw-bold text-end" id="detail_anggota_nama">-</span>
                        </li>
                        <li class="list-group-item px-0 mt-2">
                            <span class="text-muted d-block mb-1">Keterangan / Catatan:</span>
                            <div class="p-3 bg-light rounded text-dark small fst-italic border" id="detail_keterangan">
                                -
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer border-top-0 bg-light">
                <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        $('#tableTransaksi').DataTable();

        // Handle Tombol Edit
        $(document).on('click', '.btn-edit', function() {
            const id = $(this).data('id');
            const kode = $(this).data('kode');
            const anggota = $(this).data('anggota');
            const koperasi = $(this).data('koperasi');
            const jenis = $(this).data('jenis');
            const kategori = $(this).data('kategori');
            const sumber = $(this).data('sumber');
            const nominal = $(this).data('nominal');
            const tanggal = $(this).data('tanggal');
            const keterangan = $(this).data('keterangan');

            // Set form action
            $('#formEdit').attr('action', '/transaksi/update/' + id);

            // Populate form fields
            $('#edit_kode').val(kode);
            $('#edit_anggota').val(anggota);
            $('#edit_koperasi').val(koperasi);
            $('#edit_jenis').val(jenis);
            $('#edit_kategori').val(kategori);
            $('#edit_sumber').val(sumber);
            $('#edit_nominal').val(nominal);
            $('#edit_tanggal').val(tanggal);
            $('#edit_keterangan').val(keterangan);

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('modalEdit'));
            modal.show();
        });

        // Handle Tombol Detail
        $(document).on('click', '.btn-detail', function() {
            const kode = $(this).data('kode');
            const sumber = $(this).data('sumber');
            const jenis = $(this).data('jenis');
            const kategori = $(this).data('kategori');
            const nominal = $(this).data('nominal');
            const tanggal = $(this).data('tanggal');
            const koperasi = $(this).data('koperasi');
            const anggota = $(this).data('anggota');
            const keterangan = $(this).data('keterangan');

            // Populate detail modal
            $('#detail_kode').text(kode);
            $('#detail_sumber').text(sumber);
            $('#detail_kategori').text(kategori);
            $('#detail_nominal').text(nominal);
            $('#detail_tanggal').text(tanggal);
            $('#detail_koperasi_nama').text(koperasi);
            $('#detail_anggota_nama').text(anggota);
            $('#detail_keterangan').text(keterangan || 'Tidak ada keterangan.');

            // Set badge for jenis
            const badge = $('#detail_jenis_badge');
            if (jenis === 'pemasukan') {
                badge.text('PEMASUKAN')
                    .removeClass('bg-danger')
                    .addClass('bg-success');
            } else {
                badge.text('PENGELUARAN')
                    .removeClass('bg-success')
                    .addClass('bg-danger');
            }

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('modalDetail'));
            modal.show();
        });
    });
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>