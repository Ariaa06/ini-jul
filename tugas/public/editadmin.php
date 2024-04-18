<?php
$servername = "localhost";
$username = "username";
$password = "password";
$database = "penilaian";

$kon = new mysqli($servername, $username, $password, $database);
if ($kon->connect_error) {
    die("Koneksi gagal: " . $kon->connect_error);
}
$id_admin = "";
$username_admin = "";

if(isset($_POST['update'])){
    $id_admin = $_POST['id_admin'];
    $username_admin = $_POST['username'];
    $password_admin = $_POST['password'];

    // Enkripsi password sebelum disimpan ke database
    $hashed_password = password_hash($password_admin, PASSWORD_DEFAULT);

    $result = mysqli_query($kon, "UPDATE admin SET username='$username_admin', password='$hashed_password' WHERE id_admin='$id_admin'");
    
    if($result) {
        header("Location: dashboard.html");
    } else {
        echo "Gagal Update Data.";
    }
}

if(isset($_GET['id_admin']) && is_numeric($_GET['id_admin'])){
    $id_admin = $_GET['id_admin'];

    $sql = "SELECT * FROM admin WHERE id_admin='$id_admin'";
    $ambildata = $kon->query($sql);

    if ($ambildata) {
        $result = mysqli_fetch_array($ambildata);
        if ($result) {
            $username_admin = $result['username'];
            // Password tidak ditampilkan untuk keamanan
        } else {
            echo "Data admin tidak ditemukan.";
        }
    } else {
        echo "Gagal mengambil data admin.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Tambahkan style untuk latar belakang dengan gradient */
        body {
            background: linear-gradient(to right, #FBD3E9, #BBE1FA);
        }
    </style>
</head>
<body class="p-10">
    <h1 class="text-3xl font-bold mb-6">Edit Data Admin</h1>

    <form name="update_data" method="post" action="editadmin.php">
        <input type="hidden" name="id_admin" value="<?php echo $id_admin ?>">
        <table class="border-collapse border border-blue-500" style="width: 100%;">
            <tr>
                <td class="border border-blue-500 p-2">Username</td>
                <td class="border border-blue-500 p-2">
                    <input type="text" name="username" value="<?php echo $username_admin ?>" class="w-full">
                </td>
            </tr>
            <tr>
                <td class="border border-blue-500 p-2">Password</td>
                <td class="border border-blue-500 p-2">
                    <input type="password" name="password" placeholder="Masukkan password baru" class="w-full">
                </td>
            </tr>
        </table>
        <input type="submit" name="update" value="Update" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 cursor-pointer">
    </form>
</body>
</html>
