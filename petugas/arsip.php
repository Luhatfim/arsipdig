<?php include 'header.php'; ?>

<div class="breadcome-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="breadcome-heading">
                                <h4 style="margin-bottom: 0px">Data Arsip</h4>
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
    <div class="panel panel">

        <div class="panel-heading">
            <h3 class="panel-title">Data Arsip Saya</h3>
        </div>
        <div class="panel-body">


            <div class="pull-right">
                <a href="arsip_tambah.php" class="btn btn-primary"><i class="fa fa-cloud"></i> Upload Arsip</a>
            </div>

            <br>
            <br>
            <br>

            <center>
                <?php
                if (isset($_GET['alert'])) {
                    if ($_GET['alert'] == "gagal") {
                ?>
                        <div class="alert alert-danger">File arsip gagal diupload. karena demi keamanan file .php tidak diperbolehkan.</div>
                    <?php
                    } else {
                    ?>
                        <div class="alert alert-success">Arsip berhasil tersimpan.</div>
                <?php
                    }
                }
                ?>
            </center>
            <table id="table" class="table table-bordered table-striped table-hover table-datatable">
                <thead>
                    <tr>
                        <th width="1%">No</th>
                        <th>Waktu Upload</th>
                        <th>Arsip</th>
                        <th>Kategori</th>
                        <th>Diunggah</th>
                        <th>Keterangan</th>
                        <th class="text-center" width="21%">OPSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include '../koneksi.php';
                    $no = 1;
                    $saya = $_SESSION['id'];
                    $cek_akses = mysqli_query($koneksi, "SELECT * FROM akses WHERE role=0 or (role=1 and user_id='$saya')");
                    $cek = [];
                    foreach ($cek_akses as $dta) {
                        $cek[] = $dta['arsip_id'];
                    }

                    $cek_string = implode(',', $cek);

                    $arsip = mysqli_query($koneksi, "SELECT * FROM arsip 
                    JOIN kategori ON arsip.arsip_kategori=kategori.kategori_id
                    WHERE (arsip.arsip_petugas='$saya') or arsip.arsip_id IN ($cek_string) ORDER BY arsip.arsip_id DESC");
                    while ($p = mysqli_fetch_array($arsip)) {
                        $uid = $p['arsip_petugas'];
                        $petugas = mysqli_query($koneksi, "SELECT * FROM petugas WHERE petugas_id=$uid");
                        $pts = mysqli_fetch_assoc($petugas);

                        $user = mysqli_query($koneksi, "SELECT * FROM user WHERE user_id=$uid");
                        $usr = mysqli_fetch_assoc($user);

                        if ($pts) $petugas_nama = $pts['petugas_nama'];
                        else if ($usr) $petugas_nama = $usr['user_nama'];
                        else $petugas_nama = '-';
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($p['arsip_waktu_upload'])) ?></td>
                            <td>

                                <b>KODE</b> : <?php echo $p['arsip_kode'] ?><br>
                                <b>Nama</b> : <?php echo $p['arsip_nama'] ?><br>
                                <b>Nomor Surat</b> : <?php echo $p['arsip_nomor_surat'] ?><br>
                                <b>Jenis</b> : <?php echo $p['arsip_jenis'] ?><br>

                            </td>
                            <td><?php echo $p['kategori_nama'] ?></td>
                            <td><?php echo $petugas_nama ?></td>
                            <td><?php echo $p['arsip_keterangan'] ?></td>
                            <td class="text-center">



                                <div class="modal fade" id="exampleModal_<?php echo $p['arsip_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">PERINGATAN!</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah anda yakin ingin menghapus data ini? <br>file dan semua yang berhubungan akan dihapus secara permanen.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                                                <a href="arsip_hapus.php?id=<?php echo $p['arsip_id']; ?>" class="btn btn-primary"><i class="fa fa-check"></i> &nbsp; Ya, hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="btn-group">
                                    <a target="_blank" class="btn btn-default" href="../arsip/<?php echo $p['arsip_file']; ?>"><i class="fa fa-download"></i></a>
                                    <a target="_blank" href="arsip_preview.php?id=<?php echo $p['arsip_id']; ?>" class="btn btn-default"><i class="fa fa-search"></i> Preview</a>
                                    <?php if ($p['arsip_petugas'] == $id_petugas) { ?>
                                        <a href="arsip_edit.php?id=<?php echo $p['arsip_id']; ?>" class="btn btn-default"><i class="fa fa-wrench"></i></a>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal_<?php echo $p['arsip_id']; ?>">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    <?php } else { ?>
                                        <button type="button" class="btn btn-default disabled"><i class="fa fa-wrench"></i></button>
                                        <button type="button" class="btn btn-primary disabled"><i class="fa fa-trash"></i></button>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>


        </div>

    </div>
</div>


<?php include 'footer.php'; ?>