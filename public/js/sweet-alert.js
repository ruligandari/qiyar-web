// warehouse kuningan

   // Tangkap semua elemen dengan class delete-button
   const deleteButtons = document.querySelectorAll(".delete-button-kng");

   deleteButtons.forEach((button) => {
       button.addEventListener("click", function() {
           const id = this.getAttribute("data-id");
           const url_del = this.getAttribute("data-url");

           Swal.fire({
               title: "Apakah Anda yakin akan menghapus produk ini?",
               icon: "warning",
               showCancelButton: true,
               confirmButtonColor: "#3085d6",
               cancelButtonColor: "#d33",
               confirmButtonText: "Ya, hapus!",
               cancelButtonText: "Gak Jadi Ah!",
           }).then((result) => {
               if (result.isConfirmed) {
                   // Kirim permintaan hapus menggunakan Ajax
                   $.ajax({
                       type: "POST",
                       url: url_del, // Ganti dengan URL tindakan penghapusan di Controller Anda
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
                                   "Failed to delete the item.",
                                   "error"
                               );
                           }
                       },
                       error: function() {
                           Swal.fire(
                               "Error!",
                               "An error occurred while deleting the item.",
                               "error"
                           );
                       },
                   });
               }
           });
       });
   });

//    edit stok warehouse kuningan
    const updateButtons = document.querySelectorAll(".update-button-kng");

    updateButtons.forEach((button) => {
        button.addEventListener("click", function() {
            const id = this.getAttribute("data-id");
            const url_update = this.getAttribute("data-url");

            Swal.fire({
                title: "Tambah Kuantitas Barang",
                text: "Masukkan jumlah qty",
                icon: "warning", 
                input: "number",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Simpan",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim permintaan hapus menggunakan Ajax
                    var qty = result.value;
                    if (qty !== undefined && qty !== null){
                        $.ajax({
                            type: "POST",
                            url: url_update, // Ganti dengan URL tindakan penghapusan di Controller Anda
                            data: {
                                id: id,
                                qty: qty
                            },
                            success: function(response) {
                                var data = JSON.parse(response);
                                if (data.success) {
                                    Swal.fire(
                                        "Diubah!",
                                        "Stok Berhasil Diubah",
                                        "success"
                                    ).then(() => {
                                        // Muat ulang halaman setelah penghapusan
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire(
                                        "Error!",
                                        "Failed to update the item.",
                                        "error"
                                    );
                                }
                            },
                            error: function() {
                                Swal.fire(
                                    "Error!",
                                    "An error occurred while updating the item.",
                                    "error"
                                );
                            },
                        });
                    } else {
                        Swal.fire(
                            "Error!",
                            "Qty tidak boleh kosong",
                            "error"
                        );
                    }
                }
            });
        });
    });

    // delete barang keluar
    const deleteButtonsKng = document.querySelectorAll(".delete-button-kng-keluar");

    deleteButtonsKng.forEach((button) => {
        button.addEventListener("click", function() {
            const id = this.getAttribute("data-id");
            const url_del = this.getAttribute("data-url");
 
            Swal.fire({
                title: "Apakah Anda yakin akan menghapus produk ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Gak Jadi Ah!",
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim permintaan hapus menggunakan Ajax
                    $.ajax({
                        type: "POST",
                        url: url_del, // Ganti dengan URL tindakan penghapusan di Controller Anda
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
                                    "Failed to delete the item.",
                                    "error"
                                );
                            }
                        },
                        error: function() {
                            Swal.fire(
                                "Error!",
                                "An error occurred while deleting the item.",
                                "error"
                            );
                        },
                    });
                }
            });
        });
    });
    
    // delete barang keluar
    const deleteStokKng = document.querySelectorAll(".delete-stok");

    deleteStokKng.forEach((button) => {
        button.addEventListener("click", function() {
            const id = this.getAttribute("data-id");
            const url_del = this.getAttribute("data-url");
 
            Swal.fire({
                title: "Apakah Anda yakin akan menghapus produk ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Gak Jadi Ah!",
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim permintaan hapus menggunakan Ajax
                    $.ajax({
                        type: "POST",
                        url: url_del, // Ganti dengan URL tindakan penghapusan di Controller Anda
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
                                    "Failed to delete the item.",
                                    "error"
                                );
                            }
                        },
                        error: function() {
                            Swal.fire(
                                "Error!",
                                "An error occurred while deleting the item.",
                                "error"
                            );
                        },
                    });
                }
            });
        });
    });