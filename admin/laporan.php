<?php include 'header.php'; ?>

<div class="breadcome-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="breadcome-heading">
                                <h4 style="margin-bottom: 0px">Laporan</h4>
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
            <h3 class="panel-title">Laporan Arsip</h3>
        </div>
        <div class="panel-body">

            <form method="GET" action="">
                <div class="row pl-3">
                    <div class="col-md-2 border-right pt-4">
                        <span><b>Data Berdasarkan:</b></span>
                    </div>
                    <div class="col-md-2 form-group">
                        <label>Laporan</label>
                        <select class="form-control input-sm" required="" name="laporan" style="font-size: 12px;" id="laporan-change">
                            <option value="bulanan">Bulanan</option>
                            <option value="harian">Harian</option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group" id="bulan">
                        <label>Bulan</label>
                        <input type="month" class="form-control input-sm" id="bulan-val" name="bulan" style="font-size: 12px;" value="2023-01" autocomplete="off">
                    </div>
                    <div class="col-md-3 form-group" id="tanggal" hidden="">
                        <label>Tanggal</label>
                        <input type="date" class="form-control input-sm" id="tanggal-val" name="tanggal" style="font-size: 12px;" value="2023-01-15" autocomplete="off">
                    </div>
                    <div class="col-md-2 form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-sm btn-block" style="font-size: 14px;"><i class="fa fa-eye"></i> &nbsp;Tampilkan Data</button>
                    </div>
                </div>
            </form>

            <table id="table" class="table table-bordered table-striped table-hover table-datatable">
                <thead>
                    <tr>
                        <th width="1%">No</th>
                        <th>Waktu Upload</th>
                        <th>Arsip</th>
                        <th>Kategori</th>
                        <th>Petugas</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include '../koneksi.php';
                    $no = 1;
                    $arsip = mysqli_query($koneksi, "SELECT * FROM arsip,kategori,petugas WHERE arsip_petugas=petugas_id and arsip_kategori=kategori_id ORDER BY arsip_id DESC");
                    while ($p = mysqli_fetch_array($arsip)) {
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo date('H:i:s  d-m-Y', strtotime($p['arsip_waktu_upload'])) ?></td>
                            <td>

                                <b>KODE</b> : <?php echo $p['arsip_kode'] ?><br>
                                <b>Nama</b> : <?php echo $p['arsip_nama'] ?><br>
                                <b>Jenis</b> : <?php echo $p['arsip_jenis'] ?><br>

                            </td>
                            <td><?php echo $p['kategori_nama'] ?></td>
                            <td><?php echo $p['petugas_nama'] ?></td>
                            <td><?php echo $p['arsip_keterangan'] ?></td>
                            
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