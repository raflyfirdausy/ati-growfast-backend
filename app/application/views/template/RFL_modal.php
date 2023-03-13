<div class="modal fade myModal" id="<?= $modal_id ?>">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-<?= $modal_edit ? "primary" : "success" ?>">
                <h4 class="modal-title text-white"><?= $modal_title . " " . $title ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="<?= $modal_form_id ?>" enctype='multipart/form-data'>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <?php
                            foreach ($FIELD_FORM as $form) : ?>

                                <?php
                                $idForm             = $form["name"] . ($modal_edit ? "_edit" : "");
                                $isRequired         = $form["required"]                 ? "required"                : "";                              
                                $isRequired         = isset($form["required_edit"])     ? ($form["required_edit"]   ? "required" : "") : ($form["required"] ? "required" : "");
                                $isHideFromTable    = isset($form["hideFromTable"])     ? $form["hideFromTable"]    : FALSE;
                                $isHideFromEdit     = isset($form["hideFromEdit"])      ? $form["hideFromEdit"]     : FALSE;
                                $ishideFromCreate   = isset($form["hideFromCreate"])    ? $form["hideFromCreate"]   : FALSE;

                                ?>

                                <div class="mt-1 col-md-<?= (($form["type"] == "hidden") ? 12 : (isset($form["col"]) && is_numeric($form["col"]) ? $form["col"] : 12)) ?>">

                                    <?php if ($modal_edit) : ?>
                                        <?php if (!$isHideFromEdit && $form["type"] != "hidden") : ?>
                                            <label for="<?= $form["name"] ?>" class="mb-0 control-label"><?= $form["label"] ?> <?= $isRequired ? '<span class="text-danger">*</span>' : '' ?> </label>
                                        <?php endif ?>
                                    <?php else : ?>
                                        <?php if (!$ishideFromCreate && $form["type"] != "hidden") : ?>
                                            <label for="<?= $form["name"] ?>" class="mb-0 control-label"><?= $form["label"] ?> <?= $isRequired ? '<span class="text-danger">*</span>' : '' ?> </label>
                                        <?php endif ?>
                                    <?php endif ?>

                                    <?php if ($form["type"] == "textarea") : ?>
                                        <textarea <?= $isRequired ?> class="form-control" name="<?= $form["name"] ?>" id="<?= $idForm ?>" rows="<?= isset($form["rows"]) ? $form["rows"] : 3 ?>"></textarea>
                                    <?php elseif ($form["type"] == "select") : ?>

                                        <?php if (!$form["options"]["chain"]) : ?>
                                            <select <?= $isRequired ?> class="form-control select2" id="<?= $idForm ?>" name="<?= $form["name"] ?>" style="width: 100%;">
                                                <option value="">Pilih <?= strtolower($form["label"]) ?></option>
                                                <?php foreach ($form["options"]["data"] as $opt) : ?>
                                                    <option value="<?= $opt["value"] ?>"><?= $opt["label"] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        <?php else : ?>
                                            <?php
                                            $idFormTo = $form["options"]["to"] . ($modal_edit ? "_edit" : "");
                                            $indexChain = array_search($form["options"]["to"], array_column($FIELD_FORM, "name"));
                                            ?>
                                            <select <?= $isRequired ?> class="form-control select2" id="<?= $idForm ?>" name="<?= $form["name"] ?>" style="width: 100%;">
                                                <option value="">Pilih <?= strtolower($FIELD_FORM[$indexChain]["label"]) ?> terlebih dahulu</option>
                                            </select>
                                        <?php endif ?>
                                    <?php else : ?>
                                        <?php if ($modal_edit) : ?>
                                            <?php if (!$isHideFromEdit) : ?>
                                                <input <?= $form["type"] == "password" ? "autocomplete='false'" : "autocomplete='true'" ?> <?= $form["type"] == "number" ? "step='any'" : "" ?> <?= ($form["type"] == "file" && isset($form["accept"])) ? "accept=" . $form["accept"] : "" ?> <?= $isRequired ?> class="form-control<?= $form["type"] == "file" ? "-file" : "" ?>" onkeyup="<?= $form["numberOnly"] ? "validateNumberOnly(this)" : "" ?>" type="<?= $form["type"] ?>" name="<?= $form["name"] ?>" id="<?= $idForm ?>" value="<?= $form["type"] == "password" ? "" : (isset($form["value"]) ? $form["value"] : "") ?>">
                                            <?php endif ?>
                                        <?php else : ?>
                                            <?php if (!$ishideFromCreate) : ?>
                                                <input <?= $form["type"] == "number" ? "step='any'" : "" ?> <?= ($form["type"] == "file" && isset($form["accept"])) ? "accept=" . $form["accept"] : "" ?> <?= $isRequired ?> class="form-control<?= $form["type"] == "file" ? "-file" : "" ?>" onkeyup="<?= $form["numberOnly"] ? "validateNumberOnly(this)" : "" ?>" type="<?= $form["type"] ?>" name="<?= $form["name"] ?>" id="<?= $idForm ?>" value="<?= isset($form["value"]) ? $form["value"] : "" ?>">
                                            <?php endif ?>
                                        <?php endif ?>
                                    <?php endif ?>

                                    <?php if ($modal_edit) : ?>
                                        <?php if (isset($form["note_edit"]) && !empty($form["note_edit"])) : ?>
                                            <small class="text-danger"><?= $form["note_edit"] ?></small>
                                        <?php endif ?>
                                    <?php else : ?>
                                        <?php if (isset($form["note_create"]) && !empty($form["note_create"])) : ?>
                                            <small class="text-info"><?= $form["note_create"] ?></small>
                                        <?php endif ?>
                                    <?php endif ?>


                                </div>

                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php if ($modal_edit) : ?>
                        <input type="hidden" name="id_data" id="id_data">
                    <?php endif ?>
                    <button type="button" class="btn btn-dark" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-<?= $modal_edit ? "primary" : "success" ?> proses_btn">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>