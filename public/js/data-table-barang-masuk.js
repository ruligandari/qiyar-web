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
                title: 'Data Barang Warehouse Kuningan',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                },
                className: 'mb-2',
                // ubah nama file ketika di download
            },
            {
                extend: 'pdfHtml5',
                footer: true,
                title: 'Data Pengeluaran Advertiser',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                },
                className: 'mb-2',
            }
        ],
    });

    // Sum the "jumlah" column for example1
    function sumColumn(table1) {
        let sum = table1.column(3, {
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
        table1.table().footer().querySelector('#totalSum').innerHTML = formattedSum;
    }

    // Call sumColumn when searching/filtering is applied for example1
    table1.on('search.dt', function() {
        sumColumn(table1);
    });

    // Initial sum when the page loads for example1
    sumColumn(table1);

    // Move buttons container for example1
    table1.buttons().container()
        .appendTo('#example1_wrapper .col-md-6:eq(0)');

    // Refilter the table and recalculate the sum for example1
    document.querySelectorAll('#min, #max').forEach((el) => {
        el.addEventListener('change', () => {
            table1.draw();
            sumColumn(table1);
        });
    });


});
