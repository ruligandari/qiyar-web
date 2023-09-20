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
    <h1 class="h3 mb-0 text-gray-800">Tambah Stok Barang</h1>
  </div>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="">
        <h6 class=" font-weight-bold text-primary">Silahkan Masukan Data</h6>
      </div>
    </div>
    <div class="card-body">
      <form method="POST" class="dropzone" id="fileDrop" action="<?= base_url('dashboard/warehouse-kuningan/stok/add') ?>" enctype="multipart/form-data">
        <div class="form-group">
          <label for="formGroupExampleInput">Tanggal</label>
          <input type="date" name="tanggal" placeholder="Masukan Tanggal" value="<?= date('Y-m-d') ?>" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">Nama Barang</label>
          <select class="form-control" name="nama_barang">
            <option selected>Pilih Barang</option>
            <?php foreach ($barang_masuk as $data) : ?>
              <option value="<?= $data['id'] ?>"><?= $data['nama_barang'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">Jenis Barang Masuk</label>
          <select class="form-control" name="jenis_barang_masuk" id="">
            <option value="0" selected>Pilih Jenis Barang Masuk</option>
            <option value="Barang Return">Barang Return</option>
            <option value="Barang Beli">Barang Beli</option>
          </select>
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">Qty</label>
          <input type="text" name="qty" placeholder="Masukan Qty" class="form-control" required>
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
        e.preventDefault();
        e.stopPropagation();
        myDropzone.processQueue();
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
            window.location = "<?= base_url('dashboard/warehouse-kuningan/stok') ?>";
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