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