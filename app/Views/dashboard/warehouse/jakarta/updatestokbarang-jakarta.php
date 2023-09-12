<!-- menambahkan template/template.php -->
<?= $this->extend('template/template'); ?>

<?= $this->section('header'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?= $this->endSection(); ?>

<!-- menambahkan section -->
<?= $this->section('content'); ?>
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Stok Barang</h1>
  </div>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="">
        <h6 class=" font-weight-bold text-primary">Silahkan Masukan Data</h6>
      </div>
    </div>
    <div class="card-body">
      <form method="POST" action="<?= base_url('dashboard/warehouse-jakarta/stok/add') ?>" enctype="multipart/form-data">
        <div class="form-group">
          <label for="formGroupExampleInput">Tanggal</label>
          <input type="date" name="tanggal" placeholder="Masukan Tanggal" value="<?= date('Y-m-d') ?>" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">Nama Barang</label>
          <select class="form-control" name="nama_barang">
            <option selected>Pilih Barang</option>
            <?php foreach ($barang_masuk as $data) : ?>
              <option value="<?= $data['id'] ?>"><?= $data['nama_barang'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">Jenis Barang Masuk</label>
          <select class="form-control" name="jenis_barang_masuk" id="">
            <option value="0" selected>Pilih Jenis Barang Masuk</option>
            <option value="Barang Return">Barang Return</option>
            <option value="Barang Baru">Barang Baru</option>
          </select>
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">Qty</label>
          <input type="text" name="qty" placeholder="Masukan Qty" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">Upload Bukti Pickup</label>
          <input type="file" class="form-control-file form-control" id="exampleFormControlFile1" name="upload_bukti">
          <br>
          <img id="previewImage" src="" style="max-width: 100%; max-height: 200px;">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>

</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
  // Mendapatkan elemen input file
  var inputFile = document.getElementById('exampleFormControlFile1');

  // Mendapatkan elemen gambar untuk menampilkan preview
  var previewImage = document.getElementById('previewImage');

  // Menambahkan event listener untuk menghandle perubahan input file
  inputFile.addEventListener('change', function() {
    var file = inputFile.files[0];

    if (file) {
      // Membaca file sebagai URL data
      var reader = new FileReader();

      reader.onload = function(e) {
        // Menampilkan gambar pada elemen gambar
        previewImage.src = e.target.result;
        // Menampilkan elemen gambar
        previewImage.style.display = 'block';
      };

      reader.readAsDataURL(file);
    } else {
      // Menghapus elemen gambar jika tidak ada file yang dipilih
      previewImage.src = "";
    }
  });
</script>
<?= $this->endSection(); ?>