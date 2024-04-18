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

if (isset($_GET['id_siswa'])) {
    $id_siswa = $_GET['id_siswa'];
    $deletedata = $kon->query("DELETE FROM siswa WHERE id_siswa=$id_siswa");
    if ($deletedata) {
        echo 'Data berhasil dihapus.';
    } else {
        echo 'Gagal menghapus data.';
    }
    header("Location: ../public/siswa.php");
    exit(); // Pastikan tidak ada kode yang dieksekusi setelah melakukan redirect
}
?>
