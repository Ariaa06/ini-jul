<?php
$servername = "localhost";
$username = "username";
$password = "password";
$database = "penilaian";

$kon = new mysqli($servername, $username, $password, $database);

if ($kon->connect_error) {
    die("Koneksi gagal: " . $kon->connect_error);
}

class Siswa
{
    private $id_siswa;
    private $tugas;
    private $mid;
    private $final;

    public function __construct($id_siswa, $tugas, $mid, $final)
    {
        $this->id_siswa = $id_siswa;
        $this->tugas = $tugas;
        $this->mid = $mid;
        $this->final = $final;
    }

    //hitung nilai akhir berdasarkan bobot masing-masing
    public function hitungNilaiAkhir()
    {
        return ($this->tugas * 0.3) + ($this->mid * 0.3) + ($this->final * 0.4);
    }
}

class Transaksi
{
    private $siswa;
    private $nilai;

    public function __construct(Siswa $siswa)
    {
        $this->siswa = $siswa;
        $this->hitungNilaiPersentaseKegagalan();
    }
    //hitung nilai
    private function hitungNilaiPersentaseKegagalan()
    {
        $nilai_akhir = $this->siswa->hitungNilaiAkhir();

        // logika perhitungan nilai disesuaikan dengan kebutuhan
        if ($nilai_akhir >= 85) {
            $this->nilai = 'A';
        } elseif ($nilai_akhir >= 75 && $nilai_akhir < 85) {
            $this->nilai = 'B';
        } else {
            $this->nilai = 'C';
        }
    }

    //get info nilai
    public function getInfo()
    {
        return "Nilai: {$this->nilai}<br>";
    }
}

// Form data processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_siswa = $_POST["id_siswa"];
    $tugas = $_POST["tugas"];
    $mid = $_POST["mid"];
    $final = $_POST["final"];

    try {
        // Periksa apakah siswa dengan ID yang dimasukkan ada dalam database
        $query = "SELECT nama FROM siswa WHERE id_siswa = ?";
        $stmt = $kon->prepare($query);
        $stmt->bind_param("s", $id_siswa);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nama_siswa = $row["nama"];

            // Buat objek siswa
            $siswa = new Siswa($id_siswa, $tugas, $mid, $final);
            // Buat objek transaksi
            $transaksi = new Transaksi($siswa);

            $info = "Nama Siswa: $nama_siswa<br>";
            $info .= $transaksi->getInfo();
        } else {
            $info = "Siswa dengan ID $id_siswa tidak ditemukan dalam database.";
        }
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Penilaian</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(to bottom right, #9AE6B4, #3B8070);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full p-8 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl mb-4">Penilaian Tugas Siswa</h2>
        <a href="dashboard.html" class="text-blue-500 hover:underline">Back to dashboard</a>
        <form method="post" action="" class="mb-4">
            <div class="mb-4">
                <label for="id_siswa" class="block text-sm font-medium text-gray-700">ID Siswa:</label>
                <input type="text" name="id_siswa" id="id_siswa" class="mt-1 p-2 w-full border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="tugas" class="block text-sm font-medium text-gray-700">Nilai Tugas:</label>
                <input type="number" name="tugas" id="tugas" class="mt-1 p-2 w-full border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="mid" class="block text-sm font-medium text-gray-700">Mid:</label>
                <input type="number" name="mid" id="mid" class="mt-1 p-2 w-full border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="final" class="block text-sm font-medium text-gray-700">Final:</label>
                <input type="number" name="final" id="final" class="mt-1 p-2 w-full border-gray-300 rounded-md">
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Hitung</button>
        </form>
        <?php if (isset($info)): ?>
            <div class="text-lg">
                <h2 class="text-xl mb-2">Hasil Perhitungan:</h2>
                <p><?php echo $info; ?></p>
            </div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
