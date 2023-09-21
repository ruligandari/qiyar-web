<!-- menambahkan template/template.php -->
<?= $this->extend('template/template'); ?>

<?= $this->section('header'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<?= $this->endSection(); ?>

<!-- menambahkan section -->
<?= $this->section('content'); ?>
<style>
  .dropzone {
    border: 0px;
  }

  div.dz-default.dz-message {
    border: 2px dashed #0087F7;
    border-radius: 5px;
    background: white;
    padding: 40px 20px;
  }
</style>
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
        <form method="POST" class="dropzone" id="fileDrop" action="<?= base_url('dashboard/broadcast/pengeluaran-broadcast/update') ?>" enctype="multipart/form-data">
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
            <input type="hidden" name="bukti_transfer_lama" value="<?= $data['upload_bukti'] ?>">
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Jumlah</label>
            <input type="text" name="jumlah" value="<?= number_format($data['jumlah']) ?>" class="form-control formatted-input" placeholder="Masukan Jumlah" required>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
          <div class="form-group">
            <p>Bukti Transfer Sebelumnya: <a href="<?= base_url('bukti_pengeluaran_broadcast/') . $data['upload_bukti'] ?>"><?= $data['upload_bukti'] ?></a></p>
          </div>
        </form>
      </div>
    </div>

  </div>
  <?= $this->endSection(); ?>

  <?= $this->section('script'); ?>
  <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

  <script>
    Dropzone.autoDiscover = true;
    Dropzone.options.fileDrop = { // The camelized version of the ID of the form element

      // The configuration we've talked about above
      autoProcessQueue: false,
      // paramname
      paramName: "upload_bukti",
      uploadMultiple: false,
      parallelUploads: 1,
      maxFiles: 1,
      maxFilesize: 2, // MB
      acceptedFiles: ".jpeg,.jpg,.png,.gif",
      // tambahkan close
      addRemoveLinks: true,
      // atur agar diatas button submit
      dictDefaultMessage: "Klik atau Drop disini untuk mengupload Bukti Upload",

      dictFileTooBig: "Ukuran file terlalu besar ({{filesize}}MiB). Maksimal ukuran file {{maxFilesize}}MiB.",

      // The setting up of the dropzone
      init: function() {
        var myDropzone = this;
        // autodiscover set false
        // First change the button to actually tell Dropzone to process the queue.
        this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
          // Make sure that the form isn't actually being sent.
          if (myDropzone.getQueuedFiles().length > 0) {
            // Ada file dalam antrian, proses antrian
            e.preventDefault();
            e.stopPropagation();
            myDropzone.processQueue();
          } else {
            // Tidak ada file dalam antrian, izinkan formulir untuk dikirimkan
          }
        });

        // terima response ketika sukses
        this.on("success", function(file, response) {
          // dapatkan status dari json response
          var respond = JSON.parse(response);

          console.log(respond.data);
          // jika sukses
          if (respond.status == true) {
            // sweet alert
            Swal.fire({
              position: 'center',
              icon: 'success',
              text: 'Data berhasil diupdate!',
              showConfirmButton: false,
              timer: 2000
            }).then(function() {
              window.location = "<?= base_url('dashboard/broadcast/pengeluaran-broadcast') ?>";
            });
          } else {
            // sweet alert
            Swal.fire({
              position: 'center',
              icon: 'error',
              text: 'Data gagal ditambahkan!',
              showConfirmButton: false,
              timer: 2000
            });
          }
        });

        // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
        // of the sending event because uploadMultiple is set to true.
        this.on("sendingmultiple", function() {
          // Gets triggered when the form is actually being sent.
          // Hide the success button or the complete form.

        });
        this.on("successmultiple", function(files, response) {
          // Gets triggered when the files have successfully been sent.
          // Redirect user or notify of success.

          console.log(response);
        });
        this.on("errormultiple", function(files, response) {
          // Gets triggered when there was an error sending the files.
          // Maybe show form again, and notify user of error
          console.log(response);
        });
      }

    }
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