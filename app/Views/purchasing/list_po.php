<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <h3 class="mb-3">Daftar Purchase Order</h3>

    <a href="<?= base_url('purchasing/request_po'); ?>" 
       class="btn btn-primary btn-sm mb-3">+ Buat PO</a>

    <table class="table table-bordered" id="tablePO">
        <thead>
            <tr class="text-center">
                <th>No. PO</th>
                <th>Tanggal</th>
                <th>Supplier</th>
                <th>Departemen</th>
                <th>Pool</th>
                <th>Status</th>
                <th style="width: 150px;">Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($po as $p): ?>
                <tr>
                    <td><?= $p['no_po'] ?></td>
                    <td><?= date('d-m-Y', strtotime($p['tgl_po'])) ?></td>
                    <td><?= $p['nama_supplier'] ?></td>
                    <td><?= $p['nama_departemen'] ?></td>
                    <td><?= $p['nama_pool'] ?></td>
                    <?php
                    $status = strtolower($p['status_po']);
                    $badgeClass = 'badge-status badge-' . $status;
                    ?>

                    <td>
                        <span class="<?= $badgeClass ?>">
                            <?= strtoupper($p['status_po']) ?>
                        </span>
                    </td>
                    </td>
                    <td class="text-center">
                        <!-- Detail -->
                        <a href="#" 
                            class="btn btn-info btn-sm py-1 px-2 btnDetail" 
                            data-id="<?= $p['id_po'] ?>">
                            <i class="fas fa-eye"></i>
                        </a>

                        <!-- Edit & Send & Delete hanya untuk draft -->
                        <?php if ($p['status_po'] === 'draft'): ?>
                            <a href="<?= base_url('/purchasing/po_edit/'.$p['id_po']) ?>" 
                                class="btn btn-warning btn-sm py-1 px-2">
                                <i class="fas fa-edit"></i>
                            </a>

                            <button class="btn btn-success btn-sm py-1 px-2 btnSend"
                                    data-id="<?= $p['id_po'] ?>">
                                Send
                            </button>

                            <button class="btn btn-danger btn-sm py-1 px-2 btnDelete"
                                    data-id="<?= $p['id_po'] ?>">
                                <i class="fas fa-trash"></i>
                            </button>
                        <?php endif; ?>

                        <!-- Tombol Print hanya untuk approve -->
                        <?php if ($p['status_po'] === 'approve'): ?>
                            <a href="<?= base_url('purchasing/po_print/'.$p['id_po']); ?>" 
                            target="_blank"
                            class="btn btn-primary btn-sm py-1 px-2">
                                <i class="fas fa-print"></i>
                            </a>
                        <?php endif; ?>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- ===========================
     MODAL DETAIL PO
=========================== -->
<div class="modal fade" id="modalDetailPO" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Detail Purchase Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">x</button>
            </div>

            <div class="modal-body" id="detailPOContent">
                <div class="text-center py-5">
                    <div class="spinner-border"></div>
                    <p>Sedang memuat...</p>
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
.badge-draft   { color: #000; background-color: #e0e0e0; }
.badge-send    { color: #8a6d00; background-color: #fff3cd; }
.badge-reject  { color: #b10000; background-color: #f8d7da; }
.badge-approve { color: #0f6d00; background-color: #d1e7dd; }
</style>

<script>
$(document).ready(function() {

    // Aktifkan DataTables
    $('#tablePO').DataTable({
        "pageLength": 10,
        "lengthMenu": [10, 25, 50, 100]
    });

    // Delete PO
    $(document).on("click", ".btnDelete", function(e){
        e.preventDefault();  // cegah default
        let id = $(this).data("id");

        Swal.fire({
            title: "Hapus PO?",
            text: "Data PO akan terhapus permanen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: "Batal"
        }).then((r)=>{
            if(r.isConfirmed){
                $.get("<?= base_url('purchasing/delete_po'); ?>/" + id, function(res){
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
                }, 'json')
                .fail(function(xhr){
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan server'
                    });
                });
            }
        });
    });

});
</script>

<script>
$(document).on("click", ".btnDetail", function(e){
    e.preventDefault();

    let id = $(this).data("id");

    $("#modalDetailPO").modal("show");
    $("#detailPOContent").html(`
        <div class="text-center py-5">
            <div class="spinner-border"></div>
            <p>Memuat data...</p>
        </div>
    `);

    $("#detailPOContent").load("<?= base_url('purchasing/po_detail'); ?>/" + id);
});
</script>

<script>
$(document).on("click", ".btnSend", function(){
    let id = $(this).data("id");

    Swal.fire({
        title: "Kirim PO?",
        text: "Data PO akan dikirim ke bagian Finance.",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Kirim",
        cancelButtonText: "Batal"
    }).then((r)=>{
        if(r.isConfirmed){
            $.get("<?= base_url('purchasing/send_po'); ?>/" + id, function(res){

                Swal.fire({
                    icon:'success',
                    title:res.message,
                    timer:800,
                    showConfirmButton:false
                });

                setTimeout(()=> location.reload(), 800);

            },'json');
        }
    });
});
</script>

<?= $this->endSection(); ?>
