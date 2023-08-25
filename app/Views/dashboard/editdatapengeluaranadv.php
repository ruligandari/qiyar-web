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
    <h1 class="h3 mb-0 text-gray-800">Edit Data Pengeluaran</h1>
  </div>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="">
        <h6 class=" font-weight-bold text-primary">Silahkan Masukan Data</h6>
      </div>
      <div class="card-body">
        <form method="POST" action="<?= base_url('dashboard/pengeluaran-advertiser/update') ?>">
          <input type="hidden" name="id_pengeluaran" value="<?= $data['id_pengeluaran'] ?>">
          <div class="form-group">
            <label for="formGroupExampleInput">Nama Advertiser</label>
            <input type="text" name="nama_advertiser" class="form-control" value="<?= $data['nama_advertiser'] ?>" id="formGroupExampleInput" placeholder="Masukan Nama Barang" required>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Jumlah</label>
            <input type="text" name="jumlah" class="form-control formatted-input" value="<?= number_format($data['jumlah'], 0, ',', '.') ?>" placeholder="Masukan Jumlah" required>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Bank Tujuan</label>
            <input type="text" name="bank_tujuan" class="form-control formatted-input" value="<?= $data['bank_tujuan'] ?>" required>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Nama Bank Penerima</label>
            <input type="text" name="keterangan" placeholder="Nama Bank Penerima" class="form-control formatted-input" value="<?= $data['keterangan'] ?>" required>
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