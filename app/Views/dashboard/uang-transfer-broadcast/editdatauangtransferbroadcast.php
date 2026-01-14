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
    <h1 class="h3 mb-0 text-gray-800">Edit Data Pemasukan Broadcast</h1>
  </div>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="">
        <h6 class=" font-weight-bold text-primary">Silahkan Masukan Data</h6>
      </div>
    </div>
    <div class="card-body">
      <form method="POST" class="dropzone" id="fileDrop" action="<?= base_url('dashboard/broadcast/uang-transfer-broadcast/update') ?>" enctype="multipart/form-data">
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
            <option value="Broadcast Iklan">Broadcast Iklan</option>
          </select>
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">Harga Total</label>
          <input type="text" name="harga_total" placeholder="Harga Total" class="form-control formatted-input" value="<?= number_format($data['harga_total'], 0, ',', '.') ?>" required>
        </div>
        <div class=" form-group">
          <input type="hidden" name="bukti_transfer_lama" value="<?= $data['upload_bukti'] ?>">
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
            window.location = "<?= base_url('dashboard/broadcast/uang-transfer-broadcast') ?>";
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