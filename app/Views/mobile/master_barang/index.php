<?= $this->extend('mobile/layouts'); ?>

<?= $this->section('content'); ?>

<!-- sweetalert -->

<?php if (session()->getFlashdata('success')) : ?>
    <script>
        Swal.fire(
            'Berhasil!',
            '<?= session()->getFlashdata('success') ?>',
            'success'
        )
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
                <a href="<?= base_url('/stok-opname') ?>">
                    <i class="bi bi-arrow-left-short"></i>
                </a>
            </div>

            <!-- Page Title -->
            <div class="page-heading">
                <h6 class="mb-0"><?= $title ?></h6>
            </div>
            <div class="setting-wrapper">
            </div>
        </div>
    </div>
</div>
<div class="page-content-wrapper py-3">

    <!-- Add New Contact -->
    <div class="add-new-contact-wrap">
        <a class="shadow" href="#" data-bs-toggle="modal" data-bs-target="#addBarang">
            <i class="bi bi-plus-lg"></i>
        </a>
    </div>

    <div id="loader-container" class="container" style="display: none;">
        <div class="card bg-primary">
            <div class="card-body py-5">
                <!-- Dot Loader -->
                <div class="dot-loader">
                    <div class="dot1"></div>
                    <div class="dot2"></div>
                    <div class="dot3"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card mb-2">
            <div class="card-body p-2">
                <div class="chat-search-box">
                    <!-- Search Form -->
                    <form action="<?= base_url('/stok-opname/master-barang') ?>" method="get">
                        <div class="input-group">
                            <span class="input-group-text" id="searchbox">
                                <i class="bi bi-search"></i>
                            </span>
                            <input class="form-control" type="search" placeholder="Cari barang"
                                aria-describedby="searchbox" name="q" value="<?= isset($_GET['q']) ? $_GET['q'] : '' ?>">
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <!-- Chat User List -->
        <ul class="ps-0 chat-user-list">

            <!-- Single Chat User -->
            <?php foreach ($data as $item): ?>
                <li class="p-3 chat-unread">
                    <a class="d-flex" href="#">
                        <!-- Thumbnail -->
                        <!-- <div class="chat-user-thumbnail me-3 shadow">
                        <img class="img-circle" src="img/bg-img/user1.png" alt="">
                        <span class="active-status"></span>
                    </div> -->
                        <!-- Info -->
                        <div class="chat-user-info">
                            <h6 class="text-truncate mb-0"><?= $item['nama_barang'] ?></h6>
                            <div class="last-chat">
                                <p class="mb-0 text-truncate">Stok tersedia:
                                    <span class="badge rounded-pill bg-primary"><?= $item['qty'] ?></span>
                                </p>
                            </div>
                        </div>
                    </a>

                    <!-- Options -->
                    <div class="dropstart chat-options-btn">
                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" onclick="editBarang(<?= $item['id'] ?>)"><i class="bi bi-pencil"></i>Edit</a></li>
                            <li><a href="#" onclick="deleteBarang(<?= $item['id'] ?>)"><i class="bi bi-trash"></i>Hapus</a></li>
                            <li><a href="<?= base_url('stok-opname/master-barang/qr/' . $item['id']) ?>"><i class="bi bi-qr-code"></i>Barcode</a></li>
                        </ul>
                    </div>
                </li>
            <?php endforeach ?>
        </ul>
        <div class="card mt-2">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <?= $pager->links('stok_barang', 'bootstrap_pagination') ?>
                </div>
            </div>
        </div>
        <!-- pager -->
    </div>
</div>

<!-- modal -->
<div class="add-new-contact-modal modal fade px-0" id="addBarang" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="addnewcontactlabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="modal-title" id="addnewcontactlabel">Tambah Barang Baru</h6>
                    <button class="btn btn-close p-1 ms-auto me-0" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <form action="<?= base_url('stok-opname/master-barang/add') ?>" method="POST">
                    <!-- <div class="input-group mb-3">
                        <span class="input-group-text" id="to">To</span>
                        <input class="form-control" type="text" placeholder="" aria-label="Username" aria-describedby="to">
                    </div> -->
                    <div class="form-group">
                        <label class="form-label" for="message">Tanggal</label>
                        <input type="date" class="form-control" id="message" name="tanggal" placeholder="Tanggal" value="<?= date('Y-m-d') ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="message">Nama Barang</label>
                        <input class="form-control" id="message" name="nama_barang" placeholder="Masukan Nama Barang" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="message">Qty</label>
                        <input class="form-control" id="message" name="qty" placeholder="Masukan Qty" required>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- modal edit -->

<div class="add-new-contact-modal modal fade px-0" id="editBarang" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="addnewcontactlabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="modal-title" id="addnewcontactlabel">Tambah Barang Baru</h6>
                    <button class="btn btn-close p-1 ms-auto me-0" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <form action="<?= base_url('stok-opname/master-barang/update') ?>" method="POST">
                    <!-- <div class="input-group mb-3">
                        <span class="input-group-text" id="to">To</span>
                        <input class="form-control" type="text" placeholder="" aria-label="Username" aria-describedby="to">
                    </div> -->
                    <div class="form-group">
                        <label class="form-label" for="message">Tanggal</label>
                        <input type="date" class="form-control" id="message" name="tanggal" placeholder="Tanggal" value="<?= date('Y-m-d') ?>" readonly>
                        <input type="text" name="id" hidden>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="message">Nama Barang</label>
                        <input class="form-control" id="message" name="nama_barang" placeholder="Masukan Nama Barang" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="message">Qty</label>
                        <input class="form-control" id="message" name="qty" placeholder="Masukan Qty" required>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    function deleteBarang(id) {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Anda Akan Menghapus Produk ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('stok-opname/master-barang/delete') ?>',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function() {
                        Swal.fire(
                            'Berhasil!',
                            'Data berhasil dihapus.',
                            'success'
                        ).then(() => {
                            location.reload();
                        })
                    },
                    error: function() {
                        Swal.fire(
                            'Gagal!',
                            'Data gagal dihapus.',
                            'error'
                        )
                    }
                })
            }
        })

    }

    function editBarang(id) {
        // fecth data dengan id menggunakan ajax
        $.ajax({
            url: '<?= base_url('stok-opname/master-barang/edit') ?>',
            type: 'POST',
            data: {
                id: id
            },
            success: function(response) {
                // tampilkan modal dan masukan data ke dalam form
                $('#editBarang').modal('show');
                $('#editBarang input[name="nama_barang"]').val(response.nama_barang);
                $('#editBarang input[name="qty"]').val(response.qty);
                // tanggal
                $('#editBarang input[name="tanggal"]').val(response.tanggal);
                $('#editBarang input[name="id"]').val(response.id);


            },
            error: function() {
                Swal.fire(
                    'Gagal!',
                    'gagal mengambil data',
                    'error'
                )
            }
        })
    }
</script>
<?= $this->endsection(); ?>