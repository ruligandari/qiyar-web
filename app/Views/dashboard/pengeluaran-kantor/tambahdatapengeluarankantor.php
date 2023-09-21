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
    <h1 class="h3 mb-0 text-gray-800">Data Pengeluaran Kantor</h1>
  </div>

  <?php if (session()->getFlashdata('success')) : ?>
    <script>
      Swal.fire({
        position: 'center',
        icon: 'success',
        text: 'Data Pengeluaran Kantor berhasil ditambahkan!',
        showConfirmButton: false,
        timer: 2000
      }).then(function() {
        window.location = "<?= base_url('dashboard/data-pemasukan-advertiser') ?>";
      });
    </script>
  <?php endif ?>
  <?php if (session()->getFlashdata('error')) : ?>
    <!-- tambahkan alert bootstrap error dari validasi -->
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <?php
      $errors = session()->getFlashdata('error');
      if (is_array($errors) && count($errors) > 0) {
        echo '<ul>';
        foreach ($errors as $error) {
          echo "<li>$error</li>";
        }
        echo '</ul>';
      } else {
        echo $errors; // Ini akan menampilkan pesan jika 'error' bukan array.
      }
      ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>

  <?php endif ?>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="">
        <h6 class=" font-weight-bold text-primary">Silahkan Masukan Data</h6>
      </div>
    </div>
    <div class="card-body">
      <form method="POST" class="dropzone" id="fileDrop" action="<?= base_url('dashboard/advertiser/pengeluaran-kantor/add')  ?> " enctype="multipart/form-data">
        <div class="form-group">
          <label for="formGroupExampleInput">Tanggal Input</label>
          <input type="date" class="form-control" value="<?= date('Y-m-d') ?>" id="formGroupExampleInput" name="tanggal" placeholder="Tanggal Input" required>
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">Waktu</label>
          <input type="time" class="form-control" name="waktu" id="formGroupExampleInput" required>
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">Jenis Pengeluaran</label>
          <select name="jenis_pengeluaran" id="" class="form-control" required>
            <option value="Pengeluaran Kantor">Pengeluaran Kantor</option>
            <option value="Belanja Barang">Belanja Barang</option>
          </select>
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">Keterangan</label>
          <textarea class="form-control" id="formGroupExampleInput" name="keterangan" placeholder="Masukan Keterangan" required></textarea>
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
        <button type="submit" class="btn btn-primary">Submit</button>
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
    required: true,
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
          e.preventDefault();
          e.stopPropagation();
          myDropzone.processQueue();
        } else {
          // sweet alert
          Swal.fire({
            position: 'center',
            icon: 'error',
            text: 'Data belum lengkap!',
            showConfirmButton: false,
            timer: 2000
          });
        }
      });

      // terima response ketika sukses
      this.on("success", function(file, response) {
        console.log(response);
        // dapatkan status dari json response
        var respond = JSON.parse(response);
        // jika sukses
        if (respond.status == true) {
          // sweet alert
          Swal.fire({
            position: 'center',
            icon: 'success',
            text: 'Data berhasil ditambahkan!',
            showConfirmButton: false,
            timer: 2000
          }).then(function() {
            window.location = "<?= base_url('dashboard/advertiser/pengeluaran-kantor') ?>";
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