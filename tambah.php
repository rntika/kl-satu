<?php

include 'koneksi.php'; 


if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $jurusan = $_POST['jurusan'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];

    $nama = htmlspecialchars($nama, ENT_QUOTES, 'UTF-8'); 
    
    $target_dir = "img/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $foto = $_FILES['foto']['name'];
    $tmp_name = $_FILES['foto']['tmp_name'];
    $target_file = $target_dir . basename($foto);



    $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
    $file_ext = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (in_array($file_ext, $allowed_types)) {
        if (move_uploaded_file($tmp_name, $target_file)) {
            // Simpan ke database
            $sql = "INSERT INTO data_siswa (nama, kelas, jurusan, email, no_hp, foto) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ssssss", $nama, $kelas, $jurusan, $email, $no_hp, $foto); // 'i' untuk integer $stok
                if ($stmt->execute()) {
                    header("Location: index.php");
                    exit;
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Tipe file tidak diijinkan.";
    }
}


$sql = "SELECT * FROM data_siswa";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Barang</title>
</head>
<body>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">INSERT Data Barang</h2>

        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <label class="block mb-2">nama</label>
            <input type="text" name="nama" required
                class="w-full px-4 py-2 border border-gray-500 rounded-lg focus:ring focus:ring-green-200" />
            <label class="block mb-2">kelas</label>
            <input type="text" name="kelas" required
                class="w-full px-4 py-2 border border-gray-500 rounded-lg focus:ring focus:ring-green-200" />
            <label class="block mb-2">jurusan</label>
            <input type="text" name="jurusan" required
                class="w-full px-4 py-2 border border-gray-500 rounded-lg focus:ring focus:ring-green-200" />
            <label class="block mb-2">email</label>
            <input type="text" name="email" required
                class="w-full px-4 py-2 border border-gray-500 rounded-lg focus:ring focus:ring-green-200" />
            <label class="block mb-2">no_hp</label>
            <input type="text" name="no_hp" required
                class="w-full px-4 py-2 border border-gray-500 rounded-lg focus:ring focus:ring-green-200" />

            <div>
                <label class="block mb-2">Foto Saat Ini:</label>
                <input type="file" name="foto"
                    class="w-full px-4 py-2 border border-gray-500 rounded-lg focus:ring focus:ring-green-200" />
            </div>

            <button type="submit" name="submit"
                class="w-full bg-pink-500 text-white py-2 rounded-lg hover:bg-pink-600 font-semibold">
                Simpan Perubahan
            </button>
        </form>
    </div>

