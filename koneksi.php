<?php
$toko=mysqli_connect('localhost','root','','tokoatk');
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>