<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <h3 class="mb-3">Approval Purchase Order</h3>

    <table class="table table-bordered" id="tableApproval">
        <thead>
            <tr class="text-center">
                <th>No. PO</th>
                <th>Tanggal</th>
                <th>Supplier</th>
                <th>Departemen</th>
                <th>Pool</th>
                <th width="220px">Aksi</th>
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

                <td class="text-center">

                    <!-- Tombol Detail -->
                    <button class="btn btn-info btn-sm py-1 px-2 btnDetail"
                            data-id="<?= $p['id_po'] ?>">
                        <i class="fas fa-eye"></i>
                    </button>

                    <!-- Tombol Approve -->
                    <button class="btn btn-success btn-sm py-1 px-2 btnApprove"
                            data-id="<?= $p['id_po'] ?>">
                        Approve
                    </button>

                    <!-- Tombol Reject -->
                    <button class="btn btn-danger btn-sm py-1 px-2 btnReject"
                            data-id="<?= $p['id_po'] ?>">
                        Reject
                    </button>

                </td>

            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- MODAL DETAIL -->
<div class="modal fade" id="modalDetailApproval">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Detail Purchase Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">x</button>
            </div>

            <div class="modal-body" id="detailApprovalContent">
                <div class="text-center py-5">
                    <div class="spinner-border"></div>
                    <p>Sedang memuat...</p>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
$(document).ready(function(){

    $('#tableApproval').DataTable();

    // ========= DETAIL ==========
    $(document).on("click", ".btnDetail", function(){
        let id = $(this).data("id");

        $("#modalDetailApproval").modal("show");
        $("#detailApprovalContent").html(`
            <div class="text-center py-5">
                <div class="spinner-border"></div>
                <p>Memuat data...</p>
            </div>
        `);

        $("#detailApprovalContent").load("<?= base_url('approval/detail'); ?>/" + id);
    });


    // ========= APPROVE ==========
    $(document).on("click", ".btnApprove", function(){
        let id = $(this).data("id");

        Swal.fire({
            title: "Approve PO?",
            text: "Apakah Anda yakin ingin menyetujui PO ini?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Ya, Setujui",
            cancelButtonText: "Batal"
        }).then((r) => {
            if(r.isConfirmed){
                $.post("<?= base_url('approval/approve'); ?>", 
                    { id_po: id },
                    function(res){
                        Swal.fire("Berhasil!", res.message, "success");
                        setTimeout(()=> location.reload(), 1000);
                    }, "json"
                );
            }
        });
    });


    // ========= REJECT ==========
    $(document).on("click", ".btnReject", function(){
        let id = $(this).data("id");

        Swal.fire({
            title: "Tolak PO?",
            text: "Apakah Anda yakin ingin menolak PO ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Tolak",
            cancelButtonText: "Batal"
        }).then((confirm) => {
            if(confirm.isConfirmed){

                // MINTA ALASAN
                Swal.fire({
                    title: "Alasan / Catatan Penolakan",
                    input: "textarea",
                    inputPlaceholder: "Tulis alasan penolakan...",
                    inputAttributes: { "aria-label": "Tulis alasan" },
                    showCancelButton: true,
                    confirmButtonText: "Kirim",
                    cancelButtonText: "Batal"
                }).then((hasil) => {

                    if(hasil.value){
                        $.post("<?= base_url('approval/reject'); ?>",
                            { id_po: id, catatan: hasil.value },
                            function(res){
                                Swal.fire("Ditolak!", res.message, "success");
                                setTimeout(()=> location.reload(), 1000);
                            }, "json"
                        );
                    }

                });
            }
        });
    });

});
</script>

<?= $this->endSection(); ?>
