<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <h3 class="mb-3">Manajemen Pool</h3>
    
    <button class="btn btn-sm btn-primary mb-3" id="btnAdd">+ Tambah Pool</button>

    <table class="table table-bordered" id="tablePool">
        <thead>
            <tr>
                <th>Kode Pool</th>
                <th>Nama Pool</th>
                <th>Lokasi</th>
                <th>Kota/Kab</th>
                <th>Provinsi</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($pools as $p): ?>
                <tr>
                    <td><?= $p['kode_pool'] ?></td>
                    <td><?= $p['nama_pool'] ?></td>
                    <td><?= $p['lokasi_pool'] ?></td>
                    <td><?= $p['kota_pool'] ?></td>
                    <td><?= $p['prov_pool'] ?></td>

                    <td>
                        <button class="btn btn-sm btn-warning btnEdit" data-id="<?= $p['kode_pool'] ?>"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger btnDelete" data-id="<?= $p['kode_pool'] ?>"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<!-- =======================
    MODAL TAMBAH POOL
======================= -->
<div class="modal fade" id="modalAdd" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <form id="formAdd">

        <div class="modal-header">
            <h5 class="modal-title">Tambah Pool</h5>
        </div>

        <div class="modal-body">

            <div class="mb-2">
                <label>Nama Pool</label>
                <input type="text" name="nama_pool" class="form-control">
            </div>

            <div class="mb-2">
                <label>Lokasi Pool</label>
                <input type="text" name="lokasi_pool" class="form-control">
            </div>

            <div class="mb-2">
                <label>Kota</label>
                <input type="text" name="kota_pool" class="form-control">
            </div>

            <div class="mb-2">
                <label>Provinsi</label>
                <input type="text" name="prov_pool" class="form-control">
            </div>

        </div>

        <div class="modal-footer">
            <button class="btn btn-success">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>

      </form>

    </div>
  </div>
</div>


<!-- =======================
    MODAL EDIT POOL
======================= -->
<div class="modal fade" id="modalEdit" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <form id="formEdit">

        <div class="modal-header">
            <h5 class="modal-title">Edit Pool</h5>
        </div>

        <div class="modal-body">

            <input type="hidden" name="kode_pool" id="edit_kode_pool">

            <div class="mb-2">
                <label>Nama Pool</label>
                <input type="text" id="edit_nama_pool" name="nama_pool" class="form-control">
            </div>

            <div class="mb-2">
                <label>Lokasi Pool</label>
                <input type="text" id="edit_lokasi_pool" name="lokasi_pool" class="form-control">
            </div>

            <div class="mb-2">
                <label>Kota</label>
                <input type="text" id="edit_kota_pool" name="kota_pool" class="form-control">
            </div>

            <div class="mb-2">
                <label>Provinsi</label>
                <input type="text" id="edit_prov_pool" name="prov_pool" class="form-control">
            </div>

        </div>

        <div class="modal-footer">
            <button class="btn btn-success">Update</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>

      </form>

    </div>
  </div>
</div>

<script>
$(document).ready(function(){

    let modalAdd  = new bootstrap.Modal(document.getElementById("modalAdd"));
    let modalEdit = new bootstrap.Modal(document.getElementById("modalEdit"));

    $('#tablePool').DataTable();

    // ============= TAMPILKAN MODAL TAMBAH =============
    $("#btnAdd").click(function () {
        $("#formAdd")[0].reset();
        $(".error").text("");
        modalAdd.show();
    });

    // ============= SIMPAN POOL =============
    $("#formAdd").submit(function(e){
        e.preventDefault();

        $.ajax({
            url: "<?= base_url('pool/store'); ?>",
            type: "POST",
            dataType: "json",
            data: $(this).serialize(),

            success: function(res){
                if(res.status === false){
                    if(res.errors.kode_pool) $(".kode_pool_error").text(res.errors.kode_pool);
                    return;
                }

                modalAdd.hide();

                Swal.fire({
                    icon: "success",
                    title: res.message,
                    timer: 1000,
                    showConfirmButton: false
                });

                setTimeout(() => location.reload(), 1000);
            }
        });
    });

    // ============= EDIT POOL =============
    $(document).on("click", ".btnEdit", function(){
        let kode = $(this).data("id");

        $.get("<?= base_url('pool/show'); ?>/" + kode, function(res){
            $("#edit_kode_pool").val(res.kode_pool);
            $("#edit_nama_pool").val(res.nama_pool);
            $("#edit_lokasi_pool").val(res.lokasi_pool);
            $("#edit_kota_pool").val(res.kota_pool);
            $("#edit_prov_pool").val(res.prov_pool);

            modalEdit.show();
        }, 'json');
    });

    // ============= UPDATE POOL =============
    $("#formEdit").submit(function(e){
        e.preventDefault();

        let kode = $("#edit_kode_pool").val();

        $.ajax({
            url: "<?= base_url('pool/update'); ?>/" + kode,
            type: "POST",
            dataType: "json",
            data: $("#formEdit").serialize(),

            success: function(res){
                if(res.status === false){
                    return;
                }

                modalEdit.hide();

                Swal.fire({
                    icon: 'success',
                    title: res.message,
                    timer: 800,
                    showConfirmButton:false
                });

                setTimeout(()=> location.reload(), 800);
            }
        });
    });

    // ============= DELETE POOL =============
    $(document).on("click", ".btnDelete", function(){
        let kode = $(this).data("id");

        Swal.fire({
            title: "Hapus pool?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: "Batal"
        }).then((res)=>{
            if(res.isConfirmed){
                $.get("<?= base_url('pool/delete'); ?>/"+kode, function(r){

                    Swal.fire({ 
                        icon:'success', 
                        title:r.message, 
                        timer:800, 
                        showConfirmButton:false 
                    });

                    setTimeout(()=> location.reload(), 800);

                },'json');
            }
        });

    });

});
</script>

<?= $this->endSection(); ?>
