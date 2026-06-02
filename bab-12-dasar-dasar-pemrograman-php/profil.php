<!DOCTYPE html>
<html lang="id">
<head>
    <title>Profil Saya</title>
    <style>
        table {
            border-collapse: collapse;
            width: 400px;
        }
        td {
            padding: 8px 12px;
            border: 1px solid #ccc;
        }
        td:first-child {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php
$nama = "Rafa Irhamniyansyah Achmad";
$nim = "25/557712/SV/26222";
$prodi = "Teknik Rekayasa Perangkat Lunak";
$asal_kota = "Magelang";
?>

<h2>Profil Mahasiswa</h2>
<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <td>Nama</td>
        <td><?php echo $nama; ?></td>
    </tr>
    <tr>
        <td>NIM</td>
        <td><?php echo $nim; ?></td>
    </tr>
    <tr>
        <td>Program Studi</td>
        <td><?php echo $prodi; ?></td>
    </tr>
    <tr>
        <td>Asal Kota</td>
        <td><?php echo $asal_kota; ?></td>
    </tr>
</table>

</body>
</html>