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
    <h1 class="h3 mb-0 text-gray-800">Data Pemasukan Advertiser</h1>
  </div>

  <?php if (session()->getFlashdata('success')) : ?>
    <script>
      Swal.fire({
        position: 'center',
        icon: 'success',
        text: 'Data Pengeluaran Advertiser berhasil ditambahkan!',
        showConfirmButton: false,
        timer: 2000
      }).then(function() {
        window.location = "<?= base_url('dashboard/pemasukan-advertiser') ?>";
      });
    </script>
  <?php endif ?>
  <?php if (!empty(session()->getFlashdata('error'))) : ?>
    <script>
      Swal.fire({
        position: 'center',
        icon: 'error',
        text: '<?= session()->getFlashdata('error') ?>',
        showConfirmButton: false,
        timer: 2000
      });
    </script>
  <?php endif ?>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="">
        <h6 class=" font-weight-bold text-primary">Silahkan Masukan Data</h6>
      </div>
      <div class="card-body">
        <form method="POST" action="<?= base_url('dashboard/tambah-data-pemasukan-advertiser/add')  ?> " enctype="multipart/form-data">
          <div class="form-group">
            <label for="formGroupExampleInput">Tanggal Input</label>
            <input type="text" class="form-control" value="<?= date('Y-m-d') ?>" id="formGroupExampleInput" name="tanggal" placeholder="Tanggal Input" readonly>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Waktu</label>
            <input type="time" class="form-control" name="waktu" id="formGroupExampleInput" required>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Expedisi</label>
            <select name="expedisi" class="form-control" id="formGroupExampleInput">
              <option value="Sicepat">Sicepat</option>
              <option value="OExpress">OExpress</option>
              <option value="Ninja">Ninja</option>
            </select>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Bank Tujuan</label>
            <input type="text" class="form-control" id="formGroupExampleInput" name="banktujuan" placeholder="Masukan Bank Tujuan" required>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Nama Bank Penerima</label>
            <textarea class="form-control" id="formGroupExampleInput" name="penerima" placeholder="Masukan Nama Bank Penerima" required></textarea>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Jumlah</label>
            <input type="text" class="form-control formatted-input" id="harga" name="jumlah" placeholder="Masukan Jumlah" required>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Upload Bukti Pembayaran</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="customFile">
              <label class="custom-file-label" for="customFile" id="custom_File">Choose file</label>
            </div>
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