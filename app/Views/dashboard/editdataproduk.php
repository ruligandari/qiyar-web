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
    <h1 class="h3 mb-0 text-gray-800">Edit Data Produk</h1>
  </div>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="">
        <h6 class=" font-weight-bold text-primary">Silahkan Masukan Data</h6>
      </div>
      <div class="card-body">
        <form method="POST" action="<?= base_url('dashboard/edit-data-produk/update') ?>">
          <input type="hidden" name="id_produk" value="<?= $produk['id_produk'] ?>">
          <div class="form-group">
            <label for="formGroupExampleInput">Nama Produk</label>
            <input type="text" name="nama_produk" class="form-control" value="<?= $produk['nama_produk'] ?>" id="formGroupExampleInput" placeholder="Masukan Nama Barang">
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Stock</label>
            <input type="number" name="stock" class="form-control" value="<?= $produk['stock'] ?>" id="formGroupExampleInput" placeholder="Masukan Stock">
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Harga</label>
            <input type="text" name="harga" class="form-control formatted-input" value="<?= $produk['harga'] ?>" id="harga" placeholder="Masukan Harga">
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>

  </div>
  <?= $this->endSection(); ?>

  <?= $this->section('script'); ?>
  <script>
    function addThousandSeparator(input) {
      // Menambahkan pemisah ribuan ke input
      return input.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // Ambil elemen input pertama dengan kelas "formatted-input"
    const inputElement = document.querySelector(".formatted-input");

    inputElement.addEventListener("input", function() {
      // Ambil nilai dari input
      const nilaiInput = parseFloat(inputElement.value.replace(/,/g, ""));

      // Pastikan nilaiInput adalah angka valid
      if (!isNaN(nilaiInput)) {
        // Tambahkan pemisah ribuan ke nilaiInput
        const nilaiFormat = addThousandSeparator(nilaiInput.toString());

        // Masukkan nilai yang diformat kembali ke input
        inputElement.value = nilaiFormat;
      }
    });
  </script>
  <?= $this->endSection(); ?>