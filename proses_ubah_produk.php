<?php
if($_POST){
    $nama_produk=$_POST['nama_produk'];
    $deskripsi=$_POST['deskripsi'];
    $harga=$_POST['harga'];
    $id_produk=$_POST['id_produk'];

    if(empty($nama_produk)){
        echo "<script>alert('nama produk tidak boleh kosong');location.href='update_produk.php';</script>";

    } elseif(empty($harga)){
        echo "<script>alert('harga tidak boleh kosong');location.href='update_produk.php';</script>";
    } else {
        include "koneksi.php";
        if(empty($harga)){
            $update=mysqli_query($toko,"update produuk set nama_produk='".$nama_produk."',deskripsi='".$deskripsi."', 
            harga='".$harga."' where id_produk=$id_produk") 
            or die(mysqli_error($toko));
            if($update){
                echo "<script>alert('Sukses update produk');location.href='produk.php';</script>";
            } else {
                echo "<script>alert('Gagal update produk');location.href='update_produk.php?id_produk=".$id_produk."';</script>";
            }
        } else {
            $update=mysqli_query($toko,"update produuk set nama_produk='".$nama_produk."',deskripsi='".$deskripsi."', harga='".$harga."' where id_produk=$id_produk") 
            or die(mysqli_error($toko));
            if($update){
                echo "<script>alert('Sukses update produk');location.href='produk.php';</script>";
            } else {
                echo "<script>alert('Gagal update produk');location.href='update_produk.php?id_produk=".$id_produk."';</script>";
            }
        }
        
    } 
}
?>