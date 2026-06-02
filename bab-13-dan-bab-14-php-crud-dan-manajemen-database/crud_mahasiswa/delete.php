<?php
require_once 'koneksi.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];

$stmt = $koneksi->prepare("DELETE FROM mahasiswa WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $stmt->close();
    $koneksi->close();
    header("Location: index.php?status=deleted");
    exit;
} else {
    $stmt->close();
    $koneksi->close();
    header("Location: index.php?status=error");
    exit;
}
?>