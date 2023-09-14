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
    <h1 class="h3 mb-0 text-gray-800">Edit Data Pemasukan Broadcast</h1>
  </div>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="">
        <h6 class=" font-weight-bold text-primary">Silahkan Masukan Data</h6>
      </div>
      <div class="card-body">
        <form method="POST" action="<?= base_url('dashboard/broadcast/uang-transfer-broadcast/update') ?>" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?= $data['id'] ?>">
          <div class="form-group">
            <label for="formGroupExampleInput">Nama Konsumen</label>
            <input type="text" name="nama_konsumen" class="form-control" value="<?= $data['nama_konsumen'] ?>" placeholder=" Masukan Nama Konsumen" required>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Bank Penerima</label>
            <select name="bank_penerima" class="form-control" id="formGroupExampleInput">
              <option value="<?= $data['bank_penerima'] ?>" selected><?= $data['bank_penerima'] ?></option>
              <option value="Mandiri">Mandiri</option>
              <option value="BCA">BCA</option>
              <option value="BRI">BRI</option>
              <option value="BNI">BNI</option>
            </select>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Jenis Transfer</label>
            <select name="jenis_transfer" class="form-control" id="formGroupExampleInput">
              <option value="<?= $data['jenis_transfer'] ?>" selected><?= $data['jenis_transfer'] ?></option>
              <option value="Iklan">Iklan</option>
              <option value="Broadcast">Broadcast</option>
            </select>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Harga Total</label>
            <input type="text" name="harga_total" placeholder="Harga Total" class="form-control formatted-input" value="<?= number_format($data['harga_total'], 0, ',', '.') ?>" required>
          </div>
          <div class=" form-group">
            <label for="formGroupExampleInput">Upload Bukti Pembayaran</label>
            <input type="file" name="upload_bukti" class="form-control-file form-control" id="exampleFormControlFile1">
            <input type="hidden" name="bukti_transfer_lama" value="<?= $data['upload_bukti'] ?>">
            <?php if ($data['upload_bukti'] != null) : ?>
              <p>Bukti Transfer Sebelumnya: <a href="<?= base_url('bukti_pengeluaran_broadcast/') . $data['upload_bukti'] ?>"><?= $data['upload_bukti'] ?></a></p>
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
  <script>
    function addThousandSeparator(input) {
      // Menambahkan pemisah ribuan ke input
      return input.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // Ambil semua elemen input dengan kelas "formatted-input"
    const inputElements = document.querySelectorAll(".formatted-input");

    inputElements.forEach(inputElement => {
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