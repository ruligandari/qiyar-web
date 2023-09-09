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
        <form method="POST" action="<?= base_url('dashboard/broadcast/pengeluaran-broadcast/update') ?>" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?= $data['id'] ?>">
          <div class="form-group">
            <label for="formGroupExampleInput">Pengeluaran</label>
            <select name="jenis_pengeluaran" class="form-control" id="formGroupExampleInput">
              <?php if ($data['jenis_pengeluaran'] = 'Pengeluaran Kantor') {
                $selected1 = 'selected';
                $selected2 = '';
              } else {
                $selected1 = '';
                $selected2 = 'selected';
              }
              ?>
              <option value="Pengeluaran Kantor" <?= $selected1 ?>>Pengeluaran Kantor</option>
              <option value="Belanja Barang" <?= $selected2 ?>>Belanja Barang</option>
            </select>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Bank Tujuan</label>
            <input type="text" name="bank_tujuan" placeholder="Masukan Bank Tujuan" class="form-control" value="<?= $data['bank_tujuan'] ?>" required>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Nama Bank Penerima</label>
            <input type="text" name="nama_penerima" placeholder="Nama Bank Penerima" class="form-control" value="<?= $data['nama_penerima'] ?>" required>
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
          <div class="form-group">
            <label for="formGroupExampleInput">Jumlah</label>
            <input type="text" name="jumlah" value="<?= number_format($data['jumlah']) ?>" class="form-control formatted-input" placeholder="Masukan Jumlah" required>
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
      return input.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // Ambil elemen input pertama dengan kelas "formatted-input"
    const inputElement = document.querySelector(".formatted-input");

    let hasUserEdited = false; // Variabel untuk melacak apakah pengguna telah mengubah input

    inputElement.addEventListener("input", function() {
      hasUserEdited = true; // Set variabel hasUserEdited menjadi true saat pengguna mengubah input

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

    // Ketika input kehilangan fokus, perbarui nilai asli jika pengguna telah mengubahnya
    inputElement.addEventListener("blur", function() {
      if (hasUserEdited) {
        // Jika pengguna telah mengubah input, perbarui nilai asli
        inputElement.setAttribute("value", inputElement.value.replace(/,/g, ""));
      }
    });
  </script>
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