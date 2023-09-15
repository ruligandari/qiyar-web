$(function() {

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('input[name="datesBarangMasuk"]').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#datesBarangMasuk').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Semua': [moment().subtract(1, 'years'), moment()],
                'Hari Ini': [moment(), moment()],
                'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

    });

    var urlTable = $('#urlBarangMasuk').val();
    var urlDelete = $('#urlDelete').val();
console.log(urlDelete);
console.log(urlTable);

    $(document).ready(function() {
        let table = $('#table1').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: urlTable,
                method: 'POST',
                data: function(d) {
                    d.dates = $('input[name="datesBarangMasuk"]').val();
                },
            },
            dom: '<"button-container"lBfrtip>',
            buttons: [{
                    extend: 'excelHtml5',
                    footer: true,
                    title: 'Data Barang Masuk - ' + formattedDate,
                    exportOptions: {
                        columns: [0, 1, 2, 3],
                    },
                    className: 'mb-2',
                    // ubah nama file ketika di download

                },
                {
                    extend: 'pdfHtml5',
                    footer: true,
                    title: 'Data Barang Masuk - ' + formattedDate,
                    exportOptions: {
                        columns: [0, 1, 2, 3],
                    },
                    className: 'mb-2',
                }
            ],
            columns: [{
                    data: 'no',
                    orderable: false
                },
                {
                    data: 'tanggal'
                },
                {
                    data: 'nama_barang'
                },
                {
                    data: 'qty'
                },
                {
                    data: 'action'
                },
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'Semua']
            ], // Pilihan jumlah data per halaman, termasuk "Semua"
            pageLength: 10,
            order: [],
            columnDefs: [{
                targets: -1,
                orderable: false
            }, ],
            initComplete: function() {
                // Fungsi untuk menghitung jumlah total kolom "jumlah"
                function sumColumn() {
                    let columnData = table.column(3, { search: 'applied' }).data();
                    
                    // Check if columnData is defined and not empty
                    if (columnData && columnData.length > 0) {
                        let sum = columnData.reduce(function(acc, curr) {
                            let numericValue = parseFloat(curr.replace(/\./g, '').replace(',', '.')); // Parse angka
                            return acc + numericValue;
                        }, 0);
                
                        // Format jumlah total sebagai mata uang Indonesia
                        let formattedSum = sum.toLocaleString('id-ID', {
                            minimumFractionDigits: 0, // Atur ini ke 0 untuk menghilangkan angka di belakang koma
                            maximumFractionDigits: 2
                        });
                
                        // Tampilkan jumlah total di elemen HTML dengan ID "totalSum"
                        $('#totalSum').html(formattedSum);
                    } else {
                        // If columnData is undefined or empty, display a default value
                        $('#totalSum').html('0');
                    }
                }
                

                // Panggil fungsi sumColumn saat tabel selesai dimuat
                sumColumn();

                // Panggil fungsi sumColumn lagi ketika tabel di-filter atau di-sort
                table.on('search.dt draw.dt', sumColumn);
            },
        });

        $('#datesBarangMasuk').change(function(event) {
            table.ajax.reload();
        });

    });

    let currentDate = new Date();
    let formattedDate = currentDate.toISOString().split('T')[0];

    function deleteJktMasuk(id) {
        Swal.fire({
            title: "Apakah Anda yakin akan menghapus data ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Tidak, batalkan!",
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim permintaan hapus menggunakan Ajax
                $.ajax({
                    method: "POST",
                    url: urlDelete,
                    data: {
                        id: id
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.success) {
                            Swal.fire(
                                "Dihapus!",
                                "Data Berhasil Dihapus",
                                "success"
                            ).then(() => {
                                // Muat ulang halaman setelah penghapusan
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                "Error!",
                                "Gagal menghapus data.",
                                "error"
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            "Error!",
                            "Terjadi kesalahan saat menghapus data.",
                            "error"
                        );
                    },
                });
            }
        });
    }