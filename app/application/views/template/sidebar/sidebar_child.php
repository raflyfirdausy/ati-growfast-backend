<?php foreach ($menuList as $list) : ?>
    <?php
    $hasChild   = !empty($list["child"]);
    $href       = $hasChild ? "javascript:void(0)" : $list["path"];
    ?>

    <li class="sidebar-item">
        <a class="sidebar-link <?= $hasChild ? "has-arrow" : "sidebar-link" ?> waves-effect waves-dark" href="<?= $href ?>" aria-expanded="false">
            <?php if (isset($list["icon"]) && !empty($list["icon"])) : ?>
                <i class="<?= $list["icon"] ?>"></i>
            <?php endif ?>
            <span class="hide-menu"><?= $list["title"] ?></span>
        </a>
        <?php if ($hasChild) : ?>
            <ul aria-expanded="false" class="collapse first-level">
                <?php $this->menu->generateChild($list["child"]) ?>
            </ul>
        <?php endif ?>
    </li>
<?php endforeach ?>

<!-- <li class="sidebar-item">
    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
        <i class="mdi mdi-code-equal"></i>
        <span class="hide-menu">Wisata</span>
    </a>
    <ul aria-expanded="false" class="collapse first-level">
        <li class="sidebar-item">
            <a href="<?= base_url('master/wisata/kategori') ?>" class="sidebar-link">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu"> Kategori Wisata </span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?= base_url('master/wisata/data') ?>" class="sidebar-link">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu"> Data & Foto Wisata </span>
            </a>
        </li>
    </ul>
</li>

<li class="sidebar-item">
    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url('dashboard') ?>" aria-expanded="false">
        <i class="mdi mdi-code-equal"></i>
        <span class="hide-menu">Dashboard</span>
    </a>
</li> -->