<footer class="footer text-center">
    © Copyright <?= date("Y") ?> <a href="<?= base_url() ?>" target="blank"><b><?= $app_name ?></b></a>
    All Rights Reserved | Rendered by <?= $this->benchmark->elapsed_time() ?> second and <?= $this->benchmark->memory_usage() ?> Memory Usage</span>
</footer>
</div>

<script src="<?= template_nice_admin() ?>assets/libs/popper.js/dist/umd/popper.min.js"></script>
<script src="<?= template_nice_admin() ?>assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?= template_nice_admin() ?>dist/js/app.min.js"></script>
<script>
    $(function() {
        "use strict";
        $("#main-wrapper").AdminSettings({
            Theme: false,
            Layout: 'vertical',
            LogoBg: 'skin5',
            NavbarBg: 'skin6',
            SidebarType: '<?= $SidebarType ?>',
            SidebarColor: 'skin5',
            SidebarPosition: true,
            HeaderPosition: true,
            BoxedLayout: false,
        });
    });
</script>
<script src="<?= template_nice_admin() ?>dist/js/app-style-switcher.js"></script>
<script src="<?= template_nice_admin() ?>assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
<script src="<?= template_nice_admin() ?>assets/extra-libs/sparkline/sparkline.js"></script>
<script src="<?= template_nice_admin() ?>dist/js/waves.js"></script>
<script src="<?= template_nice_admin() ?>dist/js/sidebarmenu.js"></script>
<script src="<?= template_nice_admin() ?>dist/js/custom.min.js"></script>
<script src="<?= template_nice_admin() ?>assets/libs/select2/dist/js/select2.full.min.js"></script>
<script src="<?= template_nice_admin() ?>assets/libs/select2/dist/js/select2.min.js"></script>
<script src="<?= template_nice_admin() ?>dist/js/pages/forms/select2/select2.init.js"></script>
<script src="<?= template_nice_admin() ?>dist/js/pages/datatable/datatable-basic.init.js"></script>
<script src="<?= template_nice_admin() ?>assets/extra-libs/c3/d3.min.js"></script>
<script src="<?= template_nice_admin() ?>assets/extra-libs/c3/c3.min.js"></script>
<script src="<?= template_nice_admin() ?>assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js"></script>
<script src="<?= template_nice_admin() ?>assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js"></script>
<script src="<?= template_nice_admin('assets/libs/sweetalert2/dist/sweetalert2.all.min.js'); ?>"></script>
<script src="<?= template_nice_admin('assets/libs/sweetalert2/sweet-alert.init.js'); ?>"></script>
<script src="<?= template_nice_admin('assets/libs/jquery.repeater/jquery.repeater.min.js'); ?>"></script>
</body>

</html>