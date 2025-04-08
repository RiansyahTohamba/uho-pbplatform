<?php
session_start();

if(isset($_SESSION['nama'])){
    $nama = $_SESSION['nama'];
    echo "selamat datang $nama";
}else{
    echo "lakukan login dulu di halaman login.php";
}