<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="keywords" content="<?= $_ENV["APP_NAME"] ?>" />
    <meta name="description" content="<?= $_ENV["APP_NAME"] ?>" />
    <meta name="robots" content="noindex,nofollow" />
    <title><?= $_ENV["APP_NAME"] ?></title>
    <link rel="canonical" href="<?= base_url() ?>" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?= asset_ng("img/logo_mpp.png") ?>" />
    <link href="<?= template_nice_admin() ?>dist/css/style_auth.min.css" rel="stylesheet" />
</head>

<body>
    <div class="main-wrapper">
        <div class="preloader">
            <img src="<?= asset("img/ayunda_white.png") ?>" style="position:absolute;top:0;left:0;right:0;bottom:0;margin:auto;width:250px;" alt="homepage" class="dark-logo" />
        </div>
        <div class="row auth-wrapper gx-0">
            <div class="col-lg-4 col-xl-3 bg-info auth-box-2 on-sidebar">
                <div class="h-100 d-flex align-items-center justify-content-center">
                    <div class="row justify-content-center text-center">
                        <div class="col-md-7 col-lg-12 col-xl-9">
                            <div>
                                <img src="<?= asset("img/ayunda_white.png") ?>" style="width:100px;height:100px;" alt="homepage" class="dark-logo" />
                                <h2 class="text-white mt-4 fw-light">
                                    <span class="font-weight-medium"><?= $_ENV["APP_SIMPLE_NAME"] ?></span>
                                </h2>
                            </div>
                            <h2 class="op-5 text-white fs-4 mt-4">
                                <span class="font-weight-medium">Ayunda Tour Official</span>
                                Biro dan Jasa Serve with Heart and Smile
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xl-9 d-flex align-items-center justify-content-center">
                <div class="row justify-content-center w-100 mt-4 mt-lg-0">
                    <div class="col-lg-6 col-xl-3 col-md-7">
                        <div class="card " id="loginform">
                            <div class="card-body">
                                <center>
                                    <h2><span class="font-weight-medium">Masuk Aplikasi</span></h2>
                                </center>
                                <?php if ($this->session->flashdata("gagal")) : ?>
                                    <div class="alert bg-danger alert-dismissible fade show" role="alert">
                                        <strong class="text-white">Gagal !</strong> <span class="text-white"><?= $this->session->flashdata("gagal") ?></span>
                                        <button type="button" class="close" style="position: absolute;top: 0;right: 0;padding: 0.75rem 1.25rem;background-color:transparent;border:0;font-size: 1.5rem;font-size: 1.5rem;line-height: 1;color: #000;text-shadow: 0 1px 0 #fff;opacity: .5;" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif; ?>
                                <form method="POST" action="<?= $URL_LOGIN ?>" class="form-horizontal pt-2 needs-validation" novalidate>
                                    <div class="form-floating mb-3">
                                        <input type="text" name="username" class="form-control form-input-bg" id="tb-email" required />
                                        <label for="tb-email">Username</label>
                                        <div class="invalid-feedback">Username harus diisi.</div>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="password" name="password" class="form-control form-input-bg" id="text-password" required />
                                        <label for="text-password">Password</label>
                                        <div class="invalid-feedback">Password harus diisi.</div>
                                    </div>
                                    <div class="d-flex align-items-stretch button-group">
                                        <button type="submit" style="width: 100%;" class="btn btn-info btn-lg px-4">
                                            Masuk
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= template_nice_admin() ?>assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?= template_nice_admin() ?>assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(".preloader").fadeOut();
        (function() {
            "use strict";
            var forms = document.querySelectorAll(".needs-validation");
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener(
                    "submit",
                    function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add("was-validated");
                    },
                    false
                );
            });
        })();
    </script>
</body>

</html>