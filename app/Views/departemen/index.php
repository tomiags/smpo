<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <h3 class="mb-3">Manajemen Departemen</h3>
    
    <button class="btn btn-sm btn-primary mb-3" id="btnAdd">+ Tambah Departemen</button>

    <table class="table table-bordered" id="tableDepartemen">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Departemen</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($departemens as $s): ?>
                <tr>
                    <td><?= $s['id_departemen'] ?></td>
                    <td><?= $s['nama_departemen'] ?></td>

                    <td>
                        <button class="btn btn-sm btn-warning btnEdit" data-id="<?= $s['id_departemen'] ?>"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger btnDelete" data-id="<?= $s['id_departemen'] ?>"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<!-- ========================
      MODAL TAMBAH DEPARTEMEN
======================== -->
<div class="modal fade" id="modalAdd" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <form id="formAdd">

        <div class="modal-header">
            <h5 class="modal-title">Tambah Departemen</h5>
        </div>

        <div class="modal-body">

            <div class="mb-2">
                <label>Nama Departemen</label>
                <input type="text" name="nama_departemen" class="form-control">
                <small class="text-danger error nama_error"></small>
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
      MODAL EDIT DEPARTEMEN
======================== -->
<div class="modal fade" id="modalEdit" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <form id="formEdit">

        <div class="modal-header">
            <h5 class="modal-title">Edit Departemen</h5>
        </div>

        <div class="modal-body">

            <input type="hidden" id="edit_id_departemen" name="id_departemen">

            <div class="mb-2">
                <label>Nama Departemen</label>
                <input type="text" id="edit_nama_departemen" name="nama_departemen" class="form-control">
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

    $('#tableDepartemen').DataTable();

    // Show Add Modal
    $("#btnAdd").click(function () {
        $("#formAdd")[0].reset();
        $(".error").text("");
        modalAdd.show();
    });

    // Store Departemen
    $("#formAdd").submit(function(e){
        e.preventDefault();

        $.ajax({
            url: "<?= base_url('departemen/store'); ?>",
            type: "POST",
            dataType: "json",
            data: $(this).serialize(),

            success: function(res){
                if(!res.status){
                    if(res.errors.nama_departemen) $(".nama_error").text(res.errors.nama_departemen);
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

    // Edit Departemen
    $(document).on("click", ".btnEdit", function(){
        let id = $(this).data("id");

        $.get("<?= base_url('departemen/show'); ?>/" + id, function(res){
            $("#edit_id_departemen").val(res.id_departemen);
            $("#edit_nama_departemen").val(res.nama_departemen);

            modalEdit.show();
        }, 'json');
    });

    // Update Departemen
    $("#formEdit").submit(function(e){
        e.preventDefault();

        let id = $("#edit_id_departemen").val();

        $.ajax({
            url: "<?= base_url('departemen/update'); ?>/" + id,
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

    // Delete Departemen
    $(document).on("click", ".btnDelete", function(){
        let id = $(this).data("id");

        Swal.fire({
            title: "Hapus departemen?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: "Batal"
        }).then((r)=>{
            if(r.isConfirmed){
                $.get("<?= base_url('departemen/delete'); ?>/" + id, function(res){

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
