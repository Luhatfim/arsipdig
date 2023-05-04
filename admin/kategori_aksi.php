<?php 
include '../koneksi.php';
$nama  = $_POST['nama'];
$kode = $_POST['kode'];
$keterangan = $_POST['keterangan'];

mysqli_query($koneksi, "insert into kategori values (NULL,'$nama','$kode','$keterangan')");
header("location:kategori.php");