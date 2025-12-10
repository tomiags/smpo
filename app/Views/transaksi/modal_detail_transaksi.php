<div class="container-fluid">

    <table class="table table-bordered">
        <tr>
            <th>No PO</th>
            <td><?= $transaksi['no_po'] ?></td>
        </tr>
        <tr>
            <th>Tanggal Transaksi</th>
            <td><?= date('d-m-Y', strtotime($transaksi['tgl_transaksi'])) ?></td>
        </tr>
        <tr>
            <th>Pemohon</th>
            <td><?= $transaksi['nama_user'] ?></td>
        </tr>
        <tr>
            <th>Supplier</th>
            <td><?= $transaksi['nama_supplier'] ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                <?php if ($transaksi['status_bayar'] == 'lunas'): ?>
                    <span class="badge-status badge-lunas">Lunas</span>
                <?php else: ?>
                    <span class="badge-status badge-belum">Belum Lunas</span>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th>Total Tagihan</th>
            <td><span class="badge-status badge-tagihan">Rp <?= number_format($transaksi['total_tagihan'],0,',','.') ?></span></td>
        </tr>
    </table>

    <hr>

    <h5>Daftar Barang PO</h5>
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
            <?php foreach($items as $i): ?>
            <tr>
                <td><?= $i['nama_barang'] ?></td>
                <td><?= $i['qty'] ?></td>
                <td><?= number_format($i['harga_barang'],0,',','.') ?></td>
                <td><?= number_format($i['subtotal'],0,',','.') ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <hr>

    <h5>Riwayat Pembayaran</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tgl Bayar</th>
                <th>Metode</th>
                <th>Nominal</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($pembayaran as $b): ?>
            <tr>
                <td><?= date('d-m-Y', strtotime($b['tgl_bayar'])) ?></td>
                <td><?= $b['metode'] ?></td>
                <td>Rp <?= number_format($b['jumlah_bayar'],0,',','.') ?></td>
                <td><?= $b['catatan'] ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>

</div>

<style>
.badge-status {
    font-weight: bold;
    font-size: 14px;
    padding: 3px 8px;
    border-radius: 4px;
}
.badge-belum  { color:#8a6d00; background:#fff3cd; }
.badge-lunas  { color:#0f6d00; background:#d1e7dd; }
.badge-tagihan   { color: #000; background-color: #e0e0e0; }
</style>