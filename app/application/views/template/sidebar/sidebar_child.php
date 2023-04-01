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