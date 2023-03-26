<div class="container-fluid">
    <?php $this->load->view($RFL_TABLE) ?>
</div>

<?php $this->load->view($RFL_MODAL, [
    "modal_id"      => "modal_tambah",
    "modal_title"   => "Form Tambah",
    "modal_form_id" => "form_add",
    "modal_edit"    => false
]) ?>

<?php $this->load->view($RFL_MODAL, [
    "modal_id"      => "modal_edit",
    "modal_title"   => "Form Edit",
    "modal_form_id" => "form_edit",
    "modal_edit"    => true
]) ?>

<div class="modal fade myModal" id="modal_reset">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title text-white">Reset Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="form_reset" enctype='multipart/form-data'>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="password_baru" class="mb-0 control-label">Password Baru <span class="text-danger">*</span></label>
                                <input class="form-control" type="password" required id="password_baru" name="password_baru">
                            </div>
                            <div class="col-md-6">
                                <label for="password_baru" class="mb-0 control-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                <input class="form-control" type="password" required id="konfirmasi_password" name="konfirmasi_password">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id_reset" id="id_reset">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success proses_btn">Simpan</button>
                </div>
            </form>
        </div>

    </div>
</div>



<script>
    let RFL_COLUMNS = [{
            "data": null,
            "sortable": false,
            className: "text-center align-middle",
            render: function(data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        {
            "data": "id",
            className: "text-center align-middle",
            render: function(data, type, row, meta) {
                let result = /* html */ `              
                    <div class="dropdown">
                        <button style="width:100%" class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pilih Aksi
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button onclick="modalEdit('${row.id}')" class="dropdown-item"><i class="fas fa-edit"></i> Edit</button>                                                                  
                            <button onclick="hapus('${row.id}')" class="dropdown-item"><i class="fas fa-trash"></i> Hapus</button>                                                                  
                            <button onclick="resetPassword('${row.id}')" class="dropdown-item"><i class="fas fa-key"></i> Reset Password</button>                                                                  
                        </div>
                    </div>
                    `
                return result;
            }
        },
    ]

    <?php foreach ($FIELD_FORM as $form) : $isHideFromTable = isset($form["hideFromTable"]) ? $form["hideFromTable"] : FALSE; ?>
        <?php if ($form["type"] != "hidden" && !$isHideFromTable) : ?>
            RFL_COLUMNS.push({
                "data": "<?= isset($form["name_alias"]) ? $form["name_alias"] : $form["name"] ?>"
            })
        <?php endif ?>

    <?php endforeach ?>
    RFL_COLUMNS.push({
        "data": "created_at"
    })

    var RFL_TABLE = generateDatatable("table_data", "<?= $URL_GET_DATA ?>", RFL_COLUMNS)
    generateAjaxProses("form_add", "<?= $URL_CREATE_DATA ?>", RFL_TABLE)
    generateAjaxProses("form_edit", "<?= $URL_UPDATE_DATA ?>", RFL_TABLE)
    const hapus = id => hapusData(id, "<?= $URL_DELETE_DATA ?>", RFL_TABLE)
    const modalEdit = id => modalEditAction(id, "<?= $URL_DETAIL_DATA ?>", "modal_edit", <?= json_encode($FIELD_FORM) ?>)

    $(document).ready(() => {

        generateSearchTable("table_data", RFL_TABLE)
        $(".select2").select2()

        <?php foreach ($FIELD_FORM as $form) :
            $idForm             = $form["name"];
            $idFormEdit         = $form["name"] . "_edit";
            $isRequired         = $form["required"] ? "required" : "";
            $isHideFromTable    = isset($form["hideFromTable"]) ? $form["hideFromTable"] : FALSE;
            $ishideFromCreate   = isset($form["hideFromCreate"])    ? $form["hideFromCreate"]   : FALSE;
        ?>
            <?php if ($form["type"] == "select" && $form["options"]["chain"]) :
                $idFormTo       = $form["options"]["to"];
                $idFormToEdit   = $form["options"]["to"] . "_edit";
                $indexChain     = array_search($form["options"]["to"], array_column($FIELD_FORM, "name"));
            ?>
                $("#<?= $idFormTo ?>").change(() => {

                    <?php if (isset($form["options"]["reset"])) : ?>
                        <?php foreach ($form["options"]["reset"] as $reset) : ?>
                            $("#<?= $reset ?>").val("").trigger("change")
                        <?php endforeach ?>
                    <?php endif ?>

                    let id = $("#<?= $idFormTo ?>").val()
                    $("#<?= $idForm ?>").html(`<option value="" selected disabled>Sedang mencari data..</option>`)
                    $.ajax({
                        url: "<?= $form["options"]["data"] ?>" + id,
                        type: "GET",
                        dataType: "JSON",
                        contentType: "application/json; charset=utf-8",
                        success: function(result) {
                            let _dataSelect2 = `<option value="" selected>Pilih <?= strtolower($FIELD_FORM[$indexChain]["label"]) ?> terlebih dahulu</option>`
                            if (result.code == 200) {
                                _dataSelect2 = `<option value="" selected>Pilih <?= strtolower($form["label"]) ?></option>`
                                result.data.forEach((currentValue, index, arr) => {
                                    _dataSelect2 += `<option value="${currentValue.value}">${currentValue.label}</option>`
                                })
                            } else {
                                _dataSelect2 = `<option value="" selected>${result.message}</option>`
                            }
                            $("#<?= $idForm ?>").html(_dataSelect2)
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            Swal.fire("Oops", xhr.responseText, "error")
                        }
                    })
                })

                $("#<?= $idFormToEdit ?>").change(() => {


                    let id = $("#<?= $idFormToEdit ?>").val()
                    $("#<?= $idFormEdit ?>").html(`<option value="" selected disabled>Sedang mencari data..</option>`)
                    $.ajax({
                        url: "<?= $form["options"]["data"] ?>" + id,
                        type: "GET",
                        dataType: "JSON",
                        contentType: "application/json; charset=utf-8",
                        success: function(result) {
                            let _dataSelect2 = `<option value="" selected>Pilih <?= strtolower($FIELD_FORM[$indexChain]["label"]) ?> terlebih dahulu</option>`
                            if (result.code == 200) {
                                _dataSelect2 = `<option value="" selected>Pilih <?= strtolower($form["label"]) ?></option>`
                                result.data.forEach((currentValue, index, arr) => {
                                    _dataSelect2 += `<option value="${currentValue.value}">${currentValue.label}</option>`
                                })
                            } else {
                                _dataSelect2 = `<option value="" selected>${result.message}</option>`
                            }
                            $("#<?= $idFormEdit ?>").html(_dataSelect2)
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            Swal.fire("Oops", xhr.responseText, "error")
                        }
                    })
                })

            <?php endif ?>
        <?php endforeach ?>
    })
</script>

<script>
    const resetPassword = id => {
        Swal.fire({
            title: 'Mohon Tunggu Beberapa Saat',
            text: 'Sedang mengambil data...',
            onBeforeOpen: () => {
                Swal.showLoading()
                $.ajax({
                    url: "<?= $URL_DETAIL_DATA ?>" + id,
                    type: "GET",
                    dataType: "JSON",
                    contentType: "application/json; charset=utf-8",
                    success: function(result) {
                        Swal.close()
                        if (result.code == 200) {
                            let data = result.data
                            $("#id_reset").val(data.id)
                            $(`#modal_reset`).modal("show")
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
                    error: function(xhr, ajaxOptions, thrownError) {
                        Swal.close()
                        Swal.fire("Oops", xhr.responseText, "error")
                    }
                })
            }
        })
    }

    $("#form_reset").submit(e => {
        e.preventDefault()
        var form = $(`#form_reset`)[0]
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
                    url: "<?= $URL_RESET ?>",
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(result) {
                        $(".proses_btn").prop('disabled', false)
                        $(".proses_btn").text("Simpan")
                        if (result.code == 200) {
                            RFL_TABLE.ajax.reload(null, false)
                            Swal.fire({
                                title: 'Sukses',
                                text: result.message,
                                type: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Tutup'
                            }).then((result) => {
                                $(`#form_reset`).trigger("reset");
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
                    error: function(xhr, ajaxOptions, thrownError) {
                        $(".proses_btn").prop('disabled', false)
                        $(".proses_btn").text("Simpan")
                        Swal.fire("Oops", xhr.responseText, "error")
                    }
                })
            }
        })
    })
</script>