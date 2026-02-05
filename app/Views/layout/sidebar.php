<div class="bg-white" id="sidebar-wrapper">
    <div class="sidebar-heading border-bottom bg-white">
        <i class="bi bi-building me-1"></i> KOPERASI<span class="text-dark">PRO</span>
    </div>

    <div class="list-group list-group-flush my-3">

        <a href="/" class="list-group-item list-group-item-action bg-transparent <?= url_is('/') ? 'active' : '' ?>">
            <i class="fa-solid fa-house"></i> Dashboard
        </a>

        <a href="/anggota" class="list-group-item list-group-item-action bg-transparent <?= url_is('anggota*') ? 'active' : '' ?>">
            <i class="fa-solid fa-people-group"></i> Data Anggota
        </a>

        <a href="/transaksi" class="list-group-item list-group-item-action bg-transparent <?= url_is('transaksi*') ? 'active' : '' ?>">
            <i class="fa-solid fa-money-bill"></i> Data Transaksi
        </a>

        <a href="/koperasi" class="list-group-item list-group-item-action bg-transparent <?= url_is('koperasi*') ? 'active' : '' ?>">
            <i class="fa-solid fa-shop"></i> Data Koperasi
        </a>

    </div>
</div>