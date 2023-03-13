const validateNumberOnly = (element) => element.value = element.value.replace(/[^0-9]/, '')

const generateDatatable = (tableId, url, columns) => {
    return $(`#${tableId}`).DataTable({
        "language": {
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "zeroRecords": "Data tidak ditemukan",
            "info": "Menampilkan Halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Oops, data tidak ditemukan",
            "infoFiltered": "(di filter dari _MAX_ total data)",
            "loadingRecords": "Loading...",
            "processing": "Sedang memuat data...",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Berikutnya",
                "previous": "Sebelumnya"
            },
        },
        "bFilter": false,
        "pagingType": "full_numbers",
        "processing": true,
        "serverSide": true,
        "searching": true,
        "ordering": false,
        "columns": columns,
        "ajax": {
            "url": `${url}`,
            "type": "POST"
        },
    })
}

const generateSearchTable = (tableId, dataTable) => {
    $(`#${tableId} thead tr`).clone(true).appendTo(`#${tableId} thead`);
    $(`#${tableId} thead tr:eq(1) th`).each(function (i) {
        var title = $(this).text();
        if (i == 0 || i == 1) {
            $(this).html('');
        } else {
            $(this).html(`<input class="form-control" style="width: 100%" type="text" placeholder="Cari ${title}" />`);
        }

        $('input', this).on('keyup change', function (e) {
            if (e.keyCode == 13) {
                if (dataTable.column(i).search() !== this.value) {
                    dataTable.column(i).search(this.value).draw();
                }
            }
        })
    })
}

const generateAjaxProses = (formId, url, dataTable) => {
    $(`#${formId}`).submit(e => {
        e.preventDefault()
        var form = $(`#${formId}`)[0]
        var data = new FormData(form)

        $(".proses_btn").prop('disabled', true)
        $(".proses_btn").text("Sedang menyimpan data...")

        Swal.fire({
            title: 'Mohon Tunggu Beberapa Saat',
            text: 'Sedang menyimpan data...',
            onBeforeOpen: () => {
                Swal.showLoading()
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: url,
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (result) {
                        $(".proses_btn").prop('disabled', false)
                        $(".proses_btn").text("Simpan")
                        if (result.code == 200) {
                            dataTable.ajax.reload(null, false)
                            Swal.fire({
                                title: 'Sukses',
                                text: result.message,
                                type: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Tutup'
                            }).then((result) => {
                                $(`#${formId}`).trigger("reset");
                                $(".modal").modal("hide")
                            })
                        } else {
                            Swal.fire({
                                title: 'Gagal',
                                html: result.message,
                                type: 'error',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Tutup'
                            })
                        }

                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $(".proses_btn").prop('disabled', false)
                        $(".proses_btn").text("Simpan")
                        Swal.fire("Oops", xhr.responseText, "error")
                    }
                })
            }
        })
    })
}

const hapusData = (dataId, url, dataTable) => {
    swal.fire({
        title: 'Peringatan',
        text: "Apakah anda yakin ingin menghapus data ini ?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Hapus'
    }).then((result) => {
        if (result.value) {
            Swal.fire({
                title: 'Mohon Tunggu Beberapa Saat',
                text: 'Sedang menghapus data...',
                onBeforeOpen: () => {
                    Swal.showLoading()
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            "id_data": dataId
                        },
                        dataType: "json",
                        success: function (data) {
                            if (data.code == 200) {
                                Swal.fire(
                                    'Terhapus',
                                    data.message,
                                    'success'
                                ).then((result) => {
                                    dataTable.ajax.reload(null, false)
                                })
                            } else {
                                Swal.close();
                                Swal.fire("Oops", data.message, "error");
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            Swal.fire("Oops", xhr.responseText, "error");
                        }
                    })
                }
            })
        }
    })
}

const modalEditAction = (id, url, modalId, fieldForm) => {
    Swal.fire({
        title: 'Mohon Tunggu Beberapa Saat',
        text: 'Sedang mengambil data...',
        onBeforeOpen: () => {
            Swal.showLoading()
            $.ajax({
                url: url + id,
                type: "GET",
                dataType: "JSON",
                contentType: "application/json; charset=utf-8",
                success: function (result) {
                    Swal.close()
                    if (result.code == 200) {
                        let data = result.data
                        console.log(data)
                        fieldForm.forEach((currentValue, index, arr) => {
                            if (currentValue.type != "file" && currentValue.type != "password") {
                                if (currentValue.type == "select") {
                                    if (currentValue.options.chain) {
                                        $(`#${currentValue.name}_edit`).html(`<option value="${data[currentValue.name]}" selected>${data[currentValue.name_alias]}</option>`)
                                        // $(`#${currentValue.name}_edit`).val(data[currentValue.name]).trigger("change")
                                    } else {
                                        $(`#${currentValue.name}_edit`).val(data[currentValue.name]).trigger("change")
                                    }
                                } else {
                                    $(`#${currentValue.name}_edit`).val(data[currentValue.name])
                                }
                            }
                        })
                        $("#id_data").val(data.id)
                        $(`#${modalId}`).modal("show")
                    } else {
                        Swal.fire({
                            title: 'Gagal',
                            text: result.message,
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Tutup'
                        })
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    Swal.close()
                    Swal.fire("Oops", xhr.responseText, "error")
                }
            })
        }
    })
}