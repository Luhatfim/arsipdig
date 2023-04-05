<?php
include '../koneksi.php';
session_start();
date_default_timezone_set('Asia/Jakarta');

$waktu = date('Y-m-d H:i:s');
$petugas = $_SESSION['id'];
$kode  = $_POST['kode'];
$nama  = $_POST['nama'];
$nomor = $_POST['nomor'];

$rand = rand();

$filename = $_FILES['file']['name'];
$jenis = pathinfo($filename, PATHINFO_EXTENSION);

$kategori = $_POST['kategori'];
$keterangan = $_POST['keterangan'];

if ($jenis == "php") {
	header("location:arsip.php?alert=gagal");
} else {
	move_uploaded_file($_FILES['file']['tmp_name'], '../arsip/' . $rand . '_' . $filename);
	$nama_file = $rand . '_' . $filename;
	mysqli_query($koneksi, "insert into arsip values (NULL,'$waktu','$petugas','$kode','$nama','$nomor','$jenis','$kategori','$keterangan','$nama_file')") or die(mysqli_error($koneksi));

	$id = mysqli_insert_id($koneksi);

	if ($_POST['hak_akses'][0] == 'all') {
		mysqli_query($koneksi, "INSERT INTO akses VALUES (NULL, 0, 0, '$id')") or die(mysqli_error($koneksi));
	} else {
		foreach ($_POST['hak_akses'] as $dta) {
			$data = explode('-', $dta);
			$role = $data[0];
			$user_id = $data[1];
			mysqli_query($koneksi, "INSERT INTO akses VALUES (NULL, $role, $user_id, $id)") or die(mysqli_error($koneksi));
		}
	}

	header("location:arsip.php?alert=sukses");
}
