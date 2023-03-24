<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <?php foreach ($menuList as $list) : ?>
                    <li class="nav-small-cap">
                        <i class="mdi mdi-dots-horizontal"></i>
                        <span class="hide-menu"><?= $list["title"] ?></span>
                    </li>
                    <?php $this->menu->generateChild($list["child"]) ?>
                <?php endforeach ?>
            </ul>
        </nav>
    </div>
</aside>