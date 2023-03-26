<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <a href="<?= back() ?>" type="button" class="btn btn-primary float-left"><i class="fas fa-chevron-left"></i> Kembali</a>
        </div>
        <div class="card-body">
            <form method="POST" action="<?= base_url('Profile/ubahProfile') ?>" id="form_profile" enctype='multipart/form-data'>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="mb-0 control-label"> Username <span style="color: red">*</span> </label>
                            <input type="text" class="form-control" value="<?= $profile['username'] ?>" name="username" id="username" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="mb-0 control-label"> Nama <span style="color: red">*</span> </label>
                            <input type="text" class="form-control" value="<?= $profile['nama'] ?>" name="nama" id="nama" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="mb-0 control-label"> Jenis Kelamin </label>
                            <select style="width:100%" class="form-control select2" name="jenis_kelamin" id="jenis_kelamin">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="LAKI-LAKI" <?= $profile['jenis_kelamin'] == "LAKI-LAKI" ? "selected" : "" ?>>LAKI-LAKI</option>
                                <option value="PEREMPUAN" <?= $profile['jenis_kelamin'] == "PEREMPUAN" ? "selected" : "" ?>>PEREMPUAN</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="mb-0 control-label"> No Telp </label>
                            <input type="number" class="form-control" value="<?= $profile['no_telp'] ?>" name="no_telp" id="no_telp">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="mb-0 control-label"> Password </label>
                            <input type="password" class="form-control" name="password" id="password">
                            <small class="text-info">Kosongi jika tidak ingin mengubah password</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-md btn-success" onclick="ubahProfile()"> Simpan </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function ubahProfile() {
        Swal.fire({
            title: 'Mohon Tunggu Beberapa Saat',
            html: 'Sedang mengubah data profile ...',
            onBeforeOpen: () => {
                Swal.showLoading()
                let _form = $("#form_profile")
                let _url = _form.attr('action')
                $.ajax({
                    type: "POST",
                    url: _url,
                    data: _form.serialize(),
                    dataType: "JSON",
                    success: function(result) {
                        if (result["code"] == 200) {
                            Swal.close();
                            Swal.fire({
                                    type: 'success',
                                    customClass: 'swal-custom',
                                    title: 'Berhasil!',
                                    html: '<pre>' + JSON.stringify(result.message, null, " ").replace(/{|}|,|"/g, "") + '</pre>',
                                    confirmButtonText: 'Tutup',
                                })
                                .then((response) => {
                                    window.location = "<?= base_url("profile") ?>";
                                })
                        } else {
                            Swal.fire({
                                type: 'info',
                                customClass: 'swal-custom',
                                title: 'Info',
                                html: '<pre>' + JSON.stringify(result.message, null, " ").replace(/{|}|,|"/g, "") + '</pre>',
                                confirmButtonText: 'Tutup',
                            })
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        Swal.fire("Gagal", xhr.responseText, "error")
                    }
                });
            }
        })
    }
</script>