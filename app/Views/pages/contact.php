<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="container mt-2">
    <div class="row">
        <div class="col">
            <h1>Contact Me</h1>
            <p>This is the contact page. You can reach me at</p>
        </div>
        <div class="col">
            <h2>Alamat</h2>
            <?php foreach ($alamat as $a) :?>
                <ul>
                    <li><?= $a['tipe']; ?></li>
                    <li><?= $a['alamat']; ?></li>
                </ul>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>