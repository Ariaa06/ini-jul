<?php
session_start();

//untuk koneksi database
$servername = "localhost"; 
$username = "username"; 
$password = "password"; 
$database = "penilaian"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

class Login {
  private $conn;
  private $username;
  private $password;

  public function __construct($conn, $username, $password) {
    $this->conn = $conn;
    $this->username = $username;
    $this->password = $password;
  }

  public function prosesLogin() {
    $query = "SELECT password FROM admin WHERE username = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("s", $this->username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();
      if (password_verify($this->password, $row['password'])) {
        $_SESSION['username'] = $this->username;
        header("Location: public/dashboard.html");
        exit;
      } else {
        header("Location: index.php?error=1");
        exit;
      }
    } else {
      header("Location: index.php?error=1");
      exit;
    }
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['username']) && isset($_POST['password'])) {
    $username_input = $_POST['username'];
    $password_input = $_POST['password'];

    if (class_exists('Login')) {
      $login = new Login($conn, $username_input, $password_input);
      $login->prosesLogin();
    } else {
      echo "Error: Kelas Login tidak ditemukan.";
    }
  } else {
    header("Location: index.php");
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-pink-100 flex items-center justify-center h-screen">
    <div class="w-80">
        <div class="bg-white shadow-lg rounded-lg p-8">
            <h1 class="text-3xl text-center text-pink-500 font-bold mb-6">Penilaian tugas siswa</h1>
            <?php if(isset($_GET['error']) && $_GET['error'] == 1): ?>
            <p class="text-center text-red-500">Username atau password salah.</p>
            <?php endif; ?>
            <p class="text-center text-gray-600 mb-8">Silahkan masukkan username dan password</p>
            <form method="post" action="" class="space-y-4">
                <input class="w-full py-3 px-4 border border-gray-400 focus:outline-none rounded-md focus:ring-1 ring-cyan-500" type="text" name="username" placeholder="Username">
                <input class="w-full py-3 px-4 border border-gray-400 focus:outline-none rounded-md focus:ring-1 ring-cyan-400" type="password" name="password" placeholder="Password">
                <button type="submit" class="w-full bg-purple-500 text-white p-3 rounded-lg font-semibold text-lg">Login</button>
            </form>
            <hr>
            <p class="text-sm my-4 text-center">
                <span class="font-semibold">Khusus</span> untuk admin
            </p>
        </div>
    </div>
</body>

</html>
