<?php
$conn = mysqli_connect("localhost","root","","data_siswa");
if (!$conn) {
    die("koneksi database gagal: " .mysqli_connect_error());
}
?>