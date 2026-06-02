<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konversi Nilai</title>
</head>
<body>
    <h2>Form Konversi Nilai</h2>
    <form method="GET" action="konversi_nilai.php">
    <label>Masukkan Nilai (0-100):</label>
    <input type="number" name="nilai" min="0" max="100" required>
    <button type="submit">Konversi</button>
</form>
<?php
// Nilai dikirim lewat query string
if (isset($_GET['nilai'])) {
    
    // Ambil nilai dari URL dan ubah menjadi angka
    $nilai = (int) $_GET['nilai'];
    
    // Tentukan grade, deskripsi, dan warna berdasarkan nilai
    if ($nilai >= 85) {
        $grade = "A";
        $deskripsi = "Sangat Baik";
        $warna = "darkgreen";
    } elseif ($nilai >= 70) {
        $grade = "B";
        $deskripsi = "Baik";
        $warna = "blue";
    } elseif ($nilai >= 60) {
        $grade = "C";
        $deskripsi = "Cukup";
        $warna = "orange";
    } elseif ($nilai >= 50) {
        $grade = "D";
        $deskripsi = "Kurang";
        $warna = "darkorange";
    } else {
        $grade = "E";
        $deskripsi = "Sangat Kurang";
        $warna = "red";
    }
    
    // Tampilkan hasil konversi
    echo "<h3>Hasil Konversi:</h3>";
    echo "<p>Nilai Anda: <strong>$nilai</strong></p>";
    echo "<p>Grade: <strong style='color: $warna; font-size: 24px;'>$grade</strong></p>";
    echo "<p>Deskripsi: <strong style='color: $warna;'>$deskripsi</strong></p>";
}
?>
</body>
</html>

