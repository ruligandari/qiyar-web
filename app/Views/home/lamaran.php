<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>Home Lamaran</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- Favicons -->
    
    <link rel="icon" href="<?= base_url('front/') ?>assets/img/logoqiyar.png">
    <link href="<?= base_url('front/')?>assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
      rel="stylesheet"
    />

    <!-- Vendor CSS Files -->
    <link
      href="<?= base_url('front/')?>assets/vendor/bootstrap/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="<?= base_url('front/')?>assets/vendor/bootstrap-icons/bootstrap-icons.css"
      rel="stylesheet"
    />
    <link
      href="<?= base_url('front/')?>assets/vendor/glightbox/css/glightbox.min.css"
      rel="stylesheet"
    />
    <link href="<?= base_url('front/')?>assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />
    <link href="<?= base_url('front/')?>assets/vendor/aos/aos.css" rel="stylesheet" />

    <!-- Template Main CSS File -->
    <link href="<?= base_url('front/')?>assets/css/main.css" rel="stylesheet" />

    <!-- =======================================================
  * Template Name: Append
  * Updated: Jul 27 2023 with Bootstrap v5.3.1
  * Template URL: https://bootstrapmade.com/append-bootstrap-website-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  </head>

  <body
    class="portfolio-details-page"
    data-bs-spy="scroll"
    data-bs-target="#navmenu"
  >
    <!-- ======= Header ======= -->
    <header id="header" class="header sticky-top d-flex align-items-center">
      <div
        class="container-fluid d-flex align-items-center justify-content-between"
      >
        <a
          href="index.html"
          class="logo d-flex align-items-center me-auto me-xl-0"
        >
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <img src="<?= base_url('front/')?>assets/img/logoqiyar.png" alt="" />
          <h1>Qiyar Media</h1>
        </a>

        <!-- Nav Menu -->
        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="<?= base_url('/')?>">Home</a></li>
            <li><a href="<?= base_url('/')?>#about">About</a></li>
            <li><a href="#" class="active">Lamaran</a></li>
            <li><a href="<?= base_url('/')?>#team">Team</a></li>
          </ul>

          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
        <!-- End Nav Menu -->

        <a class="btn-getstarted" href="https://wa.me/6285931946578">Contact</a>
      </div>
    </header>
    <!-- End Header -->

    <main id="main">
      <!-- Portfolio Details Page Title & Breadcrumbs -->
      <div data-aos="fade" class="page-title">
        <div class="heading">
          <div class="container">
            <div class="row d-flex justify-content-center text-center">
              <div class="col-lg-8">
                <h1>Isi Formulir Lamaran</h1>
              </div>
            </div>
          </div>
        </div>
        <nav class="breadcrumbs">
          <div class="container">
            <ol>
              <li><a href="<?= base_url('/')?>">Home</a></li>
              <li class="current">Lamaran</li>
            </ol>
          </div>
        </nav>
      </div>
      <!-- End Page Title -->

      <!-- Portfolio-details Section - Portfolio Details Page -->
      <section id="portfolio-details" class="portfolio-details">
        <div class="container" data-aos="fade-up">
          <form method="POST" action="<?= base_url('dashboard/tambah-lamaran')?>" enctype="multipart/form-data">

            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label"
                >Nama Lengkap <b style="color: red">*</b></label
              >
              <input
                type="text"
                name="nama"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
                required
              />
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label"
                >Email <b style="color: red">*</b></label
              >
              <input
                type="text"
                name="email"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
                required
              />
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label"
                >Nomor Whatsapps <b style="color: red">*</b></label
              >
              <input
                type="text"
                name="nomor"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
                required
              />
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label"
                >Upload CV <b style="color: red">*</b></label
              >
              <input
                type="file"
                name="cv"
                class="form-control"
                aria-label="file example"
                required
              />
              <div class="invalid-feedback">
                Example invalid form file feedback
              </div>
            </div>
            <div class="d-grid gap-2 mt-4">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </section>
      <!-- End Portfolio-details Section -->
    </main>

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
      <div class="container copyright text-center mt-4">
        <p>
          &copy; <span>Copyright</span>
          <strong class="px-1">Qiyar Media</strong>
          <span>All Rights Reserved</span>
        </p>
      </div>
    </footer>
    <!-- End Footer -->

    <!-- Scroll Top Button -->
    <a
      href="#"
      id="scroll-top"
      class="scroll-top d-flex align-items-center justify-content-center"
      ><i class="bi bi-arrow-up-short"></i
    ></a>

    <!-- Preloader -->
    <div id="preloader">
      <div></div>
      <div></div>
      <div></div>
      <div></div>
    </div>

    <!-- Vendor JS Files -->
    <script src="<?= base_url('front/')?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('front/')?>assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="<?= base_url('front/')?>assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="<?= base_url('front/')?>assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="<?= base_url('front/')?>assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="<?= base_url('front/')?>assets/vendor/aos/aos.js"></script>
    <script src="<?= base_url('front/')?>assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="<?= base_url('front/')?>assets/js/main.js"></script>
  </body>
</html>
