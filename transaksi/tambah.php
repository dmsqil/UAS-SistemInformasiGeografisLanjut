<?php
include '../koneksi.php';

// Ambil Seluruh Produk
$result = $kon->query("SELECT * FROM produk");
$products = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $products[] = $row;
  }
  $produk = json_encode($products);
  echo "<script>console.log('produk: ',$produk);</script>";
}

// Ambil Seluruh Toko
$result = $kon->query("SELECT * FROM toko");
$shops = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $shops[] = $row;
  }
  $toko = json_encode($shops);
  echo "<script>console.log('toko: ',$toko);</script>";
}

if (isset($_POST['submit'])) {
  // Ambil data dari form
  $produk = $kon->real_escape_string($_POST['produk']);
  $toko = $kon->real_escape_string($_POST['toko']);
  $harga = $kon->real_escape_string($_POST['harga']);
  $tgl = $kon->real_escape_string($_POST['tgl']);
  $jumlah = $kon->real_escape_string($_POST['jumlah']);

  // Cek apakah transaksi sudah ada
  $checkQuery = "SELECT * FROM transaksi WHERE prod_id = '$produk' AND toko_id = '$toko' LIMIT 1";
  $checkResult = $kon->query($checkQuery);

  if ($checkResult->num_rows > 0) {
    // Jika transaksi sudah ada, lakukan UPDATE
    $updateQuery = "UPDATE transaksi SET harga = '$harga', tgl = '$tgl', jumlah = '$jumlah' 
                    WHERE prod_id = '$produk' AND toko_id = '$toko'";
    $kon->query($updateQuery);
  } else {
    // Jika tidak ada, lakukan INSERT
    $insertQuery = "INSERT INTO transaksi (prod_id, toko_id, harga, tgl, jumlah) 
                    VALUES ('$produk', '$toko', '$harga', '$tgl', '$jumlah')";
    $kon->query($insertQuery);
  }

  echo "<script>console.log('Data berhasil ditambah: \\nProduk = $produk, Toko = $toko, Harga = $harga, Tgl = $tgl, Jumlah = $jumlah');</script>";
  $success = "Data Berhasil Ditambahkan!";

  header("Refresh:0");
  exit();
}

$kon->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include '../layout/head.php'; ?>
  <title>Tambah Transaksi</title>
</head>

<body class="g-sidenav-show bg-gray-100">
  <div class="min-height-600 bg-success position-absolute w-100"></div>
  <?php $active = 'transaksi';
  include '../layout/sidebar.php'; ?>
  <main class="main-content position-relative border-radius-lg vh-100">
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
      data-scroll="false">
      <div class="container-fluid p-0">
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <ul class="navbar-nav justify-content-end">
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                </div>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container-fluid py-4">
      <div class="row align-items-stretch">
        <div class="col-lg-4">
          <div class="card" id="reader"></div>
        </div>
        <div class="col-lg-4">
          <div class="card">
            <a href="<?= $url ?>transaksi/" class="btn btn-icon btn-3 btn-secondary m-2" type="button">
              <span class="btn-inner--icon"><i class="fa-solid fa-arrow-left"></i></span>
              <span class="btn-inner--text">Kembali</span>
            </a>
            <div class="card-body pt-0">
              <?php
              if (isset($success)) {
                echo "<span class='badge bg-gradient-success'>$success</span>";
              }
              ?>
              <form id="transaksi-form" class="mb-0" method="POST" action="">
                <div class="form-group">
                  <label for="produk">Produk</label>
                  <select class="form-select" name="produk" id="produk" required>
                    <?php foreach ($products as $produk): ?>
                      <option value="<?= htmlspecialchars($produk['bar']); ?>">
                        <?= htmlspecialchars($produk['bar']) . " | " . htmlspecialchars($produk['nama']); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="toko">Toko</label>
                  <select class="form-select" name="toko" id="toko" required>
                    <?php foreach ($shops as $shop): ?>
                      <option value="<?= htmlspecialchars($shop['id']); ?>">
                        <?= htmlspecialchars($shop['id']) . " | " . htmlspecialchars($shop['nama']); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="harga">Harga</label>
                  <input type="number" class="form-control" name="harga" id="harga" required>
                </div>
                <input type="datetime-local" hidden name="tgl" value="<?= date('Y-m-d\TH:i:s'); ?>">
                <input type="number" hidden name="jumlah" value="1">
                <button type="submit" name="submit" class="btn btn-success mb-0">Update Data</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer px-3">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
          </div>
        </div>
      </footer>
    </div>
  </main>
  <script>
    const produkSelect = document.getElementById('produk');
    const tokoSelect = document.getElementById('toko');
    const hargaInput = document.getElementById('harga');

    document.addEventListener('DOMContentLoaded', function() {
      produkSelect.addEventListener('change', checkTransaction);
      tokoSelect.addEventListener('change', checkTransaction);
    });

    function checkTransaction() {
      const produkId = produkSelect.value;
      const tokoId = tokoSelect.value;
      if (produkId && tokoId) {
        fetch('../fungsi/check_transaction.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({
              produk: produkId,
              toko: tokoId
            })
          })
          .then(response => response.json())
          .then(data => {
            if (data.exists) {
              hargaInput.value = data.harga;
            } else {
              hargaInput.value = '';
            }
          })
          .catch(error => console.error('Error:', error));
      }
    }
  </script>
  <?php include '../layout/scripts.php' ?>
</body>

</html>