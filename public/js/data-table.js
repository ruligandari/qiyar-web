let minDate, maxDate;


// Custom filtering function which will search data in column four between two values
DataTable.ext.search.push(function(settings, data, dataIndex) {
    let min = minDate.val();
    let max = maxDate.val();
    let date = new Date(data[1]);

    if (
        (min === null && max === null) ||
        (min === null && date <= max) ||
        (min <= date && max === null) ||
        (min <= date && date <= max)
    ) {
        // Jika data sesuai dengan kriteria filter
        return true;
    }
    return false;
});

// Create date inputs
minDate = new DateTime('#min', {
    format: 'MMMM Do YYYY'
});
maxDate = new DateTime('#max', {
    format: 'MMMM Do YYYY'
});

$(document).ready(function() {
    // DataTables initialisation for example1
    let table1 = $('#example1').DataTable({
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

    // // Sum the "jumlah" column for example1
    // function sumColumn(table) {
    //     let sum = table.column(6, {
    //         search: 'applied'
    //     }).data().reduce(function(acc, curr) {
    //         let numericValue = parseFloat(curr.replace(/\./g, '').replace(',', '.')); // Parse the formatted number
    //         return acc + numericValue;
    //     }, 0);

    //     // Format the sum as Indonesian currency
    //     let formattedSum = sum.toLocaleString('id-ID', {
    //         style: 'currency',
    //         currency: 'IDR',
    //         minimumFractionDigits: 0, // Set this to 0 to remove trailing zeros
    //         maximumFractionDigits: 2
    //     });

    //     // Display the formatted sum
    //     table.table().footer().querySelector('#totalSum').innerHTML = formattedSum;
    // }

    // // Call sumColumn when searching/filtering is applied for example1
    // table1.on('search.dt', function() {
    // });

    // // Initial sum when the page loads for example1
    // sumColumn(table1);

    // Call sumColumn when searching/filtering is applied for example2
    table2.on('search.dt', function() {
        sumColumn(table2);
    });

    // Initial sum when the page loads for example2
    sumColumn(table2);

    // Move buttons container for example1
    table1.buttons().container()
        .appendTo('#example1_wrapper .col-md-6:eq(0)');

    // Move buttons container for example2
    table2.buttons().container()
        .appendTo('#example2_wrapper .col-md-6:eq(0)');

    // Refilter the table and recalculate the sum for example1
    document.querySelectorAll('#min, #max').forEach((el) => {
        el.addEventListener('change', () => {
            table1.draw();
            sumColumn(table1);
        });
    });

    // Refilter the table and recalculate the sum for example2
    document.querySelectorAll('#min, #max').forEach((el) => {
        el.addEventListener('change', () => {
            table2.draw();
            sumColumn(table2);
        });
    });

});
