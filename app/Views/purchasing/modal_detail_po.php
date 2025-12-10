<div class="container">

    <div class="row align-items-end">
        <div class="col-md-4 text-end mb-3">
            <label>No. PO</label>
            <input type="text" class="form-control" value="<?= $po['no_po']; ?>" readonly>
        </div>

        <div class="col-md-4"></div>

        <div class="col-md-4 mb-3">
            <label>Tanggal PO</label>
            <input type="date" class="form-control" value="<?= $po['tgl_po']; ?>" readonly>
        </div>
    </div>

    <div class="row">

        <div class="col-md-4 mb-3">
            <label>Supplier</label>
            <input type="text" class="form-control" value="<?= $po['nama_supplier']; ?>" readonly>
        </div>

        <div class="col-md-4 mb-3">
            <label>Departemen</label>
            <input type="text" class="form-control" value="<?= $po['nama_departemen']; ?>" readonly>
        </div>

        <div class="col-md-4 mb-3">
            <label>Pool</label>
            <input type="text" class="form-control" value="<?= $po['nama_pool']; ?>" readonly>
        </div>

    </div>

    <hr>

    <h5>Daftar Barang</h5>

    <table class="table table-bordered mt-2">
        <thead>
            <tr class="text-center">
                <th style="width:15%;">Kode</th>
                <th style="width:30%;">Nama Barang</th>
                <th style="width:15%;">Harga</th>
                <th style="width:10%;">Qty</th>
                <th style="width:15%;">Subtotal</th>
                <th style="width:20%;">Notes</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($items as $it): ?>
            <tr>
                <td><div class="form-control-plaintext" style="white-space: normal;"><?= $it['kode_barang'] ?></div></td>
                <td>
                    <div class="form-control-plaintext" style="white-space: normal;"><?= $it['nama_barang'] ?></div>
                </td>
                <td><input type="text" class="form-control" value="<?= number_format($it['harga_satuan'],0,',','.') ?>" readonly></td>
                <td><input type="text" class="form-control" value="<?= $it['qty'] ?>" readonly></td>
                <td><input type="text" class="form-control" value="<?= number_format($it['subtotal'],0,',','.') ?>" readonly></td>
                <td>
                    <div class="form-control-plaintext" style="white-space: normal;"><?= $it['catatan'] ?></div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
