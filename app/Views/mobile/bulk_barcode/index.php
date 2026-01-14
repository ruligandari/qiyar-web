<?= $this->extend('mobile/layouts'); ?>

<?= $this->section('content'); ?>

<!-- Header Area -->
<div class="header-area" id="headerArea">
    <div class="container">
        <div class="header-content position-relative d-flex align-items-center justify-content-between">
            <div class="back-button">
                <a href="<?= base_url('stok-opname') ?>">
                    <i class="bi bi-arrow-left-short"></i>
                </a>
            </div>
            <div class="page-heading">
                <h6 class="mb-0"><?= $title ?></h6>
            </div>
            <div class="setting-wrapper"></div>
        </div>
    </div>
</div>

<div class="page-content-wrapper py-3">
    <div class="container">
        <form action="<?= base_url('stok-opname/bulk-barcode/print') ?>" method="POST" id="msgForm" target="_blank">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                            <label class="form-check-label" for="selectAll">Pilih Semua</label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-printer"></i> Generate
                        </button>
                    </div>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <div class="list-group">
                        <?php foreach ($products as $p): ?>
                            <label class="list-group-item d-flex gap-3">
                                <input class="form-check-input flex-shrink-0" type="checkbox" name="selected_ids[]" value="<?= $p['id'] ?>">
                                <span>
                                    <?= esc($p['nama_barang']) ?>
                                    <small class="d-block text-muted">Stok: <?= esc($p['qty']) ?></small>
                                </span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endsection(); ?>

<?= $this->section('script'); ?>
<script>
    document.getElementById('selectAll').addEventListener('change', function() {
        var checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    });
</script>
<?= $this->endsection(); ?>
