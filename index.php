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

<main class="ml-64 p-8 bg-gray-50 min-h-screen">  
    <div class="max-w-7xl mx-auto bg-white shadow-md rounded-xl p-6">    
        <!-- Header -->    
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">    
            <h2 class="text-2xl font-bold text-gray-800">Daftar Siswa</h2>    
            
       
            <a href="tambah.php" 
               class="inline-flex items-center px-4 py-2 bg-green-500 text-white text-sm font-medium rounded-lg shadow hover:bg-green-600 transition duration-200">
                + Tambah Data
            </a>
        </div>    

         
        <div class="overflow-x-auto">    
            <table class="w-full border border-gray-200 rounded-lg">    
                <thead class="bg-gray-100 text-gray-700">    
                    <tr>    
                        <th class="px-4 py-3 text-left text-sm font-semibold">No</th>    
                        <th class="px-4 py-3 text-left text-sm font-semibold">Nama</th>    
                        <th class="px-4 py-3 text-left text-sm font-semibold">Foto</th>    
                        <th class="px-4 py-3 text-left text-sm font-semibold">Kelas</th>    
                        <th class="px-4 py-3 text-left text-sm font-semibold">Jurusan</th>    
                        <th class="px-4 py-3 text-left text-sm font-semibold">Email</th>    
                        <th class="px-4 py-3 text-left text-sm font-semibold">No.Hp</th>    
                        <th class="px-4 py-3 text-center text-sm font-semibold">Aksi</th>    
                    </tr>    
                </thead>    
                <tbody class="bg-white divide-y divide-gray-200">    
                    <?php    
                    $no = 1;    
                    if ($result->num_rows > 0) {    
                        while ($row = $result->fetch_assoc()) { ?>    
                            <tr class="hover:bg-gray-50 transition duration-150">    
                                <td class="px-4 py-3"><?php echo $no++ ?></td>    
                                <td class="px-4 py-3 font-medium text-gray-800"><?php echo htmlspecialchars($row['nama']) ?></td>    
                                <td class="px-4 py-3">
                                    <img src="img/<?php echo $row['foto']; ?>" alt="Foto Siswa"    
                                         class="w-20 h-20 object-cover rounded border border-gray-300 shadow-sm">    
                                </td>    
                                <td class="px-4 py-3"><?php echo htmlspecialchars($row['kelas']) ?></td>    
                                <td class="px-4 py-3"><?php echo htmlspecialchars($row['jurusan']) ?></td>    
                                <td class="px-4 py-3"><?php echo htmlspecialchars($row['email']) ?></td>    
                                <td class="px-4 py-3"><?php echo htmlspecialchars($row['no_hp']) ?></td>    
                                <td class="px-4 py-3 whitespace-nowrap align-middle">    
                                    <div class="flex justify-center items-center gap-3">    
                                        <!-- Tombol Update -->    
                                        <a href="update.php?id=<?php echo $row['id_siswa'] ?>"    
                                           class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 hover:text-blue-700 transition duration-200"    
                                           title="Edit">    
                                           <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L7.5 21H3v-4.5L16.732 3.732z" />
                                           </svg>
                                        </a>    

                                           
                                        <a href="delete.php?id=<?php echo $row['id_siswa'] ?>"    
                                           onclick="return confirm('Yakin ingin menghapus data ini?')"    
                                           class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 hover:text-red-700 transition duration-200"    
                                           title="Hapus">    
                                           <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                               <path d="M9 3a1 1 0 0 0-1 1v1H4.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H16v-1a1 1 0 0 0-1-1H9zM6 7v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6z" />
                                           </svg>
                                        </a>    
                                    </div>    
                                </td>    
                            </tr>    
                        <?php }    
                    } else { ?> 
                        <tr>    
                            <td colspan="8" class="px-4 py-4 text-center text-gray-500">Belum ada data siswa.</td>    
                        </tr>    
                    <?php } ?>    
                </tbody>    
            </table>    
        </div>    
    </div>  
</main>
