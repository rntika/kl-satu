<?php
include 'koneksi.php';
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM siswa WHERE id=$id"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <style> 
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 400px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #0056b3;
        }
        img {
            display: block;
            max-width: 100px;
            margin-top: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit data siswa</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Nama</label>
        <input type="text" name="nama" value="<?= $data['nama'] ?>">

        <label>kelas</label>
        <input type="text" name="kelas" value="<?= $data['kelas'] ?>">

        <label>jurusan</label>
        <input type="text" name="jurusan" value="<?= $data['jurusan'] ?>">

        <label>email</label>
        <input type="text" name="email" value="<?= $data['email'] ?>">

        <label>no_hp</label>
        <input type="text" name="no_hp" value="<?= $data['no_hp'] ?>">

        <label>Foto</label>
        <input type="file" name="foto">
        <br>
        <img src="uploads/<?= $data['foto'] ?>" alt="Foto lama">

        <input type="submit" name="update" value="Update">
    </form>
</div>

<?php
if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $jurusan= $_POST['jurusan'];
    $email= $_POST['email'];
    $no_hp= $_POST['no_hp'];

    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        move_uploaded_file($tmp, "uploads/" . $foto);
    } else {
        $foto = $data['foto']; 
    }

    $query = "UPDATE siswa SET nama='$nama', kelas='$kelas', jurusan='$jurusan', email='$email', no_hp='$no_hp', foto='$foto' WHERE id=$id";
    if (mysqli_query($koneksi, $query)) {
        echo "<p style='text-align:center;color:green;'>Data berhasil diupdate. <a href='index.php'>Kembali</a></p>";
    } else {
        echo "<p style='text-align:center;color:red;'>Gagal update data.</p>";
    }
}
?>
</body>
</html>
