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
      <div class="">
        <h6 class=" font-weight-bold text-primary">Silahkan Masukan Data</h6>
      </div>
      <div class="card-body">
        <form method="POST" action="<?= base_url('dashboard/tambah-data-advertiser/add') ?>">
          <div class="form-group">
            <label for="formGroupExampleInput">Tanggal Input</label>
            <input type="text" class="form-control" name="tanggal" value="<?= date('Y-m-d') ?>" id="formGroupExampleInput" placeholder="Tanggal Input" readonly>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Nama Advertiser</label>
            <select class="custom-select" name="nama_advertiser">
              <option selected>Pilih Advertiser</option>
              <option value="Zaka">Zaka</option>
              <option value="Dwi Prayogo">Dwi Prayogo</option>
              <option value="Fatan">Fatan</option>
              <option value="Dwiki Renaldhi">Dwiki Renaldhi</option>
              <option value="Harsono">Harsono</option>
              <option value="Rino">Rino</option>
            </select>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Total Harga</label>
            <input type="text" name="total_harga" class="form-control formatted-input" id="formGroupExampleInput" placeholder="Total Harga">
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