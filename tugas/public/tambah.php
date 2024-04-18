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

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $jenis_kelamin = $_POST['jenis_kelamin'];

    $sql = "INSERT INTO siswa (nama, kelas, jenis_kelamin) VALUES ('$nama', '$kelas', '$jenis_kelamin')";

    if ($kon->query($sql) === TRUE) {
        $last_id = $kon->insert_id;
        echo "Data siswa berhasil ditambahkan. <a href='siswa.php'>Lihat Data Siswa</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $kon->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tambah Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Tambahkan style untuk latar belakang dengan gradient */
        body {
            background: linear-gradient(to right, #FBD3E9, #BBE1FA);
        }
    </style>
</head>
<body class="p-10">
    <h1 class="text-3xl font-bold mb-6">Tambah Data Siswa</h1>
    <a href="../public/siswa.php" class="text-blue-500 hover:underline">Back to table</a>

    <form action="tambah.php" method="post" name="tambahsiswa" class="mt-8">
        <table class="border-collapse border border-blue-500" style="width: 100%;">
            <tr>
                <td class="border border-blue-500 p-2">Nama</td>
                <td class="border border-blue-500 p-2"><input type="text" name="nama" class="w-full"></td>
            </tr>
            <tr>
                <td class="border border-blue-500 p-2">Kelas</td>
                <td class="border border-blue-500 p-2"><input type="text" name="kelas" class="w-full"></td>
            </tr>
            <tr>
                <td class="border border-blue-500 p-2">Jenis Kelamin</td>
                <td class="border border-blue-500 p-2">
                    <select name="jenis_kelamin" class="w-full">
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </td>
            </tr>
        </table>
        <input type="submit" name="submit" value="Tambah Data" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 cursor-pointer">
    </form>
</body>
</html>
