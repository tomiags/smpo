<?= $this->extend('templates/index'); ?> 
<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <h3 class="mb-4">List Pembayaran</h3>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
    <?php endif; ?>

    <table class="table table-bordered" id="tableBayar">
        <thead>
            <tr>
                <th>No. PO</th>
                <th>Tanggal Bayar</th>
                <th>Jumlah Bayar</th>
                <th>Dibuat Oleh</th>
                <th style="width: 120px;">Aksi</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($pembayaran as $b): ?>
            <tr>
                <td><?= $b['no_po']; ?></td>
                <td><?= date('d-m-Y', strtotime($b['tgl_bayar'])); ?></td>
                <td><?= number_format($b['jumlah_bayar']); ?></td>
                <td><?= $b['nama_user']; ?></td>

                <td>
                    <!-- Button Detail -->
                    <button class="btn btn-info btn-sm btnDetailBayar" data-id="<?= $b['id_bayar']; ?>">
                        <i class="fas fa-eye"></i>
                    </button>

                    <!-- Button Edit -->
                    <button class="btn btn-warning btn-sm btnEditBayar" data-id="<?= $b['id_bayar']; ?>">
                        <i class="fas fa-edit"></i>
                    </button>

                    <!-- Button Hapus -->
                    <button class="btn btn-danger btn-sm btnHapusBayar" data-id="<?= $b['id_bayar']; ?>">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>


<!-- Modal Detail -->
<div class="modal fade" id="modalDetailBayar" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Detail Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">x</button>
            </div>

            <div class="modal-body">
                <div id="contentDetailBayar">
                    <div class="text-center py-5">
                        <div class="spinner-border"></div>
                        <p>Memuat data...</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Edit Bayar -->
<div class="modal fade" id="modalEditBayar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Pembayaran</h5>
            </div>

            <div class="modal-body" id="contentEditBayar">
                <!-- Konten akan dimuat via AJAX -->
            </div>

        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    $('#tableBayar').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        order: []
    });
});

// Detail Pembayaran
$(document).on("click", ".btnDetailBayar", function () {
    let id = $(this).data("id");

    $("#modalDetailBayar").modal("show");
    $("#contentDetailBayar").html(`
        <div class="text-center py-5">
            <div class="spinner-border"></div>
            <p>Memuat data...</p>
        </div>
    `);

    $("#contentDetailBayar").load("<?= base_url('transaksi/detail-bayar'); ?>/" + id);
});


// Tombol Edit Bayar
$(document).on("click", ".btnEditBayar", function () {
    let id = $(this).data("id");

    $("#modalEditBayar").modal("show");
    $("#contentEditBayar").html(`
        <div class="text-center py-5">
            <div class="spinner-border"></div>
            <p>Memuat data...</p>
        </div>
    `);

    $("#contentEditBayar").load("<?= base_url('transaksi/edit-bayar'); ?>/" + id);
});


// Hapus Pembayaran
$(document).on("click", ".btnHapusBayar", function() {
    let id = $(this).data("id");

    Swal.fire({
        title: "Hapus Pembayaran?",
        text: "Data akan dihapus secara permanen!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, Hapus",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            $.get("<?= base_url('transaksi/delete-bayar'); ?>/" + id, function(response){
                
                if (response.status === 'success') {
                    Swal.fire({
                        icon: "success",
                        title: response.message,
                        timer: 900,
                        showConfirmButton: false
                    });

                    setTimeout(() => location.reload(), 900);

                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text: response.message
                    });
                }

            }, 'json');
        }
    });
});
</script>

<?= $this->endSection(); ?>
