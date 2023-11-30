<?php 
    include "header_produk.php";
?>
<h2 center>Daftar Produk</h2>
<div class="row">
    <?php 
    include "koneksi.php";
    $qry_produk=mysqli_query($toko,"select * from produuk");
    while($dt_produk=mysqli_fetch_array($qry_produk)){
        ?>
        <div class="col-md-3">
            <div class="card" >            
              <img src="assets/<?=$dt_produk['foto_produk']?>" class="card-img-top">
              <div class="card-body">
                <h5 class="card-title"><?=$dt_produk['nama_produk']?></h5>
                <p class="card-text"><?=substr($dt_produk['harga'], 0,20)?></p>
                <a href="beli_produk.php?id_produk=<?=$dt_produk['id_produk']?>" class="btn btn-success">Buy</a>
                <a href="update_produk.php?id_produk=<?=$dt_produk['id_produk']?>" class="btn btn-primary">Update</a>
                <a href="hapus_produk.php?id_produk=<?=$dt_produk['id_produk']?>" class="btn btn-danger">Delete</a>
            </div>
            </div>
        </div>
        <?php
    }
    ?>
    
</div>
<br>
<?php 
    include "footer_produk.php";
?>