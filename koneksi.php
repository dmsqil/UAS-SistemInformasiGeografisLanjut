<?php

$host = "localhost";
$user = "root";
$password = "";
// $db = "poi-db"; //mariconf
$db = "poi_db";

$kon = new mysqli($host, $user, $password, $db);
if ($kon->connect_error) {
   die("Koneksi Gagal:" . $kon->connect_error);
}

$url = "http://" . $_SERVER['HTTP_HOST'] . "/sig-l/";

// function isActive($url)
// {
//    return ($_SERVER['REQUEST_URI'] === "/dimasaqil/sig-lanjut/" . $url) ? 'active' : '';
// }
