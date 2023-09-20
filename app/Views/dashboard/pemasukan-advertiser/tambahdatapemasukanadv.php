<!-- menambahkan template/template.php -->
<?= $this->extend('template/template'); ?>

<?= $this->section('header'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
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
        text: <?= session()->getFlashdata('success') ?>,
        showConfirmButton: false,
        timer: 2000
      }).then(function() {
        window.location = "<?= base_url('dashboard/advertiser/pemasukan-advertiser') ?>";
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
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="">
        <h6 class=" font-weight-bold text-primary">Silahkan Masukan Data</h6>
      </div>
    </div>
    <div class="card-body">
      <form method="POST" class="dropzone" id="fileDrop" action="<?= base_url('dashboard/advertiser/tambah-data-pemasukan-advertiser/add')  ?> " enctype="multipart/form-data">
        <div class="form-group">
          <label for="formGroupExampleInput">Tanggal Input</label>
          <input type="date" class="form-control tanggal" value="<?= date('Y-m-d') ?>" id="formGroupExampleInput" name="tanggal" placeholder="Tanggal Input">
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
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>

</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
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
        if (myDropzone.getQueuedFiles().length != 0) {
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
            window.location = "<?= base_url('dashboard/advertiser/pemasukan-advertiser') ?>";
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
<?= $this->endSection(); ?>