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

if(isset($_POST['update'])){
    $id_siswa = $_POST['id_siswa'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $jenis_kelamin = $_POST['jenis_kelamin'];

    $result = mysqli_query($kon, "UPDATE siswa SET nama='$nama', kelas='$kelas', jenis_kelamin='$jenis_kelamin' WHERE id_siswa=$id_siswa");
    
    if($result) {
        header("Location: siswa.php");
    } else {
        echo "Gagal Update Data.";
    }
}

if(isset($_GET['id_siswa']) && is_numeric($_GET['id_siswa'])){
    $id_siswa = $_GET['id_siswa'];

    $sql = "SELECT * FROM siswa WHERE id_siswa=$id_siswa";
    $ambildata = $kon->query($sql);

    if ($result = mysqli_fetch_array($ambildata)){
        $id_siswa = $result['id_siswa'];
        $nama = $result['nama'];
        $kelas = $result['kelas'];
        $jenis_kelamin = $result['jenis_kelamin'];
    } else {
        echo "ID tidak valid.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Tambahkan style untuk latar belakang dengan gradient */
        body {
            background: linear-gradient(to right, #FBD3E9, #BBE1FA);
        }
    </style>
</head>
<body class="p-10">
    <a href="../../index.php" class="text-blue-500 hover:underline">Home</a>
    <h1 class="text-3xl font-bold mb-6">Edit Data Siswa</h1>

    <form name="update_data" method="post" action="update.php">
        <table class="border-collapse border border-blue-500" style="width: 100%;">
            <tr>
                <td class="border border-blue-500 p-2">ID Siswa</td>
                <td class="border border-blue-500 p-2">
                    <input type="text" name="id_siswa" disabled value="<?php echo $id_siswa ?>">
                    <input type="hidden" name="id_siswa" value="<?php echo $id_siswa ?>">
                </td>
            </tr>
            <tr>
                <td class="border border-blue-500 p-2">Nama</td>
                <td class="border border-blue-500 p-2">
                    <input type="text" name="nama" value="<?php echo $nama ?>" class="w-full">
                </td>
            </tr>
            <tr>
                <td class="border border-blue-500 p-2">Kelas</td>
                <td class="border border-blue-500 p-2">
                    <input type="text" name="kelas" value="<?php echo $kelas ?>" class="w-full">
                </td>
            </tr>
            <tr>
                <td class="border border-blue-500 p-2">Jenis Kelamin</td>
                <td class="border border-blue-500 p-2">
                    <select name="jenis_kelamin" class="w-full">
                        <option value="Laki-laki" <?php if($jenis_kelamin == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                        <option value="Perempuan" <?php if($jenis_kelamin == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                    </select>
                </td>
            </tr>
        </table>
        <input type="submit" name="update" value="Update" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 cursor-pointer">
        </body>
</html>
