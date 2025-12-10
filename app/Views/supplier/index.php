<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <h3 class="mb-3">Manajemen Supplier</h3>
    
    <button class="btn btn-sm btn-primary mb-3" id="btnAdd">+ Tambah Supplier</button>

    <table class="table table-bordered" id="tableSupplier">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Supplier</th>
                <th>No. Telp</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($suppliers as $s): ?>
                <tr>
                    <td><?= $s['id_supplier'] ?></td>
                    <td><?= $s['nama_supplier'] ?></td>
                    <td><?= $s['no_tlp'] ?></td>
                    <td><?= $s['email'] ?></td>
                    <td><?= $s['alamat_supplier'] ?></td>

                    <td>
                        <button class="btn btn-sm btn-warning btnEdit" data-id="<?= $s['id_supplier'] ?>"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger btnDelete" data-id="<?= $s['id_supplier'] ?>"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<!-- ========================
      MODAL TAMBAH SUPPLIER
======================== -->
<div class="modal fade" id="modalAdd" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <form id="formAdd">

        <div class="modal-header">
            <h5 class="modal-title">Tambah Supplier</h5>
        </div>

        <div class="modal-body">

            <div class="mb-2">
                <label>Nama Supplier</label>
                <input type="text" name="nama_supplier" class="form-control">
                <small class="text-danger error nama_error"></small>
            </div>

            <div class="mb-2">
                <label>No. Telp</label>
                <input type="text" name="no_tlp" class="form-control">
            </div>

            <div class="mb-2">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
            </div>

            <div class="mb-2">
                <label>Alamat</label>
                <textarea name="alamat_supplier" class="form-control"></textarea>
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


<!-- ========================
      MODAL EDIT SUPPLIER
======================== -->
<div class="modal fade" id="modalEdit" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <form id="formEdit">

        <div class="modal-header">
            <h5 class="modal-title">Edit Supplier</h5>
        </div>

        <div class="modal-body">

            <input type="hidden" id="edit_id_supplier" name="id_supplier">

            <div class="mb-2">
                <label>Nama Supplier</label>
                <input type="text" id="edit_nama_supplier" name="nama_supplier" class="form-control">
            </div>

            <div class="mb-2">
                <label>No. Telp</label>
                <input type="text" id="edit_no_tlp" name="no_tlp" class="form-control">
            </div>

            <div class="mb-2">
                <label>Email</label>
                <input type="email" id="edit_email" name="email" class="form-control">
            </div>

            <div class="mb-2">
                <label>Alamat</label>
                <textarea id="edit_alamat_supplier" name="alamat_supplier" class="form-control"></textarea>
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

    $('#tableSupplier').DataTable();

    // Show Add Modal
    $("#btnAdd").click(function () {
        $("#formAdd")[0].reset();
        $(".error").text("");
        modalAdd.show();
    });

    // Store Supplier
    $("#formAdd").submit(function(e){
        e.preventDefault();

        $.ajax({
            url: "<?= base_url('supplier/store'); ?>",
            type: "POST",
            dataType: "json",
            data: $(this).serialize(),

            success: function(res){
                if(!res.status){
                    if(res.errors.nama_supplier) $(".nama_error").text(res.errors.nama_supplier);
                    return;
                }

                modalAdd.hide();

                Swal.fire({
                    icon: "success",
                    title: res.message,
                    timer: 1000,
                    showConfirmButton: false
                });

                setTimeout(()=> location.reload(), 1000);
            }
        });
    });

    // Edit Supplier
    $(document).on("click", ".btnEdit", function(){
        let id = $(this).data("id");

        $.get("<?= base_url('supplier/show'); ?>/" + id, function(res){
            $("#edit_id_supplier").val(res.id_supplier);
            $("#edit_nama_supplier").val(res.nama_supplier);
            $("#edit_no_tlp").val(res.no_tlp);
            $("#edit_email").val(res.email);
            $("#edit_alamat_supplier").val(res.alamat_supplier);

            modalEdit.show();
        }, 'json');
    });

    // Update Supplier
    $("#formEdit").submit(function(e){
        e.preventDefault();

        let id = $("#edit_id_supplier").val();

        $.ajax({
            url: "<?= base_url('supplier/update'); ?>/" + id,
            type: "POST",
            dataType: "json",
            data: $("#formEdit").serialize(),

            success: function(res){
                if(!res.status){
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

    // Delete Supplier
    $(document).on("click", ".btnDelete", function(){
        let id = $(this).data("id");

        Swal.fire({
            title: "Hapus supplier?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: "Batal"
        }).then((r)=>{
            if(r.isConfirmed){
                $.get("<?= base_url('supplier/delete'); ?>/" + id, function(res){

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

});
</script>

<?= $this->endSection(); ?>
