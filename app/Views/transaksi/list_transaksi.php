<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <h3 class="mb-4">List Transaksi</h3>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
    <?php endif; ?>

    <table class="table table-bordered" id="tableTransaksi" style="width:100%">
        <thead>
            <tr class="text-center">
                <th>No. PO</th>
                <th>Tanggal Transaksi</th>
                <th>Pemohon</th>
                <th>Total Tagihan</th>
                <th>Lunas</th>
                <th style="width: 150px;">Aksi</th>
            </tr>
        </thead>

        <tbody>
        <?php $no = 1; foreach ($transaksi as $t): ?>
            <tr>
                <td><?= $t['no_po']; ?></td>
                <td><?= date('d-m-Y', strtotime($t['tgl_transaksi'])); ?></td>
                <td><?= $t['nama_user']; ?></td>
                <td>Rp <?= number_format($t['total_tagihan'], 0, ',', '.'); ?></td>

                <td>
                    <?php if ($t['status_bayar'] == 'lunas'): ?>
                        <span class="badge-status badge-lunas">Lunas</span>
                    <?php else: ?>
                        <span class="badge-status badge-belum">Belum</span>
                    <?php endif; ?>
                </td>

                <td class="text-center">

                    <!-- btn detail -->
                    <a href="#" 
                        class="btn btn-info btn-sm btnDetail"
                        data-id="<?= $t['id_transaksi']; ?>">
                        <i class="fas fa-eye"></i>
                    </a>

                    <!-- tombol bayar jika status belum -->
                    <?php if ($t['status_bayar'] == 'belum'): ?>
                        <button class="btn btn-success btn-sm btnBayar"
                                data-id="<?= $t['id_transaksi'] ?>">
                            Bayar
                        </button>
                    <?php endif; ?>

                    <!-- tombol delete -->
                    <button class="btn btn-danger btn-sm btnDelete"
                            data-id="<?= $t['id_transaksi'] ?>">
                        <i class="fas fa-trash"></i>
                    </button>

                </td>

            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>


<div class="modal fade" id="modalDetailTransaksi" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Detail Transaksi</h4>
                <button class="btn-close" data-bs-dismiss="modal">x</button>
            </div>

            <div class="modal-body" id="contentDetailTransaksi">
                <div class="text-center py-5">
                    <div class="spinner-border"></div>
                    <p>Memuat data...</p>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="modalBayar" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Pembayaran Transaksi</h5>
                <button class="btn-close" data-bs-dismiss="modal">x</button>
            </div>

            <div class="modal-body" id="contentBayar">
                <div class="text-center py-4">
                    <div class="spinner-border"></div>
                    <p>Memuat data...</p>
                </div>
            </div>

        </div>
    </div>
</div>


<style>
.badge-status {
    font-weight: bold;
    font-size: 14px;
    padding: 3px 8px;
    border-radius: 4px;
}
.badge-belum  { color:#8a6d00; background:#fff3cd; }
.badge-lunas  { color:#0f6d00; background:#d1e7dd; }
</style>


<script>
$(document).ready(function() {
    $('#tableTransaksi').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100]
    });

});
</script>

<script>
$(document).on("click", ".btnDetail", function(e){
    e.preventDefault();

    let id = $(this).data("id");

    $("#modalDetailTransaksi").modal("show");
    $("#contentDetailTransaksi").html(`
        <div class="text-center py-5">
            <div class="spinner-border"></div>
            <p>Memuat data...</p>
        </div>
    `);

    $("#contentDetailTransaksi").load("<?= base_url('transaksi/detail'); ?>/" + id);
});
</script>


<script>
$(document).on("click", ".btnDelete", function(){
    let id = $(this).data("id");

    Swal.fire({
        title: "Hapus Transaksi?",
        text: "Data transaksi dan pembayaran akan dihapus permanen!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya",
        cancelButtonText: "Batal"
    }).then((r)=>{
        if(r.isConfirmed){
            
            $.get("<?= base_url('transaksi/delete'); ?>/" + id, function(res){

                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: res.message,
                        timer: 800,
                        showConfirmButton: false
                    });
                    setTimeout(()=> location.reload(), 800);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: res.message || 'Gagal menghapus'
                    });
                }

            }, 'json').fail(()=>{
                Swal.fire({
                    icon:'error',
                    title:'Terjadi kesalahan server'
                });
            });

        }
    });
});
</script>

<script>
$(document).on("click", ".btnBayar", function(){
    let id = $(this).data("id");

    $("#modalBayar").modal("show");
    $("#contentBayar").html(`
        <div class="text-center py-4">
            <div class="spinner-border"></div>
            <p>Memuat data...</p>
        </div>
    `);

    $("#contentBayar").load("<?= base_url('transaksi/form-bayar'); ?>/" + id);
});
</script>

<?= $this->endSection(); ?>
