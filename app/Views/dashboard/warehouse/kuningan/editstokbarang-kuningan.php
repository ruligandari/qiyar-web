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
    <h1 class="h3 mb-0 text-gray-800">Edit Stok Barang Warehouse Kuningan</h1>
  </div>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="">
        <h6 class=" font-weight-bold text-primary">Silahkan Masukan Data</h6>
      </div>
      <div class="card-body">
        <form method="POST" action="<?= base_url('dashboard/warehouse-kuningan/stok/update') ?>" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?= $data['id'] ?>">
          <input type="hidden" name="qty_lama" value="<?= $data['qty'] ?>">
          <div class="form-group">
            <label for="formGroupExampleInput">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="<?= $data['tanggal'] ?>" placeholder=" Masukan Jumlah" required>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Nama Barang</label>
            <!-- <input type="text" name="nama_barang" class="form-control" value="<?= $data['nama_barang'] ?>" placeholder=" Masukan Jumlah" required> -->
            <select name="nama_barang" class="form-control">
              <option value="<?= $id ?>" selected><?= $data['nama_barang'] ?></option>
              <?php foreach ($barang as $b) : ?>
                <option value="<?= $b['id'] ?>" $isSelected><?= $b['nama_barang'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Jenis Barang Masuk</label>
            <select class="form-control" name="jenis_barang_masuk" id="">
              <?php if ($data['jenis_barang_masuk'] == 'Barang Return') : ?>
                <option value="Barang Return" selected>Barang Return</option>
                <option value="Barang Beli">Barang Beli</option>
              <?php else : ?>
                <option value="Barang Return">Barang Return</option>
                <option value="Barang Beli" selected>Barang Beli</option>
              <?php endif; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Qty</label>
            <input type="text" name="qty" placeholder="Jumlah" class="form-control" value="<?= $data['qty'] ?>" required>
          </div>
          <div class=" form-group">
            <label for="formGroupExampleInput">Upload Bukti</label>
            <input type="file" name="upload_bukti" class="form-control-file form-control" id="exampleFormControlFile1">
            <input type="hidden" name="bukti_transfer_lama" value="<?= $data['upload_bukti'] ?>">
            <?php if ($data['upload_bukti'] != null) : ?>
              <p>Bukti Sebelumnya: <a href="<?= base_url('bukti-barang-masuk-kng/') . $data['upload_bukti'] ?>"><?= $data['upload_bukti'] ?></a></p>
            <?php endif; ?>
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