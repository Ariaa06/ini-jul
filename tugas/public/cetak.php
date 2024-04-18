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

require('../database/library/fpdf.php'); // Sesuaikan dengan struktur folder Anda

//pengaturan halaman pdf
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();

//judul
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'DATA SISWA', 0, 1, 'C');

//header tabel
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 7, 'No', 1, 0, 'C');
$pdf->Cell(40, 7, 'ID Siswa', 1, 0, 'C');
$pdf->Cell(60, 7, 'Nama', 1, 0, 'C');
$pdf->Cell(40, 7, 'Kelas', 1, 0, 'C');
$pdf->Cell(40, 7, 'Jenis Kelamin', 1, 1, 'C');

//query data siswa
$no = 1;
$query = "SELECT * FROM siswa";
$result = $kon->query($query);

//menampilkan data
if ($result->num_rows > 0) {
    $pdf->SetFont('Arial', '', 10);
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(10, 7, $no++, 1, 0, 'C');
        $pdf->Cell(40, 7, $row['id_siswa'], 1, 0);
        $pdf->Cell(60, 7, $row['nama'], 1, 0);
        $pdf->Cell(40, 7, $row['kelas'], 1, 0);
        $pdf->Cell(40, 7, $row['jenis_kelamin'], 1, 1);
    }
} else {
    $pdf->Cell(0, 10, 'Tidak ada data siswa', 0, 1, 'C');
}

$pdf->Output();
?>
