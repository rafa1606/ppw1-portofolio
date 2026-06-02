<!DOCTYPE html>
<html lang="id">

<head>
  <title>Hitung IMT</title>
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

    .kategori {
      font-weight: bold;
      color: green;
    }
  </style>
</head>

<body>

  <?php
  function hitungIMT($berat, $tinggi)
  {
    $imt = $berat / ($tinggi * $tinggi);

    if ($imt < 18.5) {
      $kategori = "Kurus";
    } elseif ($imt < 25) {
      $kategori = "Normal";
    } elseif ($imt < 30) {
      $kategori = "Gemuk";
    } else {
      $kategori = "Obesitas";
    }

    return $kategori;
  }

  $berat = 65;
  $tinggi = 1.70;
  $imt = $berat / ($tinggi * $tinggi);
  $kategori = hitungIMT($berat, $tinggi);
  ?>

  <h2>Indeks Massa Tubuh</h2>
  <div class="box">
    <p>Berat Badan :
      <?php echo $berat; ?> kg
    </p>
    <p>Tinggi Badan :
      <?php echo $tinggi; ?> m
    </p>
    <p>Nilai IMT :
      <?php echo round($imt, 2); ?>
    </p>
    <p>Kategori : <span class="kategori">
        <?php echo $kategori; ?>
      </span></p>
  </div>

</body>

</html>