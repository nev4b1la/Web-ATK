<?php 
    include "header_produk.php";
?>
<h2>Histori Transaksi Pelanggan</h2>
<table class="table table-hover table-striped">
    <thead>
        <th>NO</th><th>Tanggal </th><th>Produk</th><th>Status</th>
    </thead>
    <tbody>
        <?php 
        include "koneksi.php";
        $qry_histori=mysqli_query($toko,"select * from transaksi order by id_transaksi desc");
        $no=0;
        while($dt_histori=mysqli_fetch_array($qry_histori)){
            $no++;
           
            $produk_dibeli="<ol>";
            $qry_produk=mysqli_query($toko,"select * from  detail_transaksi join produuk on produuk.id_produk=detail_transaksi.id_produk where id_transaksi = '".$dt_histori['id_transaksi']."'");
            while($dt_produk=mysqli_fetch_array($qry_produk)){
                $produk_dibeli.="<li>".$dt_produk['nama_produk']."</li>";
            }
            $produk_dibeli.="</ol>";
            
            $qry_cek_bayar=mysqli_query($toko,"select * from transaksi where id_transaksi = '".$dt_histori['id_transaksi']."'");
            if(mysqli_num_rows($qry_cek_bayar)>0){
                $dt_bayar=mysqli_fetch_array($qry_cek_bayar);
                $status_bayar="<label class='alert alert-success'>Sudah Bayar</label>";
            } 
        ?>
            <tr>
                <td><?=$no?></td><td><?=$dt_histori['tgl_transaksi']?></td></td><td><?=$produk_dibeli?></td><td><?=$status_bayar?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<?php 
    include "footer_produk.php";
?>