<!-- menambahkan template/template.php -->
<?= $this->extend('template/template'); ?>

<!-- menambahkan section -->
<?= $this->section('content'); ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Advertiser</h1>
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
            <option selected>Pilih Advertiser</option>
            <option value="Zaka">Zaka</option>
            <option value="Dwi">Dwi</option>
            <option value="Fatan">Fatan</option>
            <option value="Dwiki">Dwiki</option>
            <option value="Harsono">Harsono</option>
        </select>
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Nama Produk</label>
        <select class="custom-select">
        <option selected>Pilih Produk</option>
        <?php
            foreach($produk as $data):
        ?>
            <option value="<?=$data['nama_produk'] ?>"><?=$data['nama_produk'] ?></option>
        <?php
        endforeach
        ?>
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