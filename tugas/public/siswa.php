<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Data Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-blue-200 to-pink-100 h-screen flex items-center justify-center">
<?php
$servername = "localhost"; 
$username = "username"; 
$password = "password"; 
$database = "penilaian"; 

// Membuat koneksi
$kon = new mysqli($servername, $username, $password, $database);

// Memeriksa koneksi
if ($kon->connect_error) {
    die("Koneksi gagal: " . $kon->connect_error);
}
?>

    <div class="w-full sm:w-3/4 md:w-2/3 lg:w-1/2 xl:w-1/3">
        <h5 class="text-xl font-bold mb-6">Data Siswa</h5>
        <a href="tambah.php" class="text-blue-500 hover:underline">Tambah Data</a> |
        <a href="cetak.php" target="_blank" class="text-blue-500 hover:underline">Pdf</a> |
        <a href="dashboard.html" class="text-blue-500 hover:underline">Home</a>

        <!-- Tambahkan search bar -->
        <form action="" method="GET" class="mt-4 mb-4">
            <input type="text" name="keyword" placeholder="Cari Nama Siswa" class="p-2 border border-gray-400 rounded-md">
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Cari</button>
        </form>

        <table class="w-full mt-4 border-collapse border border-gray-400 p-8">
            <tr>
                <th class="border border-gray-400 px-4 py-2">ID Siswa</th>
                <th class="border border-gray-400 px-4 py-2">Nama</th>
                <th class="border border-gray-400 px-4 py-2">Kelas</th>
                <th class="border border-gray-400 px-4 py-2">Jenis Kelamin</th>
                <th class="border border-gray-400 px-6 py-4">Aksi</th>
            </tr>
            <?php
            // Tangkap input keyword pencarian
            $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
            
            // Modifikasi query untuk mencari data berdasarkan keyword
            $query = "SELECT * FROM siswa WHERE nama LIKE '%$keyword%' ORDER BY id_siswa ASC";
            $ambilData = mysqli_query($kon, $query);

            while ($userAmbilData = mysqli_fetch_array($ambilData)){
                echo "<tr>";
                echo "<td class='border border-gray-400 px-4 py-2'>" .$userAmbilData['id_siswa']. "</td>";
                echo "<td class='border border-gray-400 px-4 py-2'>" .$userAmbilData['nama']. "</td>";
                echo "<td class='border border-gray-400 px-4 py-2'>" .$userAmbilData['kelas']. "</td>";
                echo "<td class='border border-gray-400 px-4 py-2'>" .$userAmbilData['jenis_kelamin']. "</td>";
                echo "<td class='border border-gray-400 px-4 py-2'>
                <a href='update.php?id_siswa=$userAmbilData[id_siswa]' class='text-blue-500 hover:underline'>Edit</a> |
                <a href='delete.php?id_siswa=$userAmbilData[id_siswa]' class='text-blue-800 hover:underline'>Hapus</a>
                </td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
