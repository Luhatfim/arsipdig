<?php include 'header.php'; ?>

<div class="breadcome-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="breadcome-heading">
                                <h4 style="margin-bottom: 0px">Upload Arsip</h4>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <ul class="breadcome-menu" style="padding-top: 0px">
                                <li><a href="#">Home</a> <span class="bread-slash">/</span></li>
                                <li><span class="bread-blod">Arsip</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">


    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel panel">

                <div class="panel-heading">
                    <h3 class="panel-title">Upload arsip</h3>
                </div>
                <div class="panel-body">

                    <div class="pull-right">
                        <a href="arsip.php" class="btn btn-sm btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>

                    <br>
                    <br>

                    <form method="post" action="arsip_aksi.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Kategori</label>
                            <select class="form-control kategori-select" name="kategori" required="required">
                                <option value="">Pilih kategori</option>
                                <?php
                                $kategori = mysqli_query($koneksi, "SELECT * FROM kategori");
                                while ($k = mysqli_fetch_array($kategori)) {
                                ?>
                                    <option value="<?php echo $k['kategori_id']; ?>"><?php echo $k['kategori_nama']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Kode Arsip</label>
                            <input type="text" class="form-control kode-arsip" name="kode" required="required" readonly placeholder="KA-000">
                        </div>

                        <div class="form-group">
                            <label>Nama Arsip</label>
                            <input type="text" class="form-control" name="nama" required="required">
                        </div>

                        <div class="form-group">
                            <label>Nomor Surat</label>
                            <input type="text" class="form-control" name="nomor">
                        </div>

                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea class="form-control" name="keterangan" required="required"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Hak Akses</label>
                            <select class="form-control select2" required="required" name="hak_akses[]" multiple="multiple">
                                <option value="all">Pilih Semua</option>
                                <optgroup label="Petugas">
                                    <?php
                                    $petugas = mysqli_query($koneksi, "SELECT * FROM petugas WHERE petugas_id != $id_petugas");
                                    foreach ($petugas as $dta) {
                                    ?>
                                        <option value="1-<?= $dta['petugas_id'] ?>"><?= $dta['petugas_nama'] ?></option>
                                    <?php } ?>
                                </optgroup>
                                <optgroup label="Guru/Staf">
                                    <?php
                                    $user = mysqli_query($koneksi, "SELECT * FROM user");
                                    foreach ($user as $dta) {
                                    ?>
                                        <option value="2-<?= $dta['user_id'] ?>"><?= $dta['user_nama'] ?></option>
                                    <?php } ?>
                                </optgroup>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>File</label>
                            <input type="file" name="file">
                        </div>

                        <div class="form-group">
                            <label></label>
                            <input type="submit" class="btn btn-primary" value="Upload">
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>


</div>


<?php include 'footer.php'; ?>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Pilih hak akses"
        });

        $('.select2').on('change', function() {
            var value = $(this).val();

            if (value != null && value.includes('all')) {
                $('.select2').select2({
                    placeholder: "Pilih hak akses",
                    maximumSelectionLength: 1
                });
            } else {
                $('.select2').find('option[value="all"]').remove();
                $('.select2').select2({
                    placeholder: "Pilih hak akses"
                });
            }

            if (value == null) {
                $('.select2').prepend('<option value="all" hidden>Pilih Semua</option>');
            }
        });

        $('.kategori-select').change(function(e) {
            e.preventDefault();

            var kategori_id = $(this).val();

            $.ajax({
                url: 'controller.php',
                method: 'POST',
                data: {
                    kategori_id
                },
                success: function(data) {
                    $('.kode-arsip').val(data);
                },
            });
        });
    });
</script>