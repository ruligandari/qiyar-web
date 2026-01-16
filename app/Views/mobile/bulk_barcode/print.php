<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Barcode</title>
    <style>
        body { font-family: sans-serif; }
        .grid { display: flex; flex-wrap: wrap; gap: 20px; text-align: center; }
        .item { border: 1px dashed #ccc; padding: 10px; width: 220px; page-break-inside: avoid; }
        .name { font-size: 14px; margin-bottom: 5px; font-weight: bold; }
        img { max-width: 100%; height: auto; }
        @media print {
            .no-print { display: none; }
        }
        .qrcode {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">Cetak (Ctrl+P)</button>
        <button onclick="window.close()" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">Tutup</button>
    </div>

    <div class="grid">
        <?php foreach ($products as $p): ?>
            <div class="item">
                <div class="name"><?= esc($p['nama_barang']) ?></div>
                
                <?php if($type == 'qrcode'): ?>
                    <!-- QR Code Container -->
                    <div class="qrcode" data-text="<?= $p['id'] ?>"></div>
                <?php else: ?>
                    <!-- Barcode Container -->
                    <svg class="barcode" 
                        jsbarcode-format="code128" 
                        jsbarcode-value="<?= $p['id'] ?>" 
                        jsbarcode-width="2" 
                        jsbarcode-height="50" 
                        jsbarcode-fontSize="14"
                    ></svg>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if($type == 'qrcode'): ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        // Init QR Codes
        var qrcodes = document.querySelectorAll('.qrcode');
        qrcodes.forEach(function(el) {
            var text = el.getAttribute('data-text');
            new QRCode(el, {
                text: text,
                width: 100,
                height: 100
            });
        });
    </script>
    <?php else: ?>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
    <script>
        // Init Barcodes
        JsBarcode(".barcode").init();
    </script>
    <?php endif; ?>
</body>
</html>
