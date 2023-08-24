<!-- menambahkan template/template.php -->
<?= $this->extend('template/template'); ?>

<!-- menambahkan section -->
<?= $this->section('content'); ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Produk</h1>
    </div>
     <!-- DataTales Example -->
     <div class="card shadow mb-4">
                        <div class="card-header py-3">
                                <div class=""><h6 class=" font-weight-bold text-primary">Silahkan Masukan Data</h6>
                        </div>
                        <div class="card-body">
                        <form>                      
  <div class="form-group">
    <label for="formGroupExampleInput">Nama Produk</label>
    <input type="number" class="form-control" id="formGroupExampleInput" placeholder="Masukan Nama Barang">
  </div>
  <div class="form-group">
    <label for="formGroupExampleInput">Stock</label>
    <input type="number" class="form-control" id="formGroupExampleInput" placeholder="Masukan Stock">
  </div><div class="form-group">
    <label for="formGroupExampleInput">Harga</label>
    <input type="number" class="form-control" id="formGroupExampleInput" placeholder="Masukan Harga">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
                        </div>
                    </div>

</div>
<?= $this->endSection(); ?>