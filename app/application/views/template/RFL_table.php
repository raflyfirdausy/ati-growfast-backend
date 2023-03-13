<div class="card">
    <div class="card-header">
        <a href="<?= back() ?>" type="button" class="btn btn-primary float-left"><i class="fas fa-chevron-left"></i> Kembali</a>
        <?php if ($ENABLE_ADD_BUTTON) : ?>
            <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#modal_tambah"><i class="fas fa-plus"></i> Tambah Data <?= $title ?></button>
        <?php endif ?>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="table_data" class="table table-sm nowrap table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 3%">No.</th>
                        <th style="width: 1%">Aksi</th>
                        <?php foreach ($FIELD_FORM as $form) :
                            $isHideFromTable = isset($form["hideFromTable"]) ? $form["hideFromTable"] : FALSE;
                        ?>
                            <?php if ($form["type"] != "hidden" && !$isHideFromTable) : ?>
                                <th><?= $form["label"] ?></th>
                            <?php endif ?>
                        <?php endforeach ?>
                        <th>Waktu dibuat</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>