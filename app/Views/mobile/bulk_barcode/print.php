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
                <!-- Generate Barcode using bwip-js API -->
                <img src="https://bwipjs-api.metafloor.com/?bcid=code128&text=<?= $p['id'] ?>&scale=3&includetext" alt="Barcode <?= $p['id'] ?>">
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
