<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<style>
.card-red {
    background: #ffdddd;
    border-left: 5px solid #dc3545 !important;
}

.card-green {
    background: #ddffdd;
    border-left: 5px solid #28a745 !important;
}

.card-blue {
    background: #dde7ff;
    border-left: 5px solid #007bff !important;
}

.card-yellow {
    background: #fff4d4;
    border-left: 5px solid #ffc107 !important;
}

.card h6, .card small, .card h3 {
    margin: 0;
}
</style>

<div class="container-fluid">

    <div class="row">

        <!-- PO Reject -->
        <div class="col-md-3 mb-3">
            <div class="card shadow p-3 card-red">
                <h6 class="text-danger mb-1">PO Reject</h6>
                <h3><b><?= $poReject30 ?></b></h3>
                <small>Total PO yang ditolak dalam 30 hari terakhir</small>
            </div>
        </div>

        <!-- PO Approve -->
        <div class="col-md-3 mb-3">
            <div class="card shadow p-3 card-green">
                <h6 class="text-success mb-1">PO Approve</h6>
                <h3><b><?= $poApprove30 ?></b></h3>
                <small>Total PO yang disetujui dalam 30 hari terakhir</small>
            </div>
        </div>

        <!-- Total PO -->
        <div class="col-md-3 mb-3">
            <div class="card shadow p-3 card-blue">
                <h6 class="text-primary mb-1">Total PO</h6>
                <h3><b><?= $po30 ?></b></h3>
                <small>Total PO yang dibuat dalam 30 hari terakhir</small>
            </div>
        </div>

        <!-- Transaksi -->
        <div class="col-md-3 mb-3">
            <div class="card shadow p-3 card-yellow">
                <h6 class="text-warning mb-1">Transaksi</h6>
                <h3><b><?= $trx30 ?></b></h3>
                <small>Total transaksi yang dibuat dalam 30 hari terakhir</small>
            </div>
        </div>

    </div>

    <div class="row mt-4">

        <div class="col-md-6 mb-3">
            <div class="card shadow p-4 h-100 d-flex align-items-center justify-content-center">
                <h3 class="text-center">
                    Selamat Datang di Sistem Manajemen Purchase Order,<br>
                    <b><?= user()->username; ?></b> :)
                </h3>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow p-4 h-100">
                <h5 class="text-center mb-3">Perbandingan PO Approve vs Reject (30 Hari Terakhir)</h5>
                <canvas id="poChart"></canvas>
            </div>
        </div>

    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
var ctx = document.getElementById('poChart').getContext('2d');
var poChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['PO Approve', 'PO Reject'],
        datasets: [{
            data: [<?= $poApprove30 ?>, <?= $poReject30 ?>],
            backgroundColor: [
                '#28a745', 
                '#dc3545' 
            ],
            borderColor: '#ffffff',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>


<?= $this->endSection(); ?>
