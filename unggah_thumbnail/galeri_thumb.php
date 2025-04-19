<?php
session_start();
include '../fungsi.php';
$conn = $koneksi;



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $target_dir = "uploads/";
  $thumb_dir = "thumbs/";
  $file_name = basename($_FILES["gambar"]["name"]);
  $target_file = $target_dir . $file_name;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  $check = getimagesize($_FILES["gambar"]["tmp_name"]);
  if ($check == false) {
    die("File bukan gambar");
  }

  $allowed = ['jpg', 'jpeg', 'png', 'gif'];
  if (!in_array($imageFileType, $allowed)) {
    die("Hanya file JPG, JPEG, PNG dan GIF yang diperbolehkan");
  }

  if ($_FILES["gambar"]["size"] > 2 * 1024 * 1024) {
    die("Ukuran terlalu besar (maks 2MB)");
  }

  $finfo = finfo_open(FILEINFO_MIME_TYPE);
  $mime = finfo_file($finfo, $_FILES["gambar"]["tmp_name"]);
  if (!in_array($mime, ['image/jpeg', 'image/png', 'image/gif'])) {
    die("Tipe Mime Tidak sesuai");
  }

  if (!move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
    die("Gagal Mengunggah file.");
  }

  list($width, $height) = getimagesize($target_file);
  $new_width = 200;
  $new_height = floor($height * ($new_width / $width));
  $thumbpath = $thumb_dir . "thumb_" . $file_name;

  switch ($imageFileType) {
    case 'jpg':
    case 'jpeg':
      $src = imagecreatefromjpeg($target_file);
      break;
    case 'png':
      $src = imagecreatefrompng($target_file);
      break;
    case 'gif':
      $src = imagecreatefromgif($target_file);
      break;
  }

  $thumb = imagecreatetruecolor($new_width, $new_height);
  imagecopyresampled($thumb, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

  switch ($imageFileType) {
    case 'jpg':
    case 'jpeg':
      imagejpeg($thumb, $thumbpath, 80);
      break;
    case 'png':
      imagepng($thumb, $thumbpath);
      break;
    case 'gif':
      imagegif($thumb, $thumbpath);
      break;
  }

  imagedestroy($src);
  imagedestroy($thumb);

  $stmt = $conn->prepare("INSERT INTO gambar_thumbnail (filename, filepath, thumbpath, width, height) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssii", $file_name, $target_file, $thumbpath, $width, $height);
  $stmt->execute();

  $_SESSION['success'] = "Gambar berhasil diunggah dan thumbnail dibuat.";
  header("Location: " . $_SERVER['PHP_SELF']);
  exit();
}
?>

<!DOCTYPE html> 
<html lang="en"> 
    <head> 
        <meta charset="UTF-8"> 
        <title>Upload Gambar + Thumbnail</title> 
        <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet"> 
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> 
 
    </head> 
<body>
    <div class="container py-5">
        <h2 class="text-center mb-4">Upload Gambar</h2>

        <!-- Form Upload -->
        <form method="post" enctype="multipart/form-data" class="row g-3 align-items-left justify-content-center mb-4">
            <div class="col-md-5">
                <input type="file" name="gambar" class="form-control" required>
            </div>
            <div class="col-md-auto">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-upload"></i> Upload
                </button>
                <a href="galeri_bootstrap3.php" class="btn btn-outline-success">
                <i class="fas fa-images"></i> Buka Galeri Gambar</a>
        </div>
        </form>

        <!-- Pesan sukses -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> <?= $_SESSION['success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <!-- Tombol Buka Galeri -->
        

        <!-- Thumbnail -->
        <h4 class="mb-3">Thumbnail Terbaru</h4>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-3">
            <?php
            $result = $conn->query("SELECT * FROM gambar_thumbnail ORDER BY id DESC LIMIT 10");
            while ($row = $result->fetch_assoc()):
            ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <img src="<?= $row['thumbpath'] ?>" class="card-img-top" alt="Thumbnail">
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- FontAwesome untuk ikon (opsional, bisa dicopot kalau tidak dipakai) -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>