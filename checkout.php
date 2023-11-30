<?php
include "koneksi.php";
$qry_produk=mysqli_query($toko," SELECT * FROM produuk WHERE id_produk='".$_GET['id_produk']."'" );
$dt_produk=mysqli_fetch_array($qry_produk);
$query="SET foreign_key_checks = 0";
$query="DELETE FROM produk WHERE id_produk =$dt_produk[id_produk]";
$del=mysqli_query($toko,$query);
if($qry_produk){
    $query="SET foreign_key_checks = 1";
    echo "<script>alert('Sukses hapus produk');location.href='produk.php';</script>";
} else {
    echo "<script>alert('Gagal hapus produk');location.href='produk.php';</script>";
}
header ('produk.php');
?>