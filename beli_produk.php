<?php 
    include "header_produk.php";
    include "koneksi.php";
    $qry_detail_produk=mysqli_query($toko,"select * from produuk where id_produk = '".$_GET['id_produk']."'");
    $dt_produk=mysqli_fetch_array($qry_detail_produk);
?>
<h2>Beli Produk</h2>
<div class="row">
    <div class="col-md-4">
        <img src="assets/<?=$dt_produk['foto_produk']?>" class="card-img-top">
    </div>
    <div class="col-md-8">
        <form action="masukan_produk.php?id_produk=<?=$dt_produk['id_produk']?>" method="post">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <td>Nama produk</td><td><?=$dt_produk['nama_produk']?></td>
                    </tr>
                    <tr>
                        <td>Deskripsi</td><td><?=$dt_produk['deskripsi']?></td>
                    </tr>
                    <tr>
                        <td>Harga</td><td><?=$dt_produk['harga']?></td>
                    </tr>
                    <tr>
                        <td>Banyak</td><td><input type="number" name="banyak" value="1"></td>
                       </tr>                    <tr>
                        <td colspan="2"><input class="btn btn-success" type="submit" value="BELI"></td>
                    </tr>
                </thead>      
            </table>
        </form>
    </div>
</div>

<?php 
    include "footer_produk.php";
?>
<!--
Penjelasan:
Di tampilan ini diminta untuk menentukan jumlah buku yang akan dipinjamdisertai dengan nama buku dan deskripsi. 
Ketika diklik tombol pinjam maka akan menuju url masukkankeranjang.php?id_buku=<?=$dt_buku['id_buku']?> 
yang mengandung variable url id_buku yang membawa datanya menuju halaman masukkankeranjang.php untuk diproses.-->