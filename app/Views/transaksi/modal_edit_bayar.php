<div class="container-fluid">
    <form method="post" action="<?= base_url('transaksi/update-bayar/'.$bayar['id_bayar']); ?>">

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
                <td>
                    <select name="metode" class="form-control">
                        <option value="cash" <?= $bayar['metode'] == 'cash' ? 'selected' : ''; ?>>Cash</option>
                        <option value="transfer" <?= $bayar['metode'] == 'transfer' ? 'selected' : ''; ?>>Transfer</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Catatan</th>
                <td>
                    <textarea name="catatan" class="form-control"><?= $bayar['catatan']; ?></textarea>
                </td>
            </tr>
            <tr>
                <th>Dibuat Oleh</th>
                <td><?= $bayar['nama_user']; ?></td>
            </tr>
        </table>

        <div class="text-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success">Update</button>
        </div>

    </form>
</div>
