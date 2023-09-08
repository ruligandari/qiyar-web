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
    <h1 class="h3 mb-0 text-gray-800">Edit Data Pengeluaran Kantor</h1>
  </div>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="">
        <h6 class=" font-weight-bold text-primary">Silahkan Masukan Data</h6>
      </div>
      <div class="card-body">
        <form method="POST" action="<?= base_url('dashboard/advertiser/pengeluaran-kantor/update') ?>" enctype="multipart/form-data">
          <input type="hidden" name="id_pengeluaran_kantor" value="<?= $data['id_pengeluaran_kantor'] ?>">
          <div class="form-group">
            <label for="formGroupExampleInput">Jenis Pengeluaran</label>
            <select name="jenis_pengeluaran" id="" class="form-control">
              <option value="<?= $data['jenis_pengeluaran'] ?>" selected><?= $data['jenis_pengeluaran'] ?></option>
              <option value="Pengeluaran Kantor">Pengeluaran Kantor</option>
              <option value="Belanja Barang">Belanja Barang</option>
            </select>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Bank Tujuan</label>
            <input type="text" name="bank_tujuan" class="form-control " value="<?= $data['bank_tujuan'] ?>" required>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Nama Bank Penerima</label>
            <input type="text" name="nama_penerima" placeholder="Nama Bank Penerima" class="form-control " value="<?= $data['nama_penerima'] ?>" required>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Jumlah</label>
            <input type="text" name="jumlah" placeholder="Nama Bank Penerima" class="form-control formatted-input" value="<?= number_format($data['jumlah'], 0, ',', '.') ?>" required>
          </div>
          <div class=" form-group">
            <label for="formGroupExampleInput">Upload Bukti Pembayaran</label>
            <input type="file" name="bukti_transfer" class="form-control-file form-control" id="exampleFormControlFile1">
            <input type="hidden" name="bukti_transfer_lama" value="<?= $data['bukti_transfer'] ?>">
            <?php if ($data['bukti_transfer'] != null) : ?>
              <p>Bukti Transfer Sebelumnya: <a href="<?= base_url('bukti_pengeluaran_kantor/') . $data['bukti_transfer'] ?>"><?= $data['bukti_transfer'] ?></a></p>
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
  <?= $this->endSection(); ?>