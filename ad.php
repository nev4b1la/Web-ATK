•	Membuat Proses Check Out
15.	Buatlah file checkout.php di xampp/htdocs/perpus_native
16.	Ketikkan sintak berikut:
<?php 
    session_start();
    include "koneksi.php";
    $cart=@$_SESSION['cart'];
    if(count($cart)>0){
        $lama_pinjam=5; //satuan hari
        $tgl_harus_kembali=date('Y-m-d',mktime(0,0,0,date('m'),(date('d')+$lama_pinjam),date('Y')));
        mysqli_query($conn,"insert into peminjaman_buku (id_siswa,tanggal_pinjam,tanggal_kembali) value('".$_SESSION['id_siswa']."','".date('Y-m-d')."','".$tgl_harus_kembali."')");
         $id=mysqli_insert_id($conn);
        foreach ($cart as $key_produk => $val_produk) {
            mysqli_query($conn,"insert into detail_peminjaman_buku (id_peminjaman_buku,id_buku,qty) value('".$id."','".$val_produk['id_buku']."','".$val_produk['qty']."')");
        }
        unset($_SESSION['cart']);
        echo '<script>alert("Anda berhasil meminjam buku");location.href="histori_peminjaman.php"</script>';
    }
?>
Penjelasan:
di dalam proses checkout ini ada beberapa proses yang dijalankan secara berurutan, yang pertama system mengecek dahulu apakah cart mengandung data dengan sintak if(count($cart)>0){ . kemudian diset lama pinjam di variable $lama_pinjam. Setelah itu kita ambil tanggal lama pinjam dari waktu pinjam (tanggal sekarang + lama pinjam, ketemu tanggal setelah lama pinjam) dengan menggunakan sintak $tgl_harus_kembali=date('Y-m-d',mktime(0,0,0,date('m'),(date('d')+$lama_pinjam),date('Y')));. Kemudian kita insert data ke dalam table peminjaman. Lalu melakukan insert lagi ke table detail_peminjaman_buku semua item buku yang dipinjam. Setelah itu session yang Bernama cart dihapus dan langsung meredirect ke histori_peminjaman.php
•	Membuta Halaman Histori Peminjaman
17.	Buatlah file histori_peminjaman.php di xampp/htdocs/perpus_native
18.	Ketikkan sintak berikut:
<?php 
    include "header.php";
?>
<h2>Histori Peminjaman Buku</h2>
<table class="table table-hover table-striped">
    <thead>
        <th>NO</th><th>Tanggal Pinjam</th><th>Tanggal harus Kembali</th><th>Nama Buku</th><th>Status</th><th>Aksi</th>
    </thead>
    <tbody>
        <?php 
        include "koneksi.php";
        $qry_histori=mysqli_query($conn,"select * from peminjaman_buku order by id_peminjaman_buku desc");
        $no=0;
        while($dt_histori=mysqli_fetch_array($qry_histori)){
            $no++;
            //menampilkan buku yang dipinjam
            $buku_dipinjam="<ol>";
            $qry_buku=mysqli_query($conn,"select * from  detail_peminjaman_buku join buku on buku.id_buku=detail_peminjaman_buku.id_buku where id_peminjaman_buku = '".$dt_histori['id_peminjaman_buku']."'");
            while($dt_buku=mysqli_fetch_array($qry_buku)){
                $buku_dipinjam.="<li>".$dt_buku['nama_buku']."</li>";
            }
            $buku_dipinjam.="</ol>";
            //menampilkan status sudah kembali atau belum
            $qry_cek_kembali=mysqli_query($conn,"select * from pengembalian_buku where id_peminjaman_buku = '".$dt_histori['id_peminjaman_buku']."'");
            if(mysqli_num_rows($qry_cek_kembali)>0){
                $dt_kembali=mysqli_fetch_array($qry_cek_kembali);
                $denda="denda Rp. ".$dt_kembali['denda'];
                $status_kembali="<label class='alert alert-success'>Sudah kembali <br>".$denda."</label>";
                $button_kembali="";
            } else {
                $status_kembali="<label class='alert alert-danger'>Belum kembali</label>";
                $button_kembali="<a href='kembali.php?id=".$dt_histori['id_peminjaman_buku']."' class='btn btn-warning' onclick='return confirm(\"hello\")'>Kembalikan</a>";
            }
        ?>
            <tr>
                <td><?=$no?></td><td><?=$dt_histori['tanggal_pinjam']?></td><td><?=$dt_histori['tanggal_kembali']?></td><td><?=$buku_dipinjam?></td><td><?=$status_kembali?></td><td><?=$button_kembali?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<?php 
    include "footer.php";
?>
Penjelasan:
Di tampilan histori peminjaman ini hanya menampilkan daftar histori transaksi peminjaman buku yang mengandung beberapa kolom peminjaman antara lain tanggal pinjam, tanggal Kembali, buku yang dipinjam, status Kembali dan button aksi. 
•	Ujicoba 
19.	Di posisi tampilan keranjang, klik tombol check out maka akan redirect ke halaman histori peminjaman seperti tampilan dibawah ini:
 
•	Membuat proses pengembalian buku
20.	Buatlah file kembali.php di xampp/htdocs/perpus_native
21.	Ketikkan sintak berikut:
<?php 
if($_GET['id']){
    include "koneksi.php";
    $id_peminjaman_buku=$_GET['id'];
    $cek_terlambat=mysqli_query($conn, "select * from peminjaman_buku where id_peminjaman_buku = '".$id_peminjaman_buku."' ");
    $dt_pinjam=mysqli_fetch_array($cek_terlambat);
    if(strtotime($dt_pinjam['tanggal_kembali'])>=strtotime(date('Y-m-d'))){
        $denda=0;
    } else{
        $harga_denda_perhari=5000;
        $tanggal_kembali = new DateTime();
        $tgl_harus_kembali = new DateTime($dt_pinjam['tanggal_kembali']); 
        $selisih_hari = $tanggal_kembali->diff($tgl_harus_kembali)->d;
        $denda=$selisih_hari*$harga_denda_perhari;
    }
    mysqli_query($conn, "insert into pengembalian_buku (id_peminjaman_buku, tanggal_pengembalian,denda) value('".$id_peminjaman_buku."','".date('Y-m-d')."','".$denda."')");
    header('location: histori_peminjaman.php');
}
?>
Penjelasan:
Di proses pengembalian buku ini ada beberapa proses yang dilakukan secara berurutan yang pertama adalah pengecekan tanggal Kembali dengan sintak seperti ini if(strtotime($dt_pinjam['tanggal_kembali'])>=strtotime(date('Y-m-d'))){ ini berarti jika tanggal target kembali lebih besar dari tanggal sekarang maka denda 0, tetapi jika sebaliknya maka denda sebesar 5.000 rupiah perharinya. Kemudian kita hitung lama harinya dengan sintak berikut $selisih_hari = $tanggal_kembali->diff($tgl_harus_kembali)->d; lalu kita hitung dendanya dengan sintak ini
        $denda=$selisih_hari*$harga_denda_perhari; baru kita melakukan insert ke table pengembalian_buku setelah itu akan diredirect ke histori_peminjaman.php

•	Ujicoba
22.	Di posisi tampilan histori peminjaman, klik tombol kembalikan maka akan tampil alert seperti dibawah ini :
 
23.	Klik OK untuk meneruskan eksekusinya. Maka akan berubah status peminjamannya menjadi sudah Kembali denda Rp. 0. Jika waktu mengembalikan melewati batas waktu pengembalian maka akan muncul dendanya. Tampilannya seperti dibawah ini:
 

•	Tugas

1.	Lanjutkan tugas sebelumnya terkait toko online, buatlah transaksi seperti tutorial diatas!


