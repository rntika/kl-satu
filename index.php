<?php    
include 'koneksi.php';    

if (isset($_POST['tambah'])) {    
    $nama    = $_POST['nama'];    
    $kelas   = $_POST['kelas'];    
    $jurusan = $_POST['jurusan'];    
    $email   = $_POST['email'];    
    $no_hp   = $_POST['no_hp'];    

    $foto = $_FILES['foto']['name'];    
    $tmp_name = $_FILES['foto']['tmp_name'];    

    $target_dir = "img/";    
    if (!is_dir($target_dir)) {    
        mkdir($target_dir, 0777, true);    
    }    
    $target_file = $target_dir . basename($foto);    
    move_uploaded_file($tmp_name, $target_file);    
    
    $sql = "INSERT INTO data_siswa (nama, foto, kelas, jurusan, email, no_hp) VALUES (?, ?, ?, ?, ?, ?)";    
    $stmt = $conn->prepare($sql);    
    $stmt->bind_param("ssssss", $nama, $foto, $kelas, $jurusan, $email, $no_hp);    
    $stmt->execute();    
    
    header("Location: index.php");    
    exit;    
}    

$sql = "SELECT * FROM data_siswa";    
$result = $conn->query($sql);    
?>    

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Siswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main>
    <div class="container">    
        <div class="header">    
            <h2>Daftar Siswa</h2>    
            <a href="tambah.php" class="btn-add">+ Tambah Data</a>
        </div>    

        <div class="table-container">    
            <table>    
                <thead>    
                    <tr>    
                        <th>No</th>    
                        <th>Nama</th>    
                        <th>Foto</th>    
                        <th>Kelas</th>    
                        <th>Jurusan</th>    
                        <th>Email</th>    
                        <th>No.Hp</th>    
                        <th>Aksi</th>    
                    </tr>    
                </thead>    
                <tbody>    
                    <?php    
                    $no = 1;    
                    if ($result->num_rows > 0) {    
                        while ($row = $result->fetch_assoc()) { ?>    
                            <tr>    
                                <td><?php echo $no++ ?></td>    
                                <td><?php echo htmlspecialchars($row['nama']) ?></td>    
                                <td>
                                    <img src="img/<?php echo $row['foto']; ?>" alt="Foto Siswa" class="foto">
                                </td>    
                                <td><?php echo htmlspecialchars($row['kelas']) ?></td>    
                                <td><?php echo htmlspecialchars($row['jurusan']) ?></td>    
                                <td><?php echo htmlspecialchars($row['email']) ?></td>    
                                <td><?php echo htmlspecialchars($row['no_hp']) ?></td>    
                                <td class="aksi">    
                                    <a href="update.php?id=<?php echo $row['id_siswa'] ?>" class="btn-edit">Edit</a>    
                                    <a href="delete.php?id=<?php echo $row['id_siswa'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn-delete">Hapus</a>    
                                </td>    
                            </tr>    
                        <?php }    
                    } else { ?> 
                        <tr>    
                            <td colspan="8" class="no-data">Belum ada data siswa.</td>    
                        </tr>    
                    <?php } ?>    
                </tbody>    
            </table>    
        </div>    
    </div>  
</main>
</body>
</html>
