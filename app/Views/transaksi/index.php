<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Data Transaksi Koperasi</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTransaksi">Tambah Transaksi</button>
    </div>

    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-success shadow-sm border-0"><?= session()->getFlashdata('pesan'); ?></div>
    <?php endif; ?>

    <div  class="card border-0 shadow-sm p-3">
        <div class="table-responsive">
            <table id="tableTransaksi" class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Sumber / Nama</th>
                        <th>Kategori</th>
                        <th>Jenis</th>
                        <th>Nominal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transaksi as $t) : ?>
                    <tr>
                        <td class="small fw-bold"><?= $t['kode_transaksi'] ?></td>
                        <td><?= date('d M Y', strtotime($t['tanggal'])) ?></td>
                        <td><?= $t['sumber'] ?></td>
                        <td><span class="badge bg-light text-dark border"><?= $t['kategori'] ?></span></td>
                        <td>
                            <?php if ($t['jenis'] == 'pemasukan') : ?>
                                <span class="badge bg-success-subtle text-success">Masuk</span>
                            <?php else : ?>
                                <span class="badge bg-danger-subtle text-danger">Keluar</span>
                            <?php endif; ?>
                        </td>
                        <td class="fw-bold">Rp <?= number_format($t['nominal'], 0, ',', '.') ?></td>
                        <td class="text-center">
                            <form action="/transaksi/delete/<?= $t['id'] ?>" method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm text-danger" onclick="return confirm('Hapus transaksi ini?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTransaksi" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="/transaksi/save" method="post">
                <?= csrf_field() ?>
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Catat Transaksi Kas</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold small mb-1">KODE TRANSAKSI</label>
                            <input type="text" name="kode_transaksi" class="form-control bg-light" value="<?= $auto_code ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold small mb-1">SUMBER / ANGGOTA</label>
                            <input type="text" name="sumber" class="form-control" placeholder="Contoh: Budi Sudarsono / Kas Kantor" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold small mb-1">JENIS KAS</label>
                            <select name="jenis" class="form-select" required>
                                <option value="pemasukan">Uang Masuk (Pemasukan)</option>
                                <option value="pengeluaran">Uang Keluar (Pengeluaran)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold small mb-1">KATEGORI</label>
                            <input type="text" name="kategori" class="form-control" placeholder="Simpanan, Bunga, Listrik, ATK..." required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold small mb-1">NOMINAL (RP)</label>
                            <input type="number" name="nominal" class="form-control form-control-lg text-primary fw-bold" placeholder="0" required>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold small mb-1">TANGGAL</label>
                            <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="fw-bold small mb-1">KETERANGAN TAMBAHAN</label>
                        <textarea name="keterangan" class="form-control" rows="2" placeholder="Catatan singkat jika ada..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow">SIMPAN TRANSAKSI KE KAS</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        $('#tableTransaksi').DataTable();
    });
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>