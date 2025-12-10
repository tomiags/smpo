<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container mt-4">

    <h3 class="mb-4">Edit Purchase Order</h3>

    <form action="<?= base_url('/purchasing/update_po/'.$po['id_po']) ?>" method="post">

        <div class="row mb-3">
            <div class="col-md-12 d-flex justify-content-between align-items-end">

                <!-- KIRI: Tanggal -->
                <div style="width: 300px;">
                    <label>Tanggal PO</label>
                    <input type="date" name="tgl_po" class="form-control" 
                        value="<?= $po['tgl_po']; ?>" readonly>
                </div>

                <!-- KANAN: Tombol -->
                <div class="text-end">
                    <a href="<?= base_url('/purchasing/po_list') ?>" 
                    class="btn btn-secondary mt-4">
                        <i class="bi bi-arrow-left"></i> KEMBALI
                    </a>

                    <button type="submit" class="btn btn-warning mt-4">
                        <i class="bi bi-save"></i> UPDATE
                    </button>
                </div>

            </div>
        </div>

        <div class="row">

            <!-- Supplier -->
            <div class="col-md-4 mb-3">
                <label>Supplier</label>
                <select name="id_supplier" class="form-control" required>
                    <option value="">-- Pilih Supplier --</option>
                    <?php foreach($suppliers as $s): ?>
                        <option value="<?= $s['id_supplier'] ?>" 
                            <?= $s['id_supplier'] == $po['id_supplier'] ? 'selected' : '' ?>>
                            <?= $s['nama_supplier'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Departemen -->
            <div class="col-md-4 mb-3">
                <label>Departemen</label>
                <select name="id_departemen" class="form-control" required>
                    <option value="">-- Pilih Departemen --</option>
                    <?php foreach($departemen as $d): ?>
                        <option value="<?= $d['id_departemen'] ?>"
                            <?= $d['id_departemen'] == $po['id_departemen'] ? 'selected' : '' ?>>
                            <?= $d['nama_departemen'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Pool -->
            <div class="col-md-4 mb-3">
                <label>Pool Tujuan</label>
                <select name="kode_pool" class="form-control" required>
                    <option value="">-- Pilih Pool --</option>
                    <?php foreach($pool as $p): ?>
                        <option value="<?= $p['kode_pool'] ?>"
                            <?= $p['kode_pool'] == $po['kode_pool'] ? 'selected' : '' ?>>
                            <?= $p['nama_pool'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>

        <hr>

        <h5 class="mb-3">Daftar Barang</h5>

        <button type="button" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#modalBarang">
            + Tambah Barang
        </button>

        <table class="table table-bordered" id="barangTable">
            <thead>
                <tr class="text-center">
                    <th style="width:12%">Kode</th>
                    <th style="width:28%">Nama Barang</th>
                    <th style="width:12%">Harga</th>
                    <th style="width:10%">Qty</th>
                    <th style="width:28%">Notes</th>
                    <th style="width:10%">Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($detail as $d): ?>
                <tr>
                    <td><input type="text" name="kode_barang[]" value="<?= $d['kode_barang'] ?>" class="form-control" readonly></td>

                    <td><input type="text" value="<?= $d['nama_barang'] ?>" class="form-control" readonly></td>

                    <td><input type="number" name="harga[]" value="<?= $d['harga_barang'] ?>" class="form-control" readonly></td>

                    <td><input type="number" name="qty[]" min="1" value="<?= $d['qty'] ?>" class="form-control" required></td>

                    <td><input type="text" name="catatan_barang[]" value="<?= $d['catatan'] ?>" class="form-control"></td>

                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm removeRow">X</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </form>

</div>

<!-- MODAL CARI BARANG -->
<div class="modal fade" id="modalBarang" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">x</button>
            </div>

            <div class="modal-body">

                <input type="text" id="searchBarang" class="form-control mb-3" placeholder="Cari barang...">

                <table class="table table-bordered table-striped" id="tableCariBarang">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Pilih</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($barang as $b): ?>
                        <tr>
                            <td><?= $b['kode_barang'] ?></td>
                            <td><?= $b['nama_barang'] ?></td>
                            <td><?= number_format($b['harga_barang'],0,',','.') ?></td>
                            <td>
                                <button type="button" 
                                    class="btn btn-sm btn-primary pilihBarangBtn"
                                    data-kode="<?= $b['kode_barang'] ?>"
                                    data-nama="<?= $b['nama_barang'] ?>"
                                    data-harga="<?= $b['harga_barang'] ?>">
                                    Pilih
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener("click", function(e){
    if(e.target.classList.contains("pilihBarangBtn")){

        let kode  = e.target.dataset.kode;
        let nama  = e.target.dataset.nama;
        let harga = e.target.dataset.harga;

        let tbody = document.querySelector("#barangTable tbody");

        let row = `
        <tr>
            <td><input type="text" name="kode_barang[]" value="${kode}" class="form-control" readonly></td>
            <td><input type="text" value="${nama}" class="form-control" readonly></td>
            <td><input type="number" name="harga[]" value="${harga}" class="form-control" readonly></td>
            <td><input type="number" name="qty[]" min="1" class="form-control" required></td>
            <td><input type="text" name="catatan_barang[]" class="form-control"></td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm removeRow">X</button>
            </td>
        </tr>
        `;

        tbody.insertAdjacentHTML("beforeend", row);
        bootstrap.Modal.getInstance(document.getElementById('modalBarang')).hide();
    }
});


// Hapus baris
document.addEventListener("click", function(e){
    if(e.target.classList.contains("removeRow")){
        e.target.closest("tr").remove();
    }
});

// Search barang
document.getElementById("searchBarang").addEventListener("keyup", function(){
    let keyword = this.value.toLowerCase();
    let rows = document.querySelectorAll("#tableCariBarang tbody tr");

    rows.forEach(r => {
        let text = r.innerText.toLowerCase();
        r.style.display = text.includes(keyword) ? "" : "none";
    });
});
</script>

<?= $this->endSection(); ?>
