<?php
require_once 'koneksi.php';

function bersihkan($input): string {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

$errors = [];
$old_input = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $nama     = bersihkan($_POST['nama'] ?? '');
    $nim      = bersihkan($_POST['nim'] ?? '');
    $prodi    = bersihkan($_POST['prodi'] ?? '');
    $ipk      = (float) ($_POST['ipk'] ?? 0);
    $semester = (int) ($_POST['semester'] ?? 0);
    
    $old_input = [
        'nama' => $nama, 'nim' => $nim, 'prodi' => $prodi,
        'ipk' => $ipk, 'semester' => $semester,
    ];
    
    if (empty($nama)) {
        $errors[] = "Nama tidak boleh kosong.";
    } elseif (strlen($nama) < 3) {
        $errors[] = "Nama minimal 3 karakter.";
    }

    if (empty($nim)) {
        $errors[] = "NIM tidak boleh kosong.";
    }

    if (empty($prodi)) {
        $errors[] = "Program Studi harus dipilih.";
    }

    if ($ipk <= 0 || $ipk > 4) {
        $errors[] = "IPK harus antara 0.01 dan 4.00.";
    }

    if ($semester < 1 || $semester > 14) {
        $errors[] = "Semester harus antara 1 dan 14.";
    }
    
    if (empty($errors)) {
        $cek = $koneksi->prepare("SELECT id FROM mahasiswa WHERE nim = ?");
        $cek->bind_param("s", $nim);
        $cek->execute();
        $cek_result = $cek->get_result();

        if ($cek_result->num_rows > 0) {
            $errors[] = "NIM '$nim' sudah terdaftar. Gunakan NIM lain.";
        }

        $cek->close();
    }
    
    if (empty($errors)) {
        $stmt = $koneksi->prepare(
            "INSERT INTO mahasiswa (nama, nim, prodi, ipk, semester) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("sssdi", $nama, $nim, $prodi, $ipk, $semester);

        if ($stmt->execute()) {
            $stmt->close();
            $koneksi->close();
            header("Location: index.php?status=created");
            exit;
        } else {
            $errors[] = "Gagal menyimpan data: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                
                <h1 class="h3 mb-4">Tambah Mahasiswa Baru</h1>
                
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <strong>Terdapat kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            <?php foreach ($errors as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form method="POST" action="create.php">
                            
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control"
                                       value="<?= $old_input['nama'] ?? '' ?>"
                                       placeholder="Contoh: Messi" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">NIM</label>
                                <input type="text" name="nim" class="form-control"
                                       value="<?= $old_input['nim'] ?? '' ?>"
                                       placeholder="Masukkan NIM" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Program Studi</label>
                                <select name="prodi" class="form-select" required>
                                    <option value="">-- Pilih Prodi --</option>
                                    <?php
                                    $list_prodi = ['Teknologi Rekayasa Perangkat Lunak', 'Teknologi Rekayasa Internet', 'Teknik Elektro', 'Manajemen', 'Akuntansi'];
                                    foreach ($list_prodi as $p):
                                        $selected = (($old_input['prodi'] ?? '') === $p) ? 'selected' : '';
                                    ?>
                                        <option value="<?= $p ?>" <?= $selected ?>><?= $p ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">IPK (0.00 - 4.00)</label>
                                <input type="number" name="ipk" step="0.01" min="0" max="4" class="form-control"
                                       value="<?= $old_input['ipk'] ?? '' ?>"
                                       placeholder="Contoh: 3.75" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Semester (1 - 14)</label>
                                <input type="number" name="semester" min="1" max="14" class="form-control"
                                       value="<?= $old_input['semester'] ?? '' ?>"
                                       placeholder="Contoh: 5" required>
                            </div>
                            
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <a href="index.php" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>