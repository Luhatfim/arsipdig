<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $kategori_id = $_POST['kategori_id'];
    $kategori = mysqli_query($koneksi, "SELECT * FROM kategori WHERE kategori_id='$kategori_id'");
    $kat = mysqli_fetch_assoc($kategori);
    $arsip = mysqli_query($koneksi, "SELECT * FROM arsip WHERE arsip_kategori='$kategori_id' ORDER BY arsip_id DESC LIMIT 1");
    $ars = mysqli_fetch_assoc($arsip);

    $last = $ars ? preg_replace("/[^0-9]/", "", $ars['arsip_kode']) : 0;
    $last = sprintf('%03s', (int)$last + 1);
    $kode = $kat['kategori_kode'] . '-' . $last;
    echo json_encode($kode);
    exit;
}
