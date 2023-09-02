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
    <h1 class="h3 mb-0 text-gray-800">Data Pengeluaran Advertiser</h1>
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
        window.location = "<?= base_url('dashboard/pengeluaran-advertiser') ?>";
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
        <form method="POST" action="<?= base_url('dashboard/tambah-data-pengeluaran-advertiser/add') ?>">
          <div class="form-group">
            <label for="formGroupExampleInput">Tanggal Input</label>
            <input type="date" class="form-control tanggal" value="<?= date('Y-m-d') ?>" id="formGroupExampleInput" name="tanggal" placeholder="Tanggal Input">
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Waktu</label>
            <input type="time" class="form-control" name="waktu" id="formGroupExampleInput">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Nama Advertiser</label>
            <select class="custom-select" name="nama_advertiser">
              <option selected>Pilih Advertiser</option>
              <?php foreach ($karyawan as $data) : ?>
                <option value="<?= $data['nama'] ?>"><?= $data['nama'] ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Bank Tujuan</label>
            <input type="text" class="form-control" id="formGroupExampleInput" name="banktujuan" placeholder="Masukan Bank Tujuan">
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Jumlah</label>
            <input type="text" class="form-control formatted-input" id="harga" name="jumlah" placeholder="Masukan Jumlah">
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Nama Bank Penerima</label>
            <textarea class="form-control" id="formGroupExampleInput" name="keterangan" placeholder="Masukan Nama Bank Penerima"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>

  </div>
  <?= $this->endSection(); ?>

  <?= $this->section('script'); ?>
  <script>
    // Ambil semua elemen input dengan kelas "tanggal"
    const dateInputs = document.querySelector(".tanggal");

    // Loop melalui setiap elemen input tanggal
    dateInputs.forEach(function(dateInput) {
      // Ketika nilai input berubah
      dateInput.addEventListener("input", function() {
        // Ambil nilai dari input
        const inputValue = dateInput.value;

        // Periksa apakah nilai input sesuai dengan format yang diinginkan (YYYY/MM/DD)
        if (/^\d{4}\/\d{2}\/\d{2}$/.test(inputValue)) {
          // Ubah format nilai input ke "YYYY-MM-DD"
          const newValue = inputValue.replace(/\//g, "-");

          // Set nilai input dengan format yang baru
          dateInput.value = newValue;
        }
      });
    });
  </script>
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