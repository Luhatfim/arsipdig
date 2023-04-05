<?php
include '../koneksi.php';
$id = $_GET['id'];

// hapus file lama
mysqli_query($koneksi, "DELETE FROM akses WHERE arsip_id=$id") or die(mysqli_error($koneksi));
$lama = mysqli_query($koneksi, "select * from arsip where arsip_id='$id'");
$l = mysqli_fetch_assoc($lama);
$nama_file_lama = $l['arsip_file'];
unlink("../arsip/" . $nama_file_lama);

mysqli_query($koneksi, "delete from arsip where arsip_id='$id'");
header("location:arsip.php");
