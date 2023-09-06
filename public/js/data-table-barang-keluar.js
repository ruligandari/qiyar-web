let minDateKeluar, maxDateKeluar;
 
// Custom filtering function which will search data in column four between two values
DataTable.ext.search.push(function (settings, data, dataIndex) {
    let minKeluar = minDateKeluar.val();
    let maxkeluar = maxDateKeluar.val();
    let date = new Date(data[1]);
 
    if (
        (minKeluar === null && maxkeluar === null) ||
        (minKeluar === null && date <= maxkeluar) ||
        (minKeluar <= date && maxkeluar === null) ||
        (minKeluar <= date && date <= maxkeluar)
    ) {
        return true;
    }
    return false;
});
 
// Create date inputs
minDateKeluar = new DateTime('#minKeluar', {
    format: 'MMMM Do YYYY'
});
maxDateKeluar = new DateTime('#maxKeluar', {
    format: 'MMMM Do YYYY'
});

$(document).ready(function() {
    // DataTables initialisation for example2
    let table2 = $('#example2').DataTable({
        dom: 'Bfrtip',
        buttons: [{
                extend: 'excelHtml5',
                footer: true,
                title: 'Data Pengeluaran Advertiser',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6]
                },
                className: 'mb-2',
                // ubah nama file ketika di download
            },
            {
                extend: 'pdfHtml5',
                footer: true,
                title: 'Data Pengeluaran Advertiser',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6]
                },
                className: 'mb-2',
            }
        ],
    });
    function sumColumnQty(table2) {
        let sum = table2.column(3, {
            search: 'applied'
        }).data().reduce(function(acc, curr) {
            let numericValue = parseFloat(curr.replace(/\./g, '').replace(',', '.')); // Parse the formatted number
            return acc + numericValue;
        }, 0);

        // format the sum as number ex: 10000 to 10.000
        let formattedSum = sum.toLocaleString('id-ID', {
            minimumFractionDigits: 0, // Set this to 0 to remove trailing zeros
            maximumFractionDigits: 2
        });
        // Display the formatted sum
        table2.table().footer().querySelector('#totalQty').innerHTML = formattedSum;
    }
    function sumColumnResi(table2) {
        let sum = table2.column(4, {
            search: 'applied'
        }).data().reduce(function(acc, curr) {
            let numericValue = parseFloat(curr.replace(/\./g, '').replace(',', '.')); // Parse the formatted number
            return acc + numericValue;
        }, 0);

        // format the sum as number ex: 10000 to 10.000
        let formattedSum = sum.toLocaleString('id-ID', {
            minimumFractionDigits: 0, // Set this to 0 to remove trailing zeros
            maximumFractionDigits: 2
        });
        // Display the formatted sum
        table2.table().footer().querySelector('#totalResi').innerHTML = formattedSum;
    }
    // Call sumColumn when searching/filtering is applied for example2
    table2.on('search.dt', function() {
        sumColumnQty(table2);
        sumColumnResi(table2);
    });
    sumColumnQty(table2);
    sumColumnResi(table2);

    // Move buttons container for example2
    table2.buttons().container()
        .appendTo('#example2_wrapper .col-md-6:eq(0)');
    // Move buttons container for example2

    // Refilter the table and recalculate the sum for example2
    document.querySelectorAll('#minKeluar, #maxKeluar').forEach((el) => {
        el.addEventListener('change', () => {
            table2.draw();
            sumColumnQty(table2);
            sumColumnResi(table2);
        });
    });

});
