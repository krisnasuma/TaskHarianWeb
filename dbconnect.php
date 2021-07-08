<?php

//definisikan terdahulu identitas localhost kita
//buat variable yang mudah dimengerti
$host = "localhost";
$user = "root"; //login mysql
$password = ""; //password login mysql
$dbname = "dbtodo"; //nama database yang sudah dibuat

$connection = mysqli_connect($host,$user,$password,$dbname);

//lakukan pengujian, bisa dihilangkan tanda komentar nya

//if ($connection) {
//    echo 'Koneksi Sukses';
//}else{
//    echo 'Gagal Koneksi';
//}

?>