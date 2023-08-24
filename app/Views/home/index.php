<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>Home - Qiyar Media</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- Favicons -->
    <link href="<?= base_url('front/') ?>assets/img/apple-touch-icon.png" rel="apple-touch-icon" />
    <link rel="icon" href="<?= base_url('front/') ?>assets/img/logoqiyar.png">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet" />

    <!-- Vendor CSS Files -->
    <link href="<?= base_url('front/') ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= base_url('front/') ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="<?= base_url('front/') ?>assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
    <link href="<?= base_url('front/') ?>assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />
    <link href="<?= base_url('front/') ?>assets/vendor/aos/aos.css" rel="stylesheet" />

    <!-- Template Main CSS File -->
    <link href="<?= base_url('front/') ?>assets/css/main.css" rel="stylesheet" />

    <!-- =======================================================
  * Template Name: Append
  * Updated: Jul 27 2023 with Bootstrap v5.3.1
  * Template URL: https://bootstrapmade.com/append-bootstrap-website-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page" data-bs-spy="scroll" data-bs-target="#navmenu">
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <img src="<?= base_url('front/') ?>assets/img/logoqiyar.png" alt="" />
                <h1>Qiyar Media</h1>
            </a>

            <!-- Nav Menu -->
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="<?= base_url('lamaran') ?>">Lamaran</a></li>
                    <li><a href="#team">Team</a></li>
                </ul>

                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
            <!-- End Nav Menu -->

            <a class="btn-getstarted" href="https://wa.me/6285931946578">Contact</a>
        </div>
    </header>
    <!-- End Header -->

    <main id="main">
        <!-- Hero Section - Home Page -->
        <section id="hero" class="hero">
            <img src="<?= base_url('front/') ?>assets/img/background.jpeg" alt="" data-aos="fade-in" />

            <div class="container">
                <div class="row">
                    <div class="col-lg-10">
                        <h2 data-aos="fade-up" data-aos-delay="100" style="font-size: 60px; font-weight: bold">
                            CV. QIYAR MEDIA
                        </h2>
                        <p data-aos="fade-up" data-aos-delay="200" style="font-size: 40px; font-weight: bold">
                            Bersatu Maju
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Hero Section -->

        <!-- Clients Section - Home Page -->
        <section id="clients" class="clients">
            <div class="container-fluid" data-aos="fade-up">
                <div class="row gy-4 justify-content-center">
                    <div class="col-xl-2 col-md-3 col-6 client-logo">
                        <img src="<?= base_url('front/')?>assets/img/sicepat.png" class="img-fluid" alt="" />
                    </div>
                    <!-- End Client Item -->

                    <div class="col-xl-2 col-md-3 col-6 client-logo">
                        <img src="<?= base_url('front/')?>assets/img/ninjaexpress.png" class="img-fluid" alt="" />
                    </div>
                    <!-- End Client Item -->

                    <div class="col-xl-2 col-md-3 col-6 client-logo">
                        <img src="<?= base_url('front/')?>assets/img/oexpress.png" class="img-fluid" alt="" />
                    </div>
                    <!-- End Client Item -->
                </div>
            </div>
        </section>
        <!-- End Clients Section -->

        <!-- About Section - Home Page -->
        <section id="about" class="about">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row align-items-xl-center gy-5">
                    <div class="col-xl-5 content">
                        <h3>About Us</h3>
                        <h2>Qiyar Media</h2>
                        <p>
                            Kami bergerak dibidang Digital Marketing, Kami bertekad untuk
                            menghadirkan inovasi terkini dalam dunia digital marketing untuk
                            membantu bisnis Anda berkembang
                        </p>
                    </div>

                    <div class="col-xl-7">
                        <div class="row gy-4 icon-boxes">
                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                                <div class="icon-box">
                                    <i class="bi bi-buildings"></i>
                                    <h3>Membangun kesuksesan bersama</h3>
                                    <p>
                                        Kami percaya bahwa kesuksesan bisnis adalah bekerja keras
                                        untuk membangun kemitraan yang kuat
                                    </p>
                                </div>
                            </div>
                            <!-- End Icon Box -->

                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                                <div class="icon-box">
                                    <i class="bi bi-clipboard-pulse"></i>
                                    <h3>Ahli dalam dunia digital</h3>
                                    <p>
                                        Team kami terdiri dari ahli-ahli digital marketing yang
                                        berpengalaman dalam berbagai industri.
                                    </p>
                                </div>
                            </div>
                            <!-- End Icon Box -->

                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
                                <div class="icon-box">
                                    <i class="bi bi-command"></i>
                                    <h3>Berkomitmen pada keunggulan</h3>
                                    <p>
                                        Kami selalu berusaha untuk memberikan layanan berkualitas
                                        tinggi dan hasil yang luar biasa.
                                    </p>
                                </div>
                            </div>
                            <!-- End Icon Box -->

                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="500">
                                <div class="icon-box">
                                    <i class="bi bi-graph-up-arrow"></i>
                                    <h3>Percayakan Kami</h3>
                                    <p>
                                        Ribuan client telah mempercayakan kami untuk mengelola
                                        kehadiran mereka didunia digital, dan kami siap untuk
                                        membantu anda
                                    </p>
                                </div>
                            </div>
                            <!-- End Icon Box -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End About Section -->

        <!-- Stats Section - Home Page -->
        <section id="stats" class="stats">
            <img src="<?= base_url('front/') ?>assets/img/stats-bg.jpg" alt="" data-aos="fade-in" />

            <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
                <div class="row gy-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="232" data-purecounter-duration="1" class="purecounter"></span>
                            <p>Clients</p>
                        </div>
                    </div>
                    <!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="521" data-purecounter-duration="1" class="purecounter"></span>
                            <p>Projects</p>
                        </div>
                    </div>
                    <!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="1453" data-purecounter-duration="1" class="purecounter"></span>
                            <p>Hours Of Support</p>
                        </div>
                    </div>
                    <!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="32" data-purecounter-duration="1" class="purecounter"></span>
                            <p>Workers</p>
                        </div>
                    </div>
                    <!-- End Stats Item -->
                </div>
            </div>
        </section>
        <!-- End Stats Section -->

        <!-- Team Section - Home Page -->
        <section id="team" class="team">
            <!--  Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Team</h2>
            </div>
            <!-- End Section Title -->

            <div class="container">
                <div class="row gy-5">
                    <div class="col-lg-4 col-md-6 member" data-aos="fade-up" data-aos-delay="100">
                        <div class="member-img">
                            <img src="<?= base_url('front/') ?>assets/img/zaka.JPG" class="img-fluid" alt="" />
                            <div class="social">
                                <a href="#"><i class="bi bi-twitter"></i></a>
                                <a href="#"><i class="bi bi-facebook"></i></a>
                                <a href="#"><i class="bi bi-instagram"></i></a>
                                <a href="#"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info text-center">
                            <h4>Zaka Juana</h4>
                            <span>Manajer Advertiser</span>
                        </div>
                    </div>
                    <!-- End Team Member -->

                    <div class="col-lg-4 col-md-6 member" data-aos="fade-up" data-aos-delay="200">
                        <div class="member-img">
                            <img src="<?= base_url('front/') ?>assets/img/aumry.jpeg" class="img-fluid" alt="" />
                            <div class="social">
                                <a href="#"><i class="bi bi-twitter"></i></a>
                                <a href="#"><i class="bi bi-facebook"></i></a>
                                <a href="#"><i class="bi bi-instagram"></i></a>
                                <a href="#"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info text-center">
                            <h4>Umri Nurdani</h4>
                            <span>Co Founder</span>
                        </div>
                    </div>
                    <!-- End Team Member -->

                    <div class="col-lg-4 col-md-6 member" data-aos="fade-up" data-aos-delay="300">
                        <div class="member-img">
                            <img src="<?= base_url('front/') ?>assets/img/sahrul.JPG" class="img-fluid" alt="" />
                            <div class="social">
                                <a href="#"><i class="bi bi-twitter"></i></a>
                                <a href="#"><i class="bi bi-facebook"></i></a>
                                <a href="#"><i class="bi bi-instagram"></i></a>
                                <a href="#"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info text-center">
                            <h4>Sahrul Nur Kholis</h4>
                            <span>Manajer Broadcast</span>
                        </div>
                    </div>
                    <!-- End Team Member -->
                </div>
            </div>
            <div class="d-grid gap-1 col-2 mx-auto justify-content-center mt-5" data-aos="fade-up" data-aos-delay="400">
                <button type="button" class="btn btn-primary">
                    <b>Baca Selengkapnya</b>
                </button>
            </div>
        </section>
        <!-- End Team Section -->
    </main>
    <!-- Scroll Top Button -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>

    <!-- Vendor JS Files -->
    <script src="<?= base_url('front/') ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('front/') ?>assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="<?= base_url('front/') ?>assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="<?= base_url('front/') ?>assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="<?= base_url('front/') ?>assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="<?= base_url('front/') ?>assets/vendor/aos/aos.js"></script>
    <script src="<?= base_url('front/') ?>assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="<?= base_url('front/') ?>assets/js/main.js"></script>
</body>

</html>