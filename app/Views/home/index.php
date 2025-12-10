<?= $this->extend('templates/index'); ?>


<?= $this->section('page-content'); ?>

                <div class="container-fluid">
                <h3 class="mb-0">Selamat Datang ke dalam Sistem Manajemen Purchase Order, <b><?= user()->username; ?> </b>. :)</h3>

                </div>

<?= $this->endSection(); ?>