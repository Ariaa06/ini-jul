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

if (isset($_GET['id_admin'])) {
    $id_admin = $_GET['id_admin'];
    
    // Hindari SQL Injection dengan menggunakan parameterized query
    $stmt = $kon->prepare("DELETE FROM admin WHERE id_admin = ?");
    $stmt->bind_param("i", $id_admin);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        echo 'Data berhasil dihapus.';
    } else {
        echo 'Gagal menghapus data.';
    }

    // Redirect kembali ke halaman admin.php setelah penghapusan data
    header("Location: ../public/admin.php");
    exit(); // Pastikan tidak ada kode yang dieksekusi setelah melakukan redirect
}
?>
