<?php
require_once 'koneksi.php';

$sql = "SELECT * FROM mahasiswa ORDER BY id DESC";
$result = $koneksi->query($sql);

if (!$result) {
    die("Query gagal: " . $koneksi->error);
}

$total_data = $result->num_rows;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container my-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Data Mahasiswa</h1>
            <a href="create.php" class="btn btn-success">
                Tambah Mahasiswa
            </a>
        </div>
        
        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] === 'created'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Data mahasiswa berhasil ditambahkan.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php elseif ($_GET['status'] === 'updated'): ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    Data mahasiswa berhasil diperbarui.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php elseif ($_GET['status'] === 'deleted'): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Data mahasiswa berhasil dihapus.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        
        <p class="text-muted">Total data: <strong><?= $total_data ?></strong> mahasiswa</p>
        
        <?php if ($total_data > 0): ?>
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0 align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIM</th>
                                    <th>Prodi</th>
                                    <th>IPK</th>
                                    <th>Smt</th>
                                    <th>Predikat</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                while ($row = $result->fetch_assoc()):
                                    if ($row['ipk'] >= 3.51) {
                                        $predikat = "Cumlaude";
                                        $badge = "bg-success";
                                    } elseif ($row['ipk'] >= 3.01) {
                                        $predikat = "Sangat Memuaskan";
                                        $badge = "bg-primary";
                                    } elseif ($row['ipk'] >= 2.76) {
                                        $predikat = "Memuaskan";
                                        $badge = "bg-warning text-dark";
                                    } else {
                                        $predikat = "Belum Memuaskan";
                                        $badge = "bg-danger";
                                    }
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($row['nama']) ?></td>
                                        <td><?= htmlspecialchars($row['nim']) ?></td>
                                        <td><?= htmlspecialchars($row['prodi']) ?></td>
                                        <td><?= number_format($row['ipk'], 2) ?></td>
                                        <td><?= $row['semester'] ?></td>
                                        <td><span class="badge <?= $badge ?>"><?= $predikat ?></span></td>
                                        <td class="text-center">
                                            <a href="update.php?id=<?= $row['id'] ?>" 
                                               class="btn btn-warning btn-sm">Edit</a>
                                            <a href="delete.php?id=<?= $row['id'] ?>" 
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Yakin ingin menghapus data ini?')">
                                               Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="card shadow-sm">
                <div class="card-body text-center py-5 text-muted">
                    <h4>Belum ada data mahasiswa</h4>
                    <p>Klik tombol Tambah Mahasiswa untuk menambahkan data pertama.</p>
                </div>
            </div>
        <?php endif; ?>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>