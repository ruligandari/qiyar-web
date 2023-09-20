<!-- menambahkan template/template.php -->
<?= $this->extend('template/template'); ?>

<!-- menambahkan section -->
<?= $this->section('content'); ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;" class="pull-right">
            <i class="fa fa-calendar"></i>&nbsp;
            <span></span> <i class="fa fa-caret-down"></i>
        </div>
    </div>
    <!-- view all -->

    <?php if (session()->get('role') == '1' || session()->get('role') == '3') : ?>
        <!-- ADVERTISER -->
        <div class="card mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Advertiser</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- pemasukan adv -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Pemasukan Advertiser</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <span id="pemasukan-adv"></span></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- uang transfer -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary  h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Uang Transfer Advertiser</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <span id="uang-transfer-adv"></span></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- pengeluaran iklan -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger  h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                            Pengeluaran Advertiser (Iklan)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <span id="pengeluaran-iklan"></span></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- jenis pengeluaran -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning  h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Jenis Pengeluaran</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <span id="pengeluaran-kantor-adv"></span></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- laba -->
                </div>
                <!-- Grafik Adv -->
                <div class="row">
                    <!-- Grafik -->
                    <!-- Area Chart -->
                    <div class="col-xl-9 col-lg-6">
                        <div class="card mb-4">
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-area">
                                    <canvas id="myAreaChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info h-10 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Laba Advertiser
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            Rp. <span id="laba-advertiser"></span>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Content Row -->
            </div>
        </div>
    <?php endif ?>
    <?php if (session()->get('role') == '1' || session()->get('role') == '2') : ?>
        <!-- BROADCAST -->
        <div class="card mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Broadcast</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Pemasukan Broadcast</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <span id="pemasukan-bc">0</span> </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary  h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Uang Transfer Broadcast</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <span id="uang-transfer-bc">0</span></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                            Uang Transfer Advertiser</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <span id="uang-transfer-bc-adv">0</span></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning  h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Jenis Pengeluaran</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <span id="pengeluaran-bc">0</span></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- laba -->
                </div>
                <!-- Grafik Broadcast -->
                <div class="row">
                    <!-- Grafik -->
                    <div class="col-xl-9 col-lg-12">
                        <div class="card mb-4">
                            <!-- Card Body -->
                            <div class="card-body">

                                <div class="chart-area">
                                    <canvas id="chartBroadcast"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info h-10 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Laba Broadcast
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            Rp. <span id="laba-bc">0</span>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Content Row -->
            </div>
        </div>
    <?php endif ?>

    <?php if (session()->get('role') == '4' || session()->get('role') == '5' || session()->get('role') == '6' || session()->get('role') == '7') : ?>
        <div class="card">
            <div class="card-header bg-success text-white">Welcome Back !</div>
            <div class=" card-body">
                <h5 class="card-title">Haloo, Selamat Datang <?= session()->get('nama') ?></h5>
                <p class="card-text">Selamat bekerja, semoga harimu menyenangkan 😊</p>
            </div>
        </div>

    <?php endif ?>
</div>
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<!-- jquery -->

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var start = moment().subtract(29, 'days');
        var end = moment();
        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);
    });

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        console.log($('#reportrange span').html());

        var startDate = start.format('YYYY-MM-DD');
        var endDate = end.format('YYYY-MM-DD');

        $.ajax({
            url: '<?= base_url('dashboard/list-pendapatan-adv') ?>',
            method: 'POST',
            data: {
                start_date: startDate,
                end_date: endDate
            },
            success: function(response) {
                console.log(response);
                var data = JSON.parse(response);
                var dataPemasukan = data.pemasukan;
                var dataPengeluaran = data.pengeluaran;
                var dataPengeluaranKantor = data.pengeluaranKantor;
                var dataPemasukanTransfer = data.pemasukanTransfer;

                var dataPemasukanBc = data.pemasukanBroadcast;
                var dataUangTransferBc = data.uangTransferBc;
                var dataUangTransferAdv = data.uangTransferAdv;
                var dataPengeluaranBc = data.pengeluaranBc;

                function sumJumlah(dataArray) {
                    return dataArray.reduce(function(total, item) {
                        return total + parseFloat(item.jumlah);
                    }, 0);
                }

                function sumJumlahTransfer(dataArray) {
                    return dataArray.reduce(function(total, item) {
                        return total + parseFloat(item.harga_total);
                    }, 0);
                }
                var totalPengeluaran = sumJumlah(dataPengeluaran);
                var totalPemasukan = sumJumlah(dataPemasukan);
                var totalPemasukanTransferAdv = sumJumlahTransfer(dataPemasukanTransfer);
                var totalPengeluaranKantor = sumJumlah(dataPengeluaranKantor);

                var labaAdvertiser = totalPemasukan + totalPemasukanTransferAdv - totalPengeluaran - totalPengeluaranKantor;

                var totalPemasukanBc = sumJumlah(dataPemasukanBc);
                var totalUangTransferBc = sumJumlahTransfer(dataUangTransferBc);
                var totalUangTransferAdv = sumJumlahTransfer(dataUangTransferAdv);
                var totalPengeluaranBc = sumJumlah(dataPengeluaranBc);

                var labaBroadcast = totalPemasukanBc + totalUangTransferBc - totalUangTransferAdv - totalPengeluaranBc;
                // masukan ke id pengeluaran-iklan dengan number format
                var formatPengeluaran = number_format(totalPengeluaran, 0, ',', '.');
                var formatPemasukan = number_format(totalPemasukan, 0, ',', '.');
                var formatPemasukanTransfer = number_format(totalPemasukanTransferAdv, 0, ',', '.');
                var formatPengeluaranKantor = number_format(totalPengeluaranKantor, 0, ',', '.');

                var formatLabaAdvertiser = number_format(labaAdvertiser, 0, ',', '.');

                var formatPemasukanBc = number_format(totalPemasukanBc, 0, ',', '.');
                var formatUangTransferBc = number_format(totalUangTransferBc, 0, ',', '.');
                var formatUangTransferAdv = number_format(totalUangTransferAdv, 0, ',', '.');
                var formatPengeluaranBc = number_format(totalPengeluaranBc, 0, ',', '.');

                var formatLabaBroadcast = number_format(labaBroadcast, 0, ',', '.');

                $('#pengeluaran-iklan').html(formatPengeluaran);
                $('#pemasukan-adv').html(formatPemasukan);
                $('#uang-transfer-adv').html(formatPemasukanTransfer);
                $('#pengeluaran-kantor-adv').html(formatPengeluaranKantor);
                $('#laba-advertiser').html(formatLabaAdvertiser);

                $('#pemasukan-bc').html(formatPemasukanBc);
                $('#uang-transfer-bc').html(formatUangTransferBc);
                $('#uang-transfer-bc-adv').html(formatUangTransferAdv);
                $('#pengeluaran-bc').html(formatPengeluaranBc);
                $('#laba-bc').html(formatLabaBroadcast);
                var groupedData = {};
                var groupedDataBc = {};

                // Memproses data pemasukan
                dataPemasukan.forEach(function(item) {
                    var tanggal = item.tanggal;
                    if (!groupedData[tanggal]) {
                        groupedData[tanggal] = {
                            pemasukan: 0,
                            pengeluaran: 0,
                            pengeluaranKantor: 0,
                            pemasukanTransfer: 0
                        };
                    }
                    groupedData[tanggal].pemasukan += parseFloat(item.jumlah);
                });

                // Memproses data pengeluaran
                dataPengeluaran.forEach(function(item) {
                    var tanggal = item.tanggal;
                    if (!groupedData[tanggal]) {
                        groupedData[tanggal] = {
                            pemasukan: 0,
                            pengeluaran: 0,
                            pengeluaranKantor: 0,
                            pemasukanTransfer: 0
                        };
                    }
                    groupedData[tanggal].pengeluaran += parseFloat(item.jumlah);
                });

                // Memproses data pengeluaranKantor
                dataPengeluaranKantor.forEach(function(item) {
                    var tanggal = item.tanggal;
                    if (!groupedData[tanggal]) {
                        groupedData[tanggal] = {
                            pemasukan: 0,
                            pengeluaran: 0,
                            pengeluaranKantor: 0,
                            pemasukanTransfer: 0
                        };
                    }
                    groupedData[tanggal].pengeluaranKantor += parseFloat(item.jumlah);
                });

                // Memproses data pemasukanTransfer
                dataPemasukanTransfer.forEach(function(item) {
                    var tanggal = item.tanggal;
                    if (!groupedData[tanggal]) {
                        groupedData[tanggal] = {
                            pemasukan: 0,
                            pengeluaran: 0,
                            pengeluaranKantor: 0,
                            pemasukanTransfer: 0
                        };
                    }
                    groupedData[tanggal].pemasukanTransfer += parseFloat(item.harga_total);
                });

                dataPemasukanBc.forEach(function(item) {
                    var tanggal = item.tanggal;
                    if (!groupedDataBc[tanggal]) {
                        groupedDataBc[tanggal] = {
                            pemasukanBroadcast: 0,
                            uangTransferBc: 0,
                            uangTransferAdv: 0,
                            pengeluaranBc: 0
                        };
                    }
                    groupedDataBc[tanggal].pemasukanBroadcast += parseFloat(item.jumlah);
                });

                dataUangTransferBc.forEach(function(item) {
                    var tanggal = item.tanggal;
                    if (!groupedDataBc[tanggal]) {
                        groupedDataBc[tanggal] = {
                            pemasukanBroadcast: 0,
                            uangTransferBc: 0,
                            uangTransferAdv: 0,
                            pengeluaranBc: 0
                        };
                    }
                    groupedDataBc[tanggal].uangTransferBc += parseFloat(item.harga_total);
                });

                dataUangTransferAdv.forEach(function(item) {
                    var tanggal = item.tanggal;
                    if (!groupedDataBc[tanggal]) {
                        groupedDataBc[tanggal] = {
                            pemasukanBroadcast: 0,
                            uangTransferBc: 0,
                            uangTransferAdv: 0,
                            pengeluaranBc: 0
                        };
                    }
                    groupedDataBc[tanggal].uangTransferAdv += parseFloat(item.harga_total);
                });

                dataPengeluaranBc.forEach(function(item) {
                    var tanggal = item.tanggal;
                    if (!groupedDataBc[tanggal]) {
                        groupedDataBc[tanggal] = {
                            pemasukanBroadcast: 0,
                            uangTransferBc: 0,
                            uangTransferAdv: 0,
                            pengeluaranBc: 0
                        };
                    }
                    groupedDataBc[tanggal].pengeluaranBc += parseFloat(item.jumlah);
                });
                // Mengambil tanggal sebagai label
                var labels = Object.keys(groupedData);
                var labelsbroadcast = Object.keys(groupedDataBc);

                // Mengambil data pemasukan, pengeluaran, pengeluaranKantor, dan pemasukanTransfer sebagai data
                var dataValuesPemasukan = labels.map(function(label) {
                    return groupedData[label].pemasukan;
                });
                var dataValuesPengeluaran = labels.map(function(label) {
                    return groupedData[label].pengeluaran;
                });
                var dataValuesPengeluaranKantor = labels.map(function(label) {
                    return groupedData[label].pengeluaranKantor;
                });
                var dataValuesPemasukanTransfer = labels.map(function(label) {
                    return groupedData[label].pemasukanTransfer;
                });

                var dataValuesPemasukanBc = labelsbroadcast.map(function(label) {
                    return groupedDataBc[label].pemasukanBroadcast;
                });

                var dataValuesUangTransferBc = labelsbroadcast.map(function(label) {
                    return groupedDataBc[label].uangTransferBc;
                });

                var dataValuesUangTransferAdv = labelsbroadcast.map(function(label) {
                    return groupedDataBc[label].uangTransferAdv;
                });

                var dataValuesPengeluaranBc = labelsbroadcast.map(function(label) {
                    return groupedDataBc[label].pengeluaranBc;
                });

                // Membuat grafik batang

                <?php if (session()->get('role') == '3' || session()->get('role') == '1') : ?>
                    var ctx = document.getElementById('myAreaChart').getContext('2d');
                    var myLineChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                    label: "Pengeluaran Advertiser (Iklan)",
                                    lineTension: 0.3,
                                    backgroundColor: "rgba(231,74,59, 0.05)",
                                    borderColor: "rgba(231,74,59)",
                                    pointRadius: 3,
                                    pointBackgroundColor: "rgba(231,74,59)",
                                    pointBorderColor: "rgba(231,74,59)",
                                    pointHoverRadius: 3,
                                    pointHoverBackgroundColor: "rgba(231,74,59)",
                                    pointHoverBorderColor: "rgba(231,74,59)",
                                    pointHitRadius: 10,
                                    pointBorderWidth: 2,
                                    data: dataValuesPengeluaran,
                                },
                                {
                                    label: "Pemasukan Advertiser",
                                    lineTension: 0.3,
                                    backgroundColor: "rgba(97,201,139, 0.05)",
                                    borderColor: "rgba(97,201,139)",
                                    pointRadius: 3,
                                    pointBackgroundColor: "rgba(97,201,139)",
                                    pointBorderColor: "rgba(97,201,139)",
                                    pointHoverRadius: 3,
                                    pointHoverBackgroundColor: "rgba(97,201,139)",
                                    pointHoverBorderColor: "rgba(97,201,139)",
                                    pointHitRadius: 10,
                                    pointBorderWidth: 2,
                                    data: dataValuesPemasukan,
                                },
                                {
                                    label: "Uang Transfer Advertiser",
                                    lineTension: 0.3,
                                    backgroundColor: "rgba(88,148,255, 0.05)",
                                    borderColor: "rgba(88,148,255)",
                                    pointRadius: 3,
                                    pointBackgroundColor: "rgba(88,148,255)",
                                    pointBorderColor: "rgba(88,148,255)",
                                    pointHoverRadius: 3,
                                    pointHoverBackgroundColor: "rgba(88,148,255)",
                                    pointHoverBorderColor: "rgba(88,148,255)",
                                    pointHitRadius: 10,
                                    pointBorderWidth: 2,
                                    data: dataValuesPemasukanTransfer,
                                },
                                {
                                    label: "Jenis Pengeluaran",
                                    lineTension: 0.3,
                                    backgroundColor: "rgba(244,202,41, 0.05)",
                                    borderColor: "rgba(244,202,41)",
                                    pointRadius: 3,
                                    pointBackgroundColor: "rgba(244,202,41)",
                                    pointBorderColor: "rgba(244,202,41)",
                                    pointHoverRadius: 3,
                                    pointHoverBackgroundColor: "rgba(244,202,41)",
                                    pointHoverBorderColor: "rgba(244,202,41)",
                                    pointHitRadius: 10,
                                    pointBorderWidth: 2,
                                    data: dataValuesPengeluaranKantor,
                                }
                            ],
                        },
                        options: {
                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    left: 10,
                                    right: 25,
                                    top: 25,
                                    bottom: 0
                                }
                            },
                            scales: {
                                xAxes: [{
                                    time: {
                                        unit: 'date'
                                    },
                                    gridLines: {
                                        display: false,
                                        drawBorder: false
                                    },
                                    ticks: {
                                        maxTicksLimit: 30
                                    }
                                }],
                                yAxes: [{
                                    ticks: {
                                        maxTicksLimit: 7,
                                        padding: 10,
                                        // Include a dollar sign in the ticks
                                        callback: function(value, index, values) {
                                            return 'Rp.' + number_format(value);
                                        }
                                    },
                                    gridLines: {
                                        color: "rgb(234, 236, 244)",
                                        zeroLineColor: "rgb(234, 236, 244)",
                                        drawBorder: false,
                                        borderDash: [2],
                                        zeroLineBorderDash: [2]
                                    }
                                }],
                            },
                            legend: {
                                display: false
                            },
                            tooltips: {
                                backgroundColor: "rgb(255,255,255)",
                                bodyFontColor: "#858796",
                                titleMarginBottom: 10,
                                titleFontColor: '#6e707e',
                                titleFontSize: 14,
                                borderColor: '#dddfeb',
                                borderWidth: 1,
                                xPadding: 15,
                                yPadding: 15,
                                displayColors: true,
                                intersect: false,
                                mode: 'index',
                                caretPadding: 10,
                                callbacks: {
                                    label: function(tooltipItem, chart) {
                                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                        return datasetLabel + ': Rp.' + number_format(tooltipItem.yLabel);
                                    }
                                }
                            }
                        }
                    });
                <?php endif ?>
                <?php if (session()->get('role') == '2' || session()->get('role') == '1') : ?>
                    var ctx2 = document.getElementById('chartBroadcast').getContext('2d');
                    var myLineChart2 = new Chart(ctx2, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                    label: "Uang Transfer Advertiser",
                                    lineTension: 0.3,
                                    backgroundColor: "rgba(231,74,59, 0.05)",
                                    borderColor: "rgba(231,74,59)",
                                    pointRadius: 3,
                                    pointBackgroundColor: "rgba(231,74,59)",
                                    pointBorderColor: "rgba(231,74,59)",
                                    pointHoverRadius: 3,
                                    pointHoverBackgroundColor: "rgba(231,74,59)",
                                    pointHoverBorderColor: "rgba(231,74,59)",
                                    pointHitRadius: 10,
                                    pointBorderWidth: 2,
                                    data: dataValuesUangTransferAdv,
                                },
                                {
                                    label: "Pemasukan Broadcast",
                                    lineTension: 0.3,
                                    backgroundColor: "rgba(97,201,139, 0.05)",
                                    borderColor: "rgba(97,201,139)",
                                    pointRadius: 3,
                                    pointBackgroundColor: "rgba(97,201,139)",
                                    pointBorderColor: "rgba(97,201,139)",
                                    pointHoverRadius: 3,
                                    pointHoverBackgroundColor: "rgba(97,201,139)",
                                    pointHoverBorderColor: "rgba(97,201,139)",
                                    pointHitRadius: 10,
                                    pointBorderWidth: 2,
                                    data: dataValuesPemasukanBc,
                                },
                                {
                                    label: "Uang Transfer Broadcast",
                                    lineTension: 0.3,
                                    backgroundColor: "rgba(88,148,255, 0.05)",
                                    borderColor: "rgba(88,148,255)",
                                    pointRadius: 3,
                                    pointBackgroundColor: "rgba(88,148,255)",
                                    pointBorderColor: "rgba(88,148,255)",
                                    pointHoverRadius: 3,
                                    pointHoverBackgroundColor: "rgba(88,148,255)",
                                    pointHoverBorderColor: "rgba(88,148,255)",
                                    pointHitRadius: 10,
                                    pointBorderWidth: 2,
                                    data: dataValuesUangTransferBc,
                                },
                                {
                                    label: "Jenis Pengeluaran",
                                    lineTension: 0.3,
                                    backgroundColor: "rgba(244,202,41, 0.05)",
                                    borderColor: "rgba(244,202,41)",
                                    pointRadius: 3,
                                    pointBackgroundColor: "rgba(244,202,41)",
                                    pointBorderColor: "rgba(244,202,41)",
                                    pointHoverRadius: 3,
                                    pointHoverBackgroundColor: "rgba(244,202,41)",
                                    pointHoverBorderColor: "rgba(244,202,41)",
                                    pointHitRadius: 10,
                                    pointBorderWidth: 2,
                                    data: dataValuesPengeluaranBc,
                                }
                            ],
                        },
                        options: {
                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    left: 10,
                                    right: 25,
                                    top: 25,
                                    bottom: 0
                                }
                            },
                            scales: {
                                xAxes: [{
                                    time: {
                                        unit: 'date'
                                    },
                                    gridLines: {
                                        display: false,
                                        drawBorder: false
                                    },
                                    ticks: {
                                        maxTicksLimit: 30
                                    }
                                }],
                                yAxes: [{
                                    ticks: {
                                        maxTicksLimit: 7,
                                        padding: 10,
                                        // Include a dollar sign in the ticks
                                        callback: function(value, index, values) {
                                            return 'Rp.' + number_format(value);
                                        }
                                    },
                                    gridLines: {
                                        color: "rgb(234, 236, 244)",
                                        zeroLineColor: "rgb(234, 236, 244)",
                                        drawBorder: false,
                                        borderDash: [2],
                                        zeroLineBorderDash: [2]
                                    }
                                }],
                            },
                            legend: {
                                display: false
                            },
                            tooltips: {
                                backgroundColor: "rgb(255,255,255)",
                                bodyFontColor: "#858796",
                                titleMarginBottom: 10,
                                titleFontColor: '#6e707e',
                                titleFontSize: 14,
                                borderColor: '#dddfeb',
                                borderWidth: 1,
                                xPadding: 15,
                                yPadding: 15,
                                displayColors: true,
                                intersect: false,
                                mode: 'index',
                                caretPadding: 10,
                                callbacks: {
                                    label: function(tooltipItem, chart) {
                                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                        return datasetLabel + ': Rp.' + number_format(tooltipItem.yLabel);
                                    }
                                }
                            }
                        }
                    });
                <?php endif ?>


            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }
</script>

<?= $this->endSection(); ?>