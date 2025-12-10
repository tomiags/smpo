<style>
    .label-row {
        display: flex;
        margin-bottom: 4px;
    }
    .label-row .label {
        width: 130px;        
        font-weight: bold;
    }
    .label-row .colon {
        width: 15px;        
        text-align: center;
    }
</style>

<div class="p-3">

    <!-- HEADER -->
    <div class="row mb-3">

        <div class="col-md-6">

            <div class="label-row">
                <div class="label">No. PO</div>
                <div class="colon">:</div>
                <div><?= $po['no_po'] ?></div>
            </div>

            <div class="label-row">
                <div class="label">Tanggal PO</div>
                <div class="colon">:</div>
                <div><?= date('d-m-Y', strtotime($po['tgl_po'])) ?></div>
            </div>

        </div>

        <div class="col-md-6">

            <div class="label-row">
                <div class="label">Pemohon</div>
                <div class="colon">:</div>
                <div><?= $po['nama_user'] ?></div>
            </div>

            <div class="label-row">
                <div class="label">Departemen</div>
                <div class="colon">:</div>
                <div><?= $po['nama_departemen'] ?></div>
            </div>

            <div class="label-row">
                <div class="label">Supplier</div>
                <div class="colon">:</div>
                <div><?= $po['nama_supplier'] ?></div>
            </div>

        </div>

    </div>

    <hr>

    <!-- TABLE ITEMS -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Barang</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>

        <tbody>
            <?php 
            $total = 0;
            foreach($items as $i): 
                $total += $i['subtotal'];
            ?>
            <tr>
                <td><?= $i['nama_barang'] ?></td>
                <td><?= $i['qty'] ?></td>
                <td><?= number_format($i['harga_satuan']) ?></td>
                <td><?= number_format($i['subtotal']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <hr>

    <!-- TOTAL -->
    <h4 class="mt-3 text-end"><b>Total: Rp.<?= number_format($total) ?></b></h4>

</div>
