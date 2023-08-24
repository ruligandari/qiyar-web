<!-- menambahkan template/template.php -->
<?= $this->extend('template/template'); ?>

<!-- menambahkan section -->
<?= $this->section('content'); ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Advertiser</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>
     <!-- DataTales Example -->
     <div class="card shadow mb-4">
                        <div class="card-header py-3">
                                <div class=""><h6 class=" font-weight-bold text-primary">Silahkan Masukan Data</h6>
                        </div>
                        <div class="card-body">
                        <form>
    <div class="form-group">
    <label for="formGroupExampleInput">Tanggal Input</label>
    <input type="text" class="form-control" value="<?=date('d-m-Y') ?>" id="formGroupExampleInput" placeholder="Tanggal Input" readonly>
  </div>                          
  <div class="form-group">
    <label for="exampleInputEmail1">Nama Advertiser</label>
        <select class="custom-select">
            <option selected>Open this select menu</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
        </select>
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Nama Produk</label>
        <select class="custom-select">
            <option selected>Open this select menu</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
        </select>
  </div>
  <div class="form-group">
    <label for="formGroupExampleInput">Jumlah Pengiriman</label>
    <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Masukan Jumlah Barang">
  </div>
  <div class="form-group">
    <label for="formGroupExampleInput">Total Harga</label>
    <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Total Harga">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
                        </div>
                    </div>

</div>
<?= $this->endSection(); ?>