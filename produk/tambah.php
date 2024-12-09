<?php
include '../koneksi.php';

// Ambil Seluruh Kategori
$result = $kon->query("SELECT DISTINCT kategori FROM produk");
$categories = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $categories[] = $row['kategori'];
  }
  $kategori = json_encode($categories);
  echo "<script>console.log('kategori: ',$kategori);</script>";
}

if (isset($_POST['submit'])) {
  // Ambil data dari form
  $bar = $_POST['barcode'];
  $nama = $_POST['nama'];
  $kategori = ($_POST['kategori'] == 'new') ? $_POST['kategoriBaru'] : $_POST['kategori'];

  // Cek apakah barcode sudah ada di database
  $sql_check = "SELECT * FROM produk WHERE bar = '$bar'";
  $result = $kon->query($sql_check);

  if ($result->num_rows > 0) {
    // Jika barcode sudah ada, tampilkan pesan error
    $errorMessage = "Barcode sudah terdaftar";
  } else {
    // Simpan data ke database
    $sql = "INSERT INTO produk (bar, nama, kategori) VALUES ('$bar', '$nama', '$kategori')";

    if ($kon->query($sql) === TRUE) {
      // Menampilkan data di console.log
      echo "<script>console.log('Data berhasil dikirim: Barcode = $bar, Nama = $nama, Kategori = $kategori');</script>";
      $success = "Data Berhasil Ditambahkan";
    } else {
      echo "Error: " . $sql . "<br>" . $kon->error;
    }
  }
}

$kon->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include '../layout/head.php'; ?>
  <title>Tambah Produk</title>
</head>

<body class="g-sidenav-show bg-gray-100">
  <div class="min-height-300 bg-success position-absolute w-100"></div>
  <?php $active = 'produk';
  include '../layout/sidebar.php'; ?>
  <main class="main-content position-relative border-radius-lg vh-100">

    <div class="container-fluid py-4 d-flex justify-content-center align-items-center" ;>
      <div class="row align-items-stretch">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body pt-">
              <div class="card" id="reader"></div>
              <?php
              // Jika ada pesan error, tampilkan
              if (isset($errorMessage)) {
                echo "<span class='badge bg-gradient-danger'>$errorMessage</span>";
              } else if (isset($success)) {
                echo "<span class='badge bg-gradient-success'>$success</span>";
              }
              ?>
              <form id="poi-form" class="mb-0" method="POST" action="">
                <div class="form-group">
                  <label for="barcode">Barcode</label>
                  <input type="text" id="barcode" class="form-control" name="barcode" value="2234567890123"
                    maxlength="13" required>
                </div>
                <div class="form-group">
                  <label for="nama">Nama Produk</label>
                  <input type="text" id="nama" class="form-control" name="nama" value="Aqua 100ml" required>
                </div>
                <div class="form-group">
                  <label for="kategori">Kategori</label>
                  <select class="form-select" name="kategori" id="kategori" onchange="toggleNewCategoryInput(this)">
                    <option value="lainnya" selected>--Select a category--</option>
                    <?php foreach ($categories as $category): ?>
                      <option value="<?= htmlspecialchars($category); ?>">
                        <?= htmlspecialchars($category); ?>
                      </option>
                    <?php endforeach; ?>
                    <option value="new">--New Category--</option>
                  </select>
                  <!-- This input field is hidden initially -->
                  <div id="newCategoryInput" class="form-group" style="display: none;">
                    <label for="newCategory">Masukkan Kategori Baru</label>
                    <input type="text" class="form-control" name="kategoriBaru" id="newCategoryInput">
                  </div>
                </div>
                <button type="submit" name="submit" class="btn btn-success mb-0">Tambah Data</button>
              </form>
            </div>
            <a href="<?= $url ?>/produk/" class="btn btn-icon btn-3 btn-secondary m-2" type="button">
              <span class="btn-inner--icon"><i class="fa-solid fa-arrow-left"></i></span>
              <span class="btn-inner--text">Kembali</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Tambahkan skrip HTML5 Qrcode untuk scan barcode -->
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
  <script>
    let productID = document.getElementById('barcode');
    let html5QrcodeScanner = new Html5QrcodeScanner(
      "reader", {
        fps: 10,
        qrbox: {
          width: 500,
          height: 250
        }
      },
      false);

    html5QrcodeScanner.render((decodedText, decodedResult) => {
      productID.value = decodedText;
      p.value = decodedText;
    }, (error) => {
      console.warn(`Code scan error = ${error}`);
    });

    //select new category
    function toggleNewCategoryInput(selectElement) {
      var newCategoryInput = document.getElementById('newCategoryInput');
      if (selectElement.value === 'new') {
        newCategoryInput.style.display = 'block'; // Show the new category input
      } else {
        newCategoryInput.style.display = 'none'; // Hide the new category input
      }
    }
  </script>
  <?php include '../layout/scripts.php'; ?>
</body>

</html>