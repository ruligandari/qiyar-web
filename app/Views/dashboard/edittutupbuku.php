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
    <h1 class="h3 mb-0 text-gray-800">Edit Data Tutup Buku</h1>
  </div>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="">
        <h6 class=" font-weight-bold text-primary">Silahkan Masukan Data</h6>
      </div>
      <div class="card-body">
        <form method="POST" action="<?= base_url('dashboard/tutup-buku/update') ?>">
          <input type="hidden" name="id" value="<?= $data['id'] ?>">
          <div class="form-group">
            <label for="formGroupExampleInput">Total Pengeluaran Advertiser</label>
            <input type="text" class="form-control formatted-input" value="<?= number_format($data['total_pengeluaran_adv'], 0, ',', '.') ?>" id="formGroupExampleInput" name="total_pengeluaran_adv" placeholder="Masukan Bank Tujuan">
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Total Pemasukan Advertiser</label>
            <input type="text" class="form-control formatted-input" value=" <?= number_format($data['total_pemasukan_adv'], 0, ',', '.') ?>" id="formGroupExampleInput" name="total_pemasukan_adv" placeholder="Masukan Bank Tujuan">
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Laba</label>
            <input type="text" value="<?= number_format($data['total'], 0, ',', '.') ?>" class="form-control formatted-input" id="harga" name="total" placeholder="Masukan Jumlah">
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

    // Ambil semua elemen input dengan kelas "formatted-input"
    const inputElements = document.querySelectorAll(".formatted-input");

    // Tambahkan event listener ke masing-masing elemen input
    inputElements.forEach(function(inputElement) {
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
    });
  </script>
  <?= $this->endSection(); ?>