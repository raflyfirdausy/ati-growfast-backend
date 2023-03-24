<?php $this->menu->generate() ?>

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 align-self-center">
                <h4 class="page-title"><?= isset($page_title) ? $page_title : (isset($title) ? ucwords(strtolower($title)) : "")  ?></h4>
            </div>
        </div>
    </div>