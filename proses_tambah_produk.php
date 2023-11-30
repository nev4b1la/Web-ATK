<?php 
include 'koneksi.php';
$nama_produk = $_POST['nama_produk'];
$deskripsi = $_POST['deskripsi'];
$harga = $_POST['harga'];

$rand = rand();
$ekstensi =  array('png','jpg','jpeg','gif');
$filename = $_FILES['foto_produk']['name'];
$ukuran = $_FILES['foto_produk']['size'];
$ext = pathinfo($filename, PATHINFO_EXTENSION);
$tempdir = "assets/";
 
if(!in_array($ext,$ekstensi) ) {
	header("location:tambah_produk.php?alert=gagal_ekstensi");
}else{
	if($ukuran < 10440700){		
		$xx = $rand.'_'.$filename;
		move_uploaded_file($_FILES['foto_produk']['tmp_name'], $tempdir.$xx);
		mysqli_query($toko, "INSERT INTO produuk VALUES(NULL,'$nama_produk','$deskripsi','$harga','$xx')");
		header("location:produk.php?alert=berhasil");
	}else{
		header("location:tambah_produk.php?alert=gagal_ukuran");
	}
}