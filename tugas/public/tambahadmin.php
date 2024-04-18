<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$servername = "localhost"; 
$username = "username"; 
$password = "password"; 
$database = "penilaian"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_admin = $_POST['username'];
    $password_admin = $_POST['password'];

    // Enkripsi password sebelum disimpan ke database
    $hashed_password = password_hash($password_admin, PASSWORD_DEFAULT);

    $sql = "INSERT INTO admin (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username_admin, $hashed_password);

    if ($stmt->execute()) {
        $last_id = $conn->insert_id;
        echo "Data admin berhasil ditambahkan. <a href='admin.php'>Lihat Data Admin</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tambah Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Tambahkan style untuk latar belakang dengan gradient */
        body {
            background: linear-gradient(to right, #FBD3E9, #BBE1FA);
        }
    </style>
</head>
<body class="p-10">
    <h1 class="text-3xl font-bold mb-6">Tambah Data Admin</h1>
    <a href="../public/admin.php" class="text-blue-500 hover:underline">Back to table</a>

    <form action="tambahadmin.php" method="post" name="tambahadmin" class="mt-8">
    <table class="border-collapse border border-blue-500" style="width: 100%;">
        <tr>
            <td class="border border-blue-500 p-2">Username</td>
            <td class="border border-blue-500 p-2"><input type="text" name="username" placeholder="enter username" class="w-full"></td>
        </tr>
        <tr>
            <td class="border border-blue-500 p-2">Password</td>
            <td class="border border-blue-500 p-2"><input type="password" name="password" placeholder="enter password" class="w-full"></td>
        </tr>
    </table>
    <input type="submit" name="submit" value="Tambah Data" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 cursor-pointer">
</form>

</body>
</html>
