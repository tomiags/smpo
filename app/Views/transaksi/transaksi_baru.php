<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <h3>Transaksi Baru</h3>
    <button class="btn btn-primary mb-3" id="btnCariPO">+ Pilih PO</button>

    <form action="<?= base_url('transaksi/store'); ?>" method="post">

        <input type="hidden" name="id_po" id="id_po">

        <div id="poDetail" class="mb-4"></div>

        <!-- <button type="submit" class="btn btn-success" style="display:none;" id="btnSimpan">
            Simpan Transaksi
        </button> -->

    </form>
</div>

<!-- Modal search PO -->
<div class="modal fade" id="modalSearchPO"></div>


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


<script>
$("#btnCariPO").click(function(){
    $("#modalSearchPO").load("<?= base_url('transaksi/search-po'); ?>", function(){
        $("#modalSearchPO").modal("show");
    });
});

// Pilih PO
function pilihPO(id){
    $.get("<?= base_url('transaksi/get-po'); ?>/" + id, function(res){

        $("#id_po").val(res.po.id_po);

        let html = `
            <div class="p-3">

                <div class="row mb-3">

                    <div class="col-md-6">

                        <div class="label-row">
                            <div class="label">No. PO</div>
                            <div class="colon">:</div>
                            <div>${res.po.no_po}</div>
                        </div>

                        <div class="label-row">
                            <div class="label">Tanggal PO</div>
                            <div class="colon">:</div>
                            <div>${new Date(res.po.tgl_po).toLocaleDateString('id-ID')}</div>
                        </div>

                        <div class="label-row">
                            <div class="label">Disetujui Oleh</div>
                            <div class="colon">:</div>
                            <div>${res.approval ? res.approval.disetujui_oleh : '-'}</div>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="label-row">
                            <div class="label">Pemohon</div>
                            <div class="colon">:</div>
                            <div>${res.po.nama_user}</div>
                        </div>

                        <div class="label-row">
                            <div class="label">Departemen</div>
                            <div class="colon">:</div>
                            <div>${res.po.nama_departemen}</div>
                        </div>

                        <div class="label-row">
                            <div class="label">Supplier</div>
                            <div class="colon">:</div>
                            <div>${res.po.nama_supplier}</div>
                        </div>

                    </div>

                </div>

                <hr>

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
        `;

        let total = 0;

        res.items.forEach(i => {
            total += parseFloat(i.subtotal);

            html += `
                <tr>
                    <td>${i.nama_barang}</td>
                    <td>${i.qty}</td>
                    <td>${parseFloat(i.harga_satuan).toLocaleString()}</td>
                    <td>${parseFloat(i.subtotal).toLocaleString()}</td>
                </tr>
            `;
        });

        html += `
        </tbody>
        </table>

        <hr>

        <h4 class="mt-3 text-end"><b>Total: Rp. ${total.toLocaleString()}</b></h4>
        <input type="hidden" name="total_tagihan" value="${total}">

        <hr>

        <h4 class="mb-3">Form Pembayaran</h4>

        <div class="row">

            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Metode Pembayaran</label>
                <select name="metode" class="form-control" required>
                    <option value="">-- Pilih --</option>
                    <option value="cash">Cash</option>
                    <option value="transfer">Transfer</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Jumlah Bayar</label>
                <input type="number" name="jumlah_bayar" class="form-control" min="1" max="${total}" required>
            </div>

        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Catatan</label>
            <textarea name="catatan" class="form-control" rows="3"></textarea>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-success mt-3">Simpan Transaksi</button>
        </div>

        `;


        $("#poDetail").html(html);
        $("#btnSimpan").show();
        $("#modalSearchPO").modal("hide");
        // Validasi jumlah bayar
        setTimeout(() => {
            const totalTagihan = parseFloat($("input[name='total_tagihan']").val());

            $("input[name='jumlah_bayar']").on("input", function () {
                let val = parseFloat($(this).val());

                if (val > totalTagihan) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Jumlah melebihi total tagihan!',
                        text: 'Silakan masukkan jumlah yang sesuai.',
                    });
                    $(this).val(totalTagihan);
                }
            });
        }, 300);

    });
}

</script>

<?= $this->endSection(); ?>
