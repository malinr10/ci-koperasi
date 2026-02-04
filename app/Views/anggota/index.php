<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nomor Anggota</th>
                        <th scope="col">Nama Anggota</th>
                        <th scope="col">Email</th>
                        <th scope="col">Tanggal Bergabung</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($anggota as $a) : ?>
                    <tr>
                        <th scope="row"><?= $i++ ?></th>
                        <td><?= $a['nomor_anggota'] ?></td>
                        <td><?= $a['nik'] ?></td>
                        <td><?= $a['nama'] ?></td>
                        <td><?= $a['tanggal_daftar'] ?></td>
                        <td><?= $a['status'] ?></td>
                        <td><button class="btn btn-success">Detail</button></td>
                    </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>