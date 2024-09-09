<?= $this->extend('mobile/layouts'); ?>

<?= $this->section('content'); ?>

<!-- sweetalert -->

<?php if (session()->getFlashdata('success')) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '<?= session()->getFlashdata('success') ?>',
        })
    </script>
<?php elseif (session()->getFlashdata('error')) : ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '<?= session()->getFlashdata('error') ?>',
            showConfirmButton: false,
        })
    </script>
<?php endif; ?>
<!-- Header Area -->
<div class="header-area" id="headerArea">
    <div class="container">
        <!-- Header Content -->
        <div class="header-content position-relative d-flex align-items-center justify-content-between">
            <!-- Back Button -->
            <div class="back-button">
                <a href="<?= base_url('/stok-opname/master-barang') ?>">
                    <i class="bi bi-arrow-left-short"></i>
                </a>
            </div>

            <!-- Page Title -->
            <div class="page-heading">
                <h6 class="mb-0"><?= $title . ' ' . $barang ?></h6>
            </div>
            <div class="setting-wrapper">
            </div>
        </div>
    </div>
</div>
<div class="page-content-wrapper py-3">
    <div class="container">
        <!-- User Meta Data-->
        <div class="card user-data-card">
            <div class="card-body">
                <!-- tampilkan image qrcode yang telah tersimpan -->
                <div id="qrcode-container" class="text-center">
                    <!-- Tampilkan satu gambar QR code -->
                    <img id="qrcode-image" src="<?= base_url($fileQr) ?>" alt="QR Code" class="img-fluid">
                </div>
                <button id="download-btn" class="btn btn-primary w-100" type="button">Download PDF</button>
            </div>
        </div>
    </div>
    <div class="pb-3"></div>
</div>


<?= $this->endsection(); ?>

<?= $this->section('script'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
<script>
    var nama_barang = '<?= $barang ?>';
    document.getElementById('download-btn').addEventListener('click', function() {
        const {
            jsPDF
        } = window.jspdf;
        const doc = new jsPDF('p', 'mm', 'a4');

        const imgSrc = document.getElementById('qrcode-image').src;
        const numQRCodePerRow = 5; // Jumlah QR code per baris
        const numQRCodePerCol = 7; // Jumlah QR code per kolom
        const qrCodeWidth = 28; // Lebar QR code dalam mm
        const qrCodeHeight = 28; // Tinggi QR code dalam mm
        const margin = 10; // Margin di halaman dalam mm

        let x = margin;
        let y = margin;

        for (let i = 0; i < 35; i++) {
            // Tambahkan QR code ke halaman PDF
            doc.addImage(imgSrc, 'PNG', x, y, qrCodeWidth, qrCodeHeight);

            // Tambahkan teks nama barang di bawah QR code
            doc.setFontSize(8);
            doc.text(nama_barang, x + qrCodeWidth / 2, y + qrCodeHeight + 2, {
                align: 'center'
            });

            // Update posisi untuk QR code berikutnya
            x += qrCodeWidth + margin;

            // Jika sudah mencapai batas kanan halaman, pindah ke baris berikutnya
            if ((i + 1) % numQRCodePerRow === 0) {
                x = margin; // Kembali ke kiri
                y += qrCodeHeight + margin + 10; // Pindah ke baris berikutnya, dengan tambahan jarak untuk teks
            }
        }

        // Download PDF
        doc.save('qrcodes.pdf');
    });
</script>

<?= $this->endsection(); ?>