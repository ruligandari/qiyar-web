<!-- menambahkan template/template.php -->
<?= $this->extend('template/template'); ?>

<!-- menambahkan section -->
<?= $this->section('content'); ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Advertiser</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>
     <!-- DataTales Example -->
     <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="">
                                <div class="d-sm-flex align-items-center justify-content-between"><h6 class=" font-weight-bold text-primary">Data Advertiser</h6>
                            <a href="<?=base_url('dashboard/tambah-data-advertiser')?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data</a></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Nama Advertiser</th>
                                            <th>Nama Produk</th>
                                            <th>Jumlah Pengiriman</th>
                                            <th>Total Harga</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $no = 1;
                                      foreach($advertiser as $data):
                                    ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <td><?=$data['tanggal_pembelian']?></td>
                                        <td><?=$data['nama_advertiser']?></td>
                                        <td><?=$data['nama_produk']?></td>
                                        <td><?=$data['jumlah_pengiriman']?></td>
                                        <td><?=$data['total_harga']?></td>
                                        <td class="text-center"><a class="btn btn-success" title="Edit Bray"
                                    href="<?=base_url('admin/tambahprodukadmin/edit').'/'.$data['id_advertiser']?>"
                                    role="button"
                                    ><i class="fas fa-sm fa-pen"></i></a
                                    > <a
                                    class="btn btn-danger" title="Hapus Bray"
                                    href="<?=base_url('admin/tambahprodukadmin/delete').'/'.$data['id_advertiser']?>"
                                    role="button"
                                    ><i class="fas fa-sm fa-trash"></i></i></a
                                    ></td>
                                    </tr>
                    <?php 
              endforeach
              ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

</div>
<?= $this->endSection(); ?>