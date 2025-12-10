<div class="p-2">

    <div class="mb-2">
        <b>No. PO:</b> <?= $no_po ?><br>
        <b>Supplier:</b> <?= $nama_supplier ?>
    </div>

    <hr>

    <b>Total Tagihan:</b> Rp <?= number_format($total_tagihan,0,',','.') ?><br>
    <b>Total Dibayar:</b> Rp <?= number_format($total_bayar,0,',','.') ?><br>
    <b style="font-size:18px;">Sisa Kekurangan:</b>
    <span class="text-danger fw-bold" style="font-size:20px;">
        Rp <?= number_format($kekurangan,0,',','.') ?>
    </span>

    <hr>

    <form action="<?= base_url('transaksi/simpan-bayar') ?>" method="post">

        <input type="hidden" name="id_transaksi" value="<?= $id_transaksi ?>">
        <input type="hidden" name="kekurangan" id="kekurangan" value="<?= $kekurangan ?>">

        <div class="mb-3">
            <label class="fw-bold">Metode</label>
            <select name="metode" class="form-control" required>
                <option value="">--Pilih--</option>
                <option value="cash">Cash</option>
                <option value="transfer">Transfer</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="fw-bold">Jumlah Bayar</label>
            <input type="number" name="jumlah_bayar" id="jumlahBayar"
                   class="form-control" min="1" max="<?= $kekurangan ?>" required>
        </div>

        <div class="mb-3">
            <label class="fw-bold">Catatan</label>
            <textarea name="catatan" class="form-control"></textarea>
        </div>

        <button class="btn btn-success w-100">Simpan Pembayaran</button>

    </form>
</div>

<script>
$("#jumlahBayar").on("input", function(){
    let max = parseFloat($("#kekurangan").val());
    let val = parseFloat($(this).val());

    if(val > max){
        Swal.fire({
            icon: 'warning',
            title: 'Jumlah melebihi kekurangan!',
            text: 'Jumlah yang boleh dibayar maksimal Rp ' + max.toLocaleString('id-ID')
        });
        $(this).val(max);
    }
});
</script>
