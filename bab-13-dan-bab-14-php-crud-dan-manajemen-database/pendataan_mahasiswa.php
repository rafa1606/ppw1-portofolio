<?php
function bersihkan($input): string {
    $input = trim($input);                  // buang spasi di depan/ belakang
    $input = stripslashes($input);          // hapus backslash yang nggak perlu
    $input = htmlspecialchars($input);      // ubah karakter HTML jadi teks biasa
    return $input;
}

// Siapkan list error dan hasil
$errors = [];
$sukses = false;
$data = [];

// Pastikan data datang lewat POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Ambil input dari form
    $nama     = bersihkan($_POST['nama'] ?? '');
    $nim      = bersihkan($_POST['nim'] ?? '');
    $prodi    = bersihkan($_POST['prodi'] ?? '');
    $ipk      = (float) ($_POST['ipk'] ?? 0);
    $semester = (int) ($_POST['semester'] ?? 0);
    
    // Validasi input
    
    // Cek nama dulu
    if (empty($nama)) {
        $errors[] = "Nama tidak boleh kosong.";
    } elseif (strlen($nama) < 3) {
        $errors[] = "Nama minimal 3 karakter.";
    } elseif (strlen($nama) > 100) {
        $errors[] = "Nama maksimal 100 karakter.";
    }

    // Cek NIM
    if (empty($nim)) {
        $errors[] = "NIM tidak boleh kosong.";
    }

    // Cek prodi
    if (empty($prodi)) {
        $errors[] = "Program Studi harus dipilih.";
    }
    // Cek IPK
    if ($ipk <= 0) {
        $errors[] = "IPK tidak boleh kosong atau 0.";
    } elseif ($ipk < 0 || $ipk > 4) {
        $errors[] = "IPK harus antara 0.00 dan 4.00.";
    }

    // Cek semester
    if ($semester < 1 || $semester > 14) {
        $errors[] = "Semester harus antara 1 dan 14.";
    }
    
    // Kalau semua oke, proses data
    if (empty($errors)) {
        $sukses = true;
        
        // Tentukan kategori IPK
        if ($ipk >= 3.51) {
            $predikat = "Cumlaude";
            $warnaPredikat = "green";
        } elseif ($ipk >= 3.01) {
            $predikat = "Sangat Memuaskan";
            $warnaPredikat = "blue";
        } elseif ($ipk >= 2.76) {
            $predikat = "Memuaskan";
            $warnaPredikat = "orange";
        } else {
            $predikat = "Belum Memuaskan";
            $warnaPredikat = "red";
        }
        
        // Simpan data ke array buat ditampilin
        $data = [
            'nama'     => $nama,
            'nim'      => $nim,
            'prodi'    => $prodi,
            'ipk'      => $ipk,
            'semester' => $semester,
            'predikat' => $predikat,
            'warna'    => $warnaPredikat,
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Pendataan Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h2 {
            color: #333;
            border-bottom: 3px solid #007bff;
            padding-bottom: 10px;
        }
        .form-container {
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }
        button {
            margin-top: 20px;
            padding: 10px 25px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error-box {
            background-color: #ffe6e6;
            color: #d8000c;
            border: 2px solid #d8000c;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .success-box {
            background-color: #e6ffe6;
            color: #006600;
            border: 2px solid #006600;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
            background-color: white;
        }
        table td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        table td:first-child {
            background-color: #f0f0f0;
            font-weight: bold;
            width: 30%;
        }
    </style>
</head>
<body>

    <h2>Form Pendataan Mahasiswa</h2>
    
    <div class="form-container">
        
        <!-- ============ FORM ============ -->
        <form method="POST" action="pendataan_mahasiswa.php">
            
            <label>Nama Lengkap:</label>
            <input type="text" name="nama" placeholder="Masukan Nama Lengkap" required>
            
            <label>NIM:</label>
            <input type="text" name="nim" placeholder="Masukkan NIM Anda" required>
            
            <label>Program Studi:</label>
            <select name="prodi" required>
                <option value="">-- Pilih Prodi --</option>
                <option value="Teknologi Rekayasa Perangkat Lunak">Teknologi Rekayasa Perangkat Lunak</option>
                <option value="Teknologi Rekayasa Internet">Teknologi Rekayasa Internet</option>
                <option value="Teknik Elektro">Teknik Elektro</option>
                <option value="Manajemen">Manajemen</option>
                <option value="Akuntansi">Akuntansi</option>
            </select>
            
            <label>IPK (0.00 - 4.00):</label>
            <input type="number" name="ipk" step="0.01" min="0" max="4" placeholder="Contoh: 3.75" required>
            
            <label>Semester (1 - 14):</label>
            <input type="number" name="semester" min="1" max="14" placeholder="Contoh: 5" required>
            
            <button type="submit">Simpan Data</button>
        </form>
    </div>
    
    <!-- ============ TAMPILKAN ERROR ============ -->
    <?php if (!empty($errors)): ?>
        <div class="error-box">
            <strong>Terdapat kesalahan input:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <!-- ============ TAMPILKAN HASIL SUKSES ============ -->
    <?php if ($sukses): ?>
        <div class="success-box">
            <strong>Data berhasil disimpan!</strong>
        </div>
        
        <h3>Data Mahasiswa:</h3>
        <table>
            <tr>
                <td>Nama Lengkap</td>
                <td><?= $data['nama'] ?></td>
            </tr>
            <tr>
                <td>NIM</td>
                <td><?= $data['nim'] ?></td>
            </tr>
            <tr>
                <td>Program Studi</td>
                <td><?= $data['prodi'] ?></td>
            </tr>
            <tr>
                <td>IPK</td>
                <td><?= number_format($data['ipk'], 2) ?></td>
            </tr>
            <tr>
                <td>Semester</td>
                <td><?= $data['semester'] ?></td>
            </tr>
            <tr>
                <td>Predikat Kelulusan</td>
                <td style="color: <?= $data['warna'] ?>; font-weight: bold; font-size: 16px;">
                    <?= $data['predikat'] ?>
                </td>
            </tr>
        </table>
    <?php endif; ?>
    
</body>
</html>
