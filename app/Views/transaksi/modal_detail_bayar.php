<div class="container-fluid">
     <table class="table table-bordered">
        <tr>
            <th>No. PO</th>
            <td><?= $bayar['no_po']; ?></td>
        </tr>
        <tr>
            <th>Tanggal Bayar</th>
            <td><?= date('d-m-Y', strtotime($bayar['tgl_bayar'])); ?></td>
        </tr>
        <tr>
            <th>Jumlah Bayar</th>
            <td>Rp <?= number_format($bayar['jumlah_bayar'], 0, ',', '.'); ?></td>
        </tr>
        <tr>
            <th>Metode Pembayaran</th>
            <td><?= ucfirst($bayar['metode']); ?></td>
        </tr>
        <tr>
            <th>Catatan</th>
            <td><?= $bayar['catatan'] ?: '-'; ?></td>
        </tr>
        <tr>
            <th>Dibuat Oleh</th>
            <td><?= $bayar['nama_user']; ?></td>
        </tr>
    </table>
</div>
