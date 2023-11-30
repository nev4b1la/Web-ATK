<?php 
    if($_POST){
        $username=$_POST['username'];
        $password=$_POST['password'];
        if(empty($username)){
            echo "<script>alert('Username tidak boleh kosong');location.href='login_produk.php';</script>";
        } elseif(empty($password)){
            echo "<script>alert('Password tidak boleh kosong');location.href='login_produk.php';</script>";
        } else {
            include "koneksi.php";
            $qry_login=mysqli_query($toko,"select * from petugas where username = '".$username."' and password = '".md5($password)."'");
            if(mysqli_num_rows($qry_login)>0){
                $dt_login=mysqli_fetch_array($qry_login);
                session_start();
                $_SESSION['id_petugas']=$dt_login['id_petugas'];
                $_SESSION['nama_petugas']=$dt_login['nama_petugas'];
                $_SESSION['status_login']=true;
                header("location: home_produk.php");
            } else {
                echo "<script>alert('Username dan Password tidak benar');location.href='login_produk.php';</script>";
            }
        }
    }
?>