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
        <!-- Search (Client Side) -->
        <div class="card mb-3">
            <div class="card-body p-2">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input class="form-control" type="text" id="liveSearch" placeholder="Cari barang (Live)...">
                </div>
            </div>
        </div>

        <form action="<?= base_url('stok-opname/bulk-barcode/print') ?>" method="POST" id="msgForm" target="_blank">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                            <label class="form-check-label" for="selectAll">Pilih Semua</label>
                        </div>
                        <div class="">
                            <button type="submit" name="type" value="barcode" class="btn btn-primary btn-sm me-1">
                                <i class="bi bi-upc-scan"></i> Barcode
                            </button>
                            <button type="submit" name="type" value="qrcode" class="btn btn-dark btn-sm">
                                <i class="bi bi-qr-code"></i> QR Code
                            </button>
                        </div>
                    </div>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <div class="list-group" id="productList">
                        <?php if(empty($products)): ?>
                            <div class="text-center p-3 text-muted">Tidak ada data.</div>
                        <?php else: ?>
                            <?php foreach ($products as $p): ?>
                                <div class="list-group-item d-flex align-items-center justify-content-between p-2 searchable-item" data-filter="<?= strtolower($p['nama_barang']) ?>">
                                    <div class="d-flex align-items-center gap-3" style="flex: 1;">
                                        <input class="form-check-input flex-shrink-0 item-checkbox" type="checkbox" name="selected_ids[]" value="<?= $p['id'] ?>" id="chk-<?= $p['id'] ?>">
                                        <label class="form-check-label w-100" for="chk-<?= $p['id'] ?>">
                                            <span class="fw-bold"><?= esc($p['nama_barang']) ?></span>
                                            <small class="d-block text-muted">Sisa Stok: <?= esc($p['qty']) ?></small>
                                        </label>
                                    </div>
                                    <div class="qty-wrapper" style="width: 80px;">
                                        <input type="number" class="form-control form-control-sm text-center" name="qty[<?= $p['id'] ?>]" value="1" min="1" placeholder="Jml">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endsection(); ?>

<?= $this->section('script'); ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    console.log("Bulk Barcode Script: Init");

    document.addEventListener("DOMContentLoaded", function() {
        console.log("Bulk Barcode Script: DOMReady");

        // Live Search Logic
        var searchInput = document.getElementById('liveSearch');
        var items = document.querySelectorAll('.searchable-item');
        
        console.log("Search Input Element:", searchInput);
        console.log("Total Items:", items.length);

        if(searchInput) {
            let debounceTimeout = null;
            searchInput.addEventListener('keyup', function() {
                // Clear previous timeout (Debounce Logic)
                clearTimeout(debounceTimeout);

                var inputVal = this.value.toLowerCase();
                    
                // Set new timeout (300ms delay)
                debounceTimeout = setTimeout(function() {
                    console.log("Search Filtering (Debounced):", inputVal);
                    var visibleCount = 0;
                    items.forEach(function(item) {
                        var text = item.getAttribute('data-filter');
                        
                        if (text && text.indexOf(inputVal) > -1) {
                            // SHOW ITEM
                            item.classList.remove('d-none');
                            item.classList.add('d-flex');
                            visibleCount++;
                        } else {
                            // HIDE ITEM
                            item.classList.add('d-none');
                            item.classList.remove('d-flex');
                        }
                    });
                    console.log("Visible Items:", visibleCount);
                }, 300);
            });
        } else {
            console.error("Critical: #liveSearch input not found in DOM!");
            alert("Error: Search input ID not found. Check console.");
        }

        // Select All Logic
        var selectAll = document.getElementById('selectAll');
        if(selectAll) {
            selectAll.addEventListener('change', function() {
                console.log("Select All Toggled:", this.checked);
                var isChecked = this.checked;
                var checkboxes = document.querySelectorAll('.item-checkbox'); 
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = isChecked;
                    updateRowStyle(checkbox); // Update style
                });
                reorderList(); // Sort after bulk change
            });
        }

        // Individual Checkbox Logic (Style & Sort)
        var checkboxes = document.querySelectorAll('.item-checkbox');
        checkboxes.forEach(function(checkbox) {
            // Apply initial style
            updateRowStyle(checkbox);

            checkbox.addEventListener('change', function() {
                updateRowStyle(this);
                reorderList();
            });
        });

        // Function to update row highlight
        function updateRowStyle(checkbox) {
            var row = checkbox.closest('.list-group-item');
            if(checkbox.checked) {
                row.classList.add('bg-success-subtle'); // Bootstrap 5 class
                row.classList.add('border-success');
            } else {
                row.classList.remove('bg-success-subtle');
                row.classList.remove('border-success');
            }
        }

        // Function to move checked items to top
        function reorderList() {
            var list = document.getElementById('productList');
            var items = Array.from(list.children);
            
            // Sort: Checked first, then by original text (optional, but keeping it stable is better)
            // Currently just moving checked to top
            
            var fragment = document.createDocumentFragment();
            
            // 1. Get Checked Items
            var checkedItems = items.filter(item => item.querySelector('.item-checkbox').checked);
            // 2. Get Unchecked Items
            var uncheckedItems = items.filter(item => !item.querySelector('.item-checkbox').checked);

            // Re-append in order
            checkedItems.forEach(item => fragment.appendChild(item));
            uncheckedItems.forEach(item => fragment.appendChild(item));
            
            list.appendChild(fragment);
        }
    });
</script>
<?= $this->endsection(); ?>
