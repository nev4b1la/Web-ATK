<?php 
session_start();
    if($_POST){
        include "koneksi.php";
        
        $qry_get_produk=mysqli_query($toko,"select * from produuk where id_produk = '".$_GET['id_produk']."'");
        $dt_produk=mysqli_fetch_array($qry_get_produk);
        $_SESSION['cart'][]=array(
            'id_produk'=>$dt_produk['id_produk'],
            'nama_produk'=>$dt_produk['nama_produk'],
            'qty'=>$_POST['banyak']
        );
    }
    header('location: keranjang_produk.php');
?>
