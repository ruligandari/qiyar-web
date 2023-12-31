<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Login</title>

  <!-- Custom fonts for this template-->
  <link rel="icon" href="<?= base_url('front/') ?>assets/img/logoqiyar.png">
  <link href="<?= base_url('/') ?>plugin/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<style>
  .body {
    background-image: url('<?= base_url('/') . 'front/assets/img/backgroundlogin.JPG' ?>');
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: 100% 100%;
  }
</style>

<body class="body">
  <?php if (session()->getFlashdata('success')) : ?>
    <script>
      Swal.fire({
        position: 'center',
        icon: 'success',
        text: 'Selamat Datang, <?= session()->get('nama') ?>',
        showConfirmButton: false,
        timer: 2000
      }).then(function() {

        window.location = "<?= base_url('dashboard') ?>";

      });
    </script>
  <?php endif ?>
  <?php if (session()->getFlashdata('gagal')) : ?>
    <script>
      Swal.fire({
        position: 'center',
        icon: 'error',
        text: '<?= session()->getFlashdata('gagal') ?>',
        showConfirmButton: false,
        timer: 2000
      });
    </script>
  <?php endif ?>
  <?php if (session()->getFlashdata('loged')) : ?>
    <script>
      Swal.fire({
        title: "Anda Sudah Login, Login Kembali Untuk Memulai",
        icon: "warning",
        showCancelButton: false,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya",
      }).then((result) => {
        if (result.isConfirmed) {
          // Kirim permintaan hapus menggunakan Ajax
          $.ajax({
            type: "POST",
            url: "<?= base_url('logout-session') ?>", // Ganti dengan URL tindakan penghapusan di Controller Anda
            success: function(response) {
              var data = JSON.parse(response);
              if (data.success) {
                Swal.fire(
                  "Sukses!",
                  'Silahkan Login Kembali !',
                  "success"
                ).then(() => {
                  // Muat ulang halaman setelah penghapusan
                  location.reload();
                });
              } else {
                Swal.fire(
                  "Error!",
                  data.msg,
                  "error"
                );
              }
            },
            error: function() {
              Swal.fire(
                "Error!",
                "An error occurred while deleting the item.",
                "error"
              );
            },
          });
        }
      });
    </script>
  <?php endif ?>
  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-6 col-lg-6 col-md-6">
        <br><br><br>
        <div class="card o-hidden border-0 shadow-lg mt-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <img src="<?= base_url('front/assets/img/logoqiyar.png') ?>" style="width: 100px" alt="">
                    <h1 class="h4 text-gray-900 mb-4">Selamat Datang, <br>Silahkan Login untuk masuk !</h1>
                  </div>
                  <form class="user" action="<?= base_url('auth') ?>" method="POST">
                    <? csrf_hash() ?>
                    <div class="form-group">
                      <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" id="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                    </div>
                    <div class="form-group">

                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="showPassword">
                        <label class="form-check-label" for="showPassword">Lihat Kata Sandi</label>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Login
                    </button>
                    <hr>

                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url('/') ?>plugin/jquery/jquery.min.js"></script>
  <script src="<?= base_url('/') ?>plugin/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url('/') ?>plugin/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url('/') ?>js/sb-admin-2.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const passwordInput = document.getElementById("password");
      const showPasswordCheckbox = document.getElementById("showPassword");

      showPasswordCheckbox.addEventListener("change", function() {
        if (showPasswordCheckbox.checked) {
          passwordInput.type = "text";
        } else {
          passwordInput.type = "password";
        }
      });
    });
  </script>


</body>

</html>