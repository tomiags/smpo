<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <h3 class="mb-3">List Barang</h3>
    
    <button class="btn btn-sm btn-primary mb-3" id="btnAdd">+ Tambah Barang</button>

    <table class="table table-bordered" id="tableBarang">
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga Barang</th>
                <!-- <th>Stok Barang</th> -->
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($barangs as $p): ?>
                <tr>
                    <td><?= $p['kode_barang'] ?></td>
                    <td><?= $p['nama_barang'] ?></td>
                    <td><?= number_format($p['harga_barang'], 0, ',', '.') ?></td>
                    <!-- <td><= $p['stok_barang'] ?></td> -->

                    <td>
                        <button class="btn btn-sm btn-warning btnEdit" data-id="<?= $p['kode_barang'] ?>"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger btnDelete" data-id="<?= $p['kode_barang'] ?>"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<!-- =======================
    MODAL TAMBAH BARANG
======================= -->
<div class="modal fade" id="modalAdd" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <form id="formAdd">

        <div class="modal-header">
            <h5 class="modal-title">Tambah Barang</h5>
        </div>

        <div class="modal-body">

            <div class="mb-2">
                <label>Kode Barang</label>
                <input type="text" name="kode_barang" class="form-control">
                <small class="text-danger kode_barang_error"></small>
            </div>

        
            <div class="mb-2">
                <label>Nama Barang</label>
                <textarea name="nama_barang" class="form-control" rows="3" style="resize: vertical;"></textarea>
            </div>

            <div class="mb-2">
                <label>Harga barang</label>
                <input type="number" name="harga_barang" class="form-control">
            </div>

            <!-- <div class="mb-2">
                <label>Stok barang</label>
                <input type="number" name="stok_barang" class="form-control">
            </div> -->

            <input type="hidden" name="stok_barang" value="0"> 

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
    MODAL EDIT BARANG
======================= -->
<div class="modal fade" id="modalEdit" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <form id="formEdit">

        <div class="modal-header">
            <h5 class="modal-title">Edit Barang</h5>
        </div>

        <div class="modal-body">

            <input type="hidden" name="kode_barang" id="edit_kode_barang">

            <div class="mb-2">
                <label>Nama Barang</label>
                <textarea id="edit_nama_barang" 
                        name="nama_barang" 
                        class="form-control" 
                        rows="3" 
                        style="resize: vertical;"></textarea>
            </div>

            <div class="mb-2">
                <label>Harga barang</label>
                <input type="number" id="edit_harga_barang" name="harga_barang" class="form-control">
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

    $('#tableBarang').DataTable();

    // ============= TAMPILKAN MODAL TAMBAH =============
    $("#btnAdd").click(function () {
        $("#formAdd")[0].reset();
        $(".error").text("");
        modalAdd.show();
    });

    // ============= SIMPAN BARANG =============
    $("#formAdd").submit(function(e){
        e.preventDefault();

        $.ajax({
            url: "<?= base_url('barang/store'); ?>",
            type: "POST",
            dataType: "json",
            data: $(this).serialize(),

            success: function(res){
                if(res.status === false){
                    if(res.errors.kode_barang) $(".kode_barang_error").text(res.errors.kode_barang);
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

    // ============= EDIT BARANG =============
    $(document).on("click", ".btnEdit", function(){
        let kode = $(this).data("id");

        $.get("<?= base_url('barang/show'); ?>/" + kode, function(res){
            $("#edit_kode_barang").val(res.kode_barang);
            $("#edit_nama_barang").val(res.nama_barang);
            $("#edit_harga_barang").val(res.harga_barang);

            modalEdit.show();
        }, 'json');
    });

    // ============= UPDATE BARANG =============
    $("#formEdit").submit(function(e){
        e.preventDefault();

        let kode = $("#edit_kode_barang").val();

        $.ajax({
            url: "<?= base_url('barang/update'); ?>/" + kode,
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

    // ============= DELETE BARANG =============
    $(document).on("click", ".btnDelete", function(){
        let kode = $(this).data("id");

        Swal.fire({
            title: "Hapus barang?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: "Batal"
        }).then((res)=>{
            if(res.isConfirmed){
                $.get("<?= base_url('barang/delete'); ?>/"+kode, function(r){

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
