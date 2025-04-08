<?php
session_start();
$_SESSION['nama'] = 'riansyah';
$is_login = isset($_SESSION['nama']);
$lain = isset($_SESSION['judul']);
echo "session nama=$is_login<br>";
echo "session lain=$lain";

?>