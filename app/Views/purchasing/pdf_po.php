<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Purchase Order</title>

<style>
body {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
    margin: 0;
    padding: 0;
}

.logo-box {
    width: 100%;
    padding: 10px 20px;
    box-sizing: border-box;
}

.logo {
    width: 60px;
}


.outer-box {
    border: 2px solid #000;
    width: calc(100% - 20px);  
    margin: 10px;
    padding: 0;
    box-sizing: border-box;
}

.header-title {
    text-align: center;
    font-weight: bold;
    font-size: 16px;
    padding: 25px 0 10px 0;
    text-transform: uppercase;
}

.header-line {
    border-top: 2px solid #000;
    margin: 0 0 10px 0;
}

.info-section {
    padding: 10px 20px 20px 20px;
}

.info-table {
    width: 100%;
    border-collapse: collapse;
}

.info-table td {
    border: none;
    padding: 3px 0;
    font-size: 12px;
}

.info-table td:first-child {
    width: 130px;
}


.item-box {
    border-top: 2px solid #000;
    border-bottom: 2px solid #000;
    margin: 0 0 20px 0;
    padding: 10px 15px;
}

.item-box table {
    width: 100%;
    border-collapse: collapse;
}

.item-box thead th {
    border: 1px solid #000;
    padding: 5px;
    text-align: center;
}

.item-box tbody td {
    border: none !important;
    padding: 5px 2px;
}

.text-center { text-align: center; }
.text-right { text-align: right; }


.signature-table {
    width: 100%;
    text-align: center;
}

.signature-table td {
    padding: 5px 0;
    font-size: 12px;
}


.footer {
    width: 100%;
    display: flex;
    justify-content: space-between; 
    padding: 10px 20px; 
    font-size: 12px;
    box-sizing: border-box; 
}
</style>
</head>

<body>

<!-- LOGO -->
<div class="logo-box">
    <img src="LOGO.png" class="logo">
</div>

<div class="outer-box">

    <!-- HEADER -->
    <div class="header-title">
        PT. BHINNEKA SANGKURIANG TRANSPORT<br>PURCHASE ORDER
    </div>

    <div class="header-line"></div>

    <!-- DATA PO -->
    <div class="info-section">
        <table class="info-table">
            <tr><td><strong>No. PO</strong></td><td>: <?= $po['no_po'] ?></td></tr>
            <tr><td><strong>Tanggal</strong></td><td>: <?= date('d-m-Y', strtotime($po['tgl_po'])) ?></td></tr>
            <tr><td><strong>Supplier</strong></td><td>: <?= $po['nama_supplier'] ?></td></tr>
            <tr><td><strong>Pool Tujuan</strong></td><td>: <?= $po['nama_pool'] ?></td></tr>
            <tr><td><strong>Kategori PO</strong></td><td>: <?= $po['nama_departemen'] ?? '-' ?></td></tr>
        </table>
    </div>

    <!-- ITEM -->
    <div class="item-box">
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Kode Barang</th>
                    <th>Nama Barang</th>
                    <th width="7%">QTY</th>
                    <th width="12%">Harga</th>
                    <th width="12%">Jumlah</th>
                    <th width="10%">Notes</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $total = 0; 
                    $total_qty = 0; 
                    foreach($items as $i => $item): 
                        $total += $item['subtotal']; 
                        $total_qty += $item['qty'];
                ?>
                <tr>
                    <td class="text-center"><?= $i+1 ?></td>
                    <td><?= $item['kode_barang'] ?></td>
                    <td><?= $item['nama_barang'] ?></td>
                    <td class="text-center"><?= $item['qty'] ?></td>
                    <td class="text-right"><?= number_format($item['harga_satuan'],0,',','.') ?></td>
                    <td class="text-right"><?= number_format($item['subtotal'],0,',','.') ?></td>
                    <td><?= $item['catatan'] ?></td>
                </tr>
                <?php endforeach; ?>

                <!-- TOTAL -->
                <tr>
                    <td></td>
                    <td></td>

                    <td style="font-weight:bold;">Total</td>

                    <td class="text-center" style="font-weight:bold;"><?= $total_qty ?></td>

                    <td></td>

                    <td class="text-right" style="font-weight:bold;">
                        <?= number_format($total,0,',','.') ?>
                    </td>

                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- SIGNATURE -->
    <table class="signature-table">
        <tr>
            <td><strong>Yang Membuat</strong></td>
            <td><strong>Menyetujui</strong></td>
        </tr>

        <tr><td style="height: 60px"></td><td></td></tr>

        <tr>
            <td>( <?= $po['dibuat_oleh'] ?> )</td>
            <td>( <?= $po['disetujui_oleh'] ?> )</td>
        </tr>
    </table>

</div>

<!-- FOOTER -->
<!-- <div class="footer">
    <div>website.com</div>
    <div>Jl. Random No. 123, Indonesia</div>
</div> -->

</body>
</html>
