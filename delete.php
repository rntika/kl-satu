<?php
include 'koneksi.php';

if (isset($_GET['id_siswa'])) {
    $id = $_GET['id_siswa'];

    $query = "DELETE FROM siswa WHERE id_siswa = '$id_siswa'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Data berhasil dihapus!'); window.location='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "ID tidak ditemukan.";
}
?>
