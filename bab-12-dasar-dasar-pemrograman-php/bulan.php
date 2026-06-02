<!DOCTYPE html>
<html lang="id">

<head>
  <title>Info Bulan</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 30px;
      background-color: #f5f5f5;
    }

    h2 {
      color: #333;
    }

    .box {
      background-color: white;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 20px;
      width: 350px;
    }

    .box p {
      margin: 8px 0;
      font-size: 15px;
    }

    .sisa {
      font-weight: bold;
      color: #e67e00;
    }
  </style>
</head>

<body>

  <?php
  $namaBulan = date("F");
  $tahun = date("Y");
  $hariIni = date("j");
  $totalHari = cal_days_in_month(CAL_GREGORIAN, date("n"), $tahun);
  $sisaHari = $totalHari - $hariIni;
  ?>

  <h2>Informasi Bulan Ini</h2>
  <div class="box">
    <p>Bulan sekarang : <?php echo $namaBulan . " " . $tahun; ?></p>
    <p>Hari ini : <?php echo $hariIni; ?></p>
    <p>Total hari : <?php echo $totalHari; ?> hari</p>
    <p>Sisa hari : <span class="sisa"><?php echo $sisaHari; ?> hari</span></p>
  </div>

</body>

</html>