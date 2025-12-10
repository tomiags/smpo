<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <h3 class="mb-3">Manajemen User</h3>
    
    <button class="btn btn-sm btn-primary mb-3" id="btnAdd">+ Tambah User</button>

    <table class="table table-bordered" id="tableUser">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Username</th>
                <th>Jabatan</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($users as $u): ?>
                <tr>
                    <td><?= $u->id ?></td>
                    <td><?= $u->nama_user ?? '-' ?></td>
                    <td><?= $u->email ?></td>
                    <td><?= $u->username ?></td>
                    <td><?= $u->group_name ?? '-' ?></td>

                    <td>
                        <button class="btn btn-sm btn-warning btnEdit" data-id="<?= $u->id ?>"><i class="fas fa-edit"></i></button>
                        <!-- <button class="btn btn-sm btn-danger btnDelete" data-id="<= $u->id ?>">Hapus</button> -->
                         
                        <?php if($u->active): ?>
                            <button class="btn btn-sm btn-secondary btnToggle" data-id="<?= $u->id ?>" data-active="1">Nonaktifkan</button>
                        <?php else: ?>
                            <button class="btn btn-sm btn-success btnToggle" data-id="<?= $u->id ?>" data-active="0">Aktifkan</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<!-- =======================
     MODAL TAMBAH USER
======================= -->
<div class="modal fade" id="modalAdd" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form id="formAdd">

        <div class="modal-header">
            <h5 class="modal-title">Tambah User</h5>
        </div>

        <div class="modal-body">

            <div class="row">

                <!-- LEFT SIDE -->
                <div class="col-md-6">

                    <div class="mb-2">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_user" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control">
                        <small class="text-danger error email_error"></small>
                    </div>

                    <div class="mb-2">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control">
                        <small class="text-danger error username_error"></small>
                    </div>

                    <div class="mb-2">
                        <label>Password</label>

                        <div class="input-group">
                            <input type="password" name="password" class="form-control" id="add_password">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="bi bi-eye-slash" id="iconPassword"></i>
                            </button>
                        </div>

                        <small class="text-danger error password_error"></small>
                    </div>

                    <div class="mb-2">
                        <label>Jabatan</label>
                        <select name="jabatan" class="form-control">
                            <option value="">-- pilih jabatan --</option>

                            <?php foreach($groups as $g): ?>
                                <option value="<?= $g->id; ?>"><?= $g->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>

                <!-- RIGHT SIDE -->
                <div class="col-md-6">

                    <div class="mb-2">
                        <label>Jenis Kelamin</label>
                        <select name="jenkel" class="form-control">
                            <option value="">-- pilih --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>

                     <div class="mb-2">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>No Telepon</label>
                        <input type="text" name="no_tlp" class="form-control">
                    </div>

                </div>

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
     MODAL EDIT USER
======================= -->
<div class="modal fade" id="modalEdit" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form id="formEdit">

        <div class="modal-header">
            <h5 class="modal-title">Edit User</h5>
        </div>

        <div class="modal-body">

            <input type="hidden" name="id" id="edit_id">

            <div class="row">

                <!-- LEFT SIDE -->
                <div class="col-md-6">

                    <div class="mb-2">
                        <label>Nama Lengkap</label>
                        <input type="text" id="edit_nama_user" name="nama_user" class="form-control">
                        <small class="text-danger error nama_user_error"></small>
                    </div>

                    <div class="mb-2">
                        <label>Email</label>
                        <input type="text" id="edit_email" name="email" class="form-control">
                        <small class="text-danger error email_error"></small>
                    </div>

                    <div class="mb-2">
                        <label>Username</label>
                        <input type="text" id="edit_username" name="username" class="form-control">
                        <small class="text-danger error username_error"></small>
                    </div>

                    <div class="mb-2">
                        <label>Password (opsional)</label>
                        <div class="input-group">
                            <input type="password" id="edit_password" name="password" class="form-control">
                            <button class="btn btn-outline-secondary" type="button" id="toggleEditPassword">
                                <i class="bi bi-eye-slash" id="iconEditPassword"></i>
                            </button>
                        </div>
                        <small class="text-danger error password_error"></small>
                    </div>

                    <!-- <div class="mb-2">
                        <label>Jabatan</label>
                        <select id="edit_jabatan" name="jabatan" class="form-control">
                            <option value="">-- pilih jabatan --</option>
                            <php foreach($groups as $g): ?>
                                <option value="<= $g->id; ?>"><= $g->name; ?></option>
                            <php endforeach; ?>
                        </select>
                        <small class="text-danger error jabatan_error"></small>
                    </div> -->

                </div>

                <!-- RIGHT SIDE -->
                <div class="col-md-6">

                    <div class="mb-2">
                        <label>Jenis Kelamin</label>
                        <select id="edit_jenkel" name="jenkel" class="form-control">
                            <option value="">-- pilih --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                        <small class="text-danger error jenkel_error"></small>
                    </div>

                    <div class="mb-2">
                        <label>Tempat Lahir</label>
                        <input type="text" id="edit_tempat_lahir" name="tempat_lahir" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Tanggal Lahir</label>
                        <input type="date" id="edit_tgl_lahir" name="tgl_lahir" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>No Telepon</label>
                        <input type="text" id="edit_no_tlp" name="no_tlp" class="form-control">
                    </div>

                </div>

            </div>

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-success">Update</button>
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

    let table = $('#tableUser').DataTable();

    // ============= TAMPILKAN MODAL TAMBAH =============
    $("#btnAdd").click(function () {
        $("#formAdd")[0].reset();
        $(".error").text("");
        modalAdd.show();
    });

    // ============= SIMPAN USER =============
    $("#formAdd").submit(function(e){
        e.preventDefault();
        $(".error").text("");

        $.ajax({
            url: "<?= base_url('users/store'); ?>",
            type: "POST",
            dataType: "json",
            data: $(this).serialize(),
            success: function(res){
                if(res.status === false){
                    $.each(res.errors, function(key, val){
                        $("#formAdd ." + key + "_error").text(val);
                    });
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

    // ============= EDIT USER =============
    $(document).on("click", ".btnEdit", function(){
        let id = $(this).data("id");

        $.get("<?= base_url('users/show'); ?>/" + id, function(res){
            $("#edit_id").val(res.id);
            $("#edit_nama_user").val(res.nama_user);
            $("#edit_email").val(res.email);
            $("#edit_username").val(res.username);
            // $("#edit_jabatan").val(res.jabatan_id); 
            $("#edit_jenkel").val(res.jenkel);
            $("#edit_tempat_lahir").val(res.tempat_lahir);
            $("#edit_tgl_lahir").val(res.tgl_lahir);
            $("#edit_no_tlp").val(res.no_tlp);
            $("#edit_password").val("");

            $(".error").text("");
            modalEdit.show();
        }, 'json');
    });

    // ============= UPDATE USER =============
    $("#formEdit").submit(function(e){
        e.preventDefault();
        $(".error").text("");

        let id = $("#edit_id").val();

        $.ajax({
            url: "<?= base_url('users/update'); ?>/" + id,
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(res){
                if(res.status === false){
                    // tampilkan error per field
                    $.each(res.errors, function(key, val){
                        $("#formEdit ." + key + "_error").text(val);
                    });
                    return;
                }

                modalEdit.hide();

                Swal.fire({
                    icon: 'success',
                    title: res.message,
                    timer: 800,
                    showConfirmButton: false
                });

                setTimeout(()=> location.reload(), 800);
            },
            error: function(xhr, status, error){
                console.log(xhr.responseText);
            }
        });
    });

    // ============= DELETE USER =============
    $(document).on("click", ".btnDelete", function(){
        let id = $(this).data("id");

        Swal.fire({
            title: "Hapus user?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: "Batal"
        }).then((res)=>{
            if(res.isConfirmed){
                $.get("<?= base_url('users/delete'); ?>/"+id, function(r){
                    Swal.fire({ icon:'success', title:r.message, timer:800, showConfirmButton:false });
                    setTimeout(()=> location.reload(), 800);
                },'json');
            }
        });
    });

    // ============= TOGGLE PASSWORD TAMBAH =============
    $(document).on("click", "#togglePassword", function () {
        let input = $("#add_password");
        let icon  = $("#iconPassword");

        if (input.attr("type") === "password") {
            input.attr("type", "text");
            icon.removeClass("bi-eye-slash").addClass("bi-eye");
        } else {
            input.attr("type", "password");
            icon.removeClass("bi-eye").addClass("bi-eye-slash");
        }
    });

    // ============= TOGGLE PASSWORD EDIT =============
    $(document).on("click", "#toggleEditPassword", function () {
        let input = $("#edit_password");
        let icon  = $("#iconEditPassword");

        if (input.attr("type") === "password") {
            input.attr("type", "text");
            icon.removeClass("bi-eye-slash").addClass("bi-eye");
        } else {
            input.attr("type", "password");
            icon.removeClass("bi-eye").addClass("bi-eye-slash");
        }
    });

});
</script>

<script>
// Aktif / Nonaktif user
$(document).on("click", ".btnToggle", function() {
    let id = $(this).data("id");

    $.post("<?= base_url('users/toggle'); ?>/" + id, function(res) {
        if(res.status){
            Swal.fire({
                icon: 'success',
                title: res.message,
                timer: 800,
                showConfirmButton: false
            });
            setTimeout(()=> location.reload(), 800);
        } else {
            Swal.fire('Error', res.message, 'error');
        }
    }, 'json');
});
</script>

<?= $this->endSection(); ?>
