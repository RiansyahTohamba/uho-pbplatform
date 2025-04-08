<?php
session_start();
$_SESSION = array();
session_destroy();
$is_login = isset($_SESSION['nama']);
echo "masih login? $is_login";
?>