
<?php
//memanggil file pustaka fungsi
require "fungsi.php";

//memindahkan data kiriman dari form ke var biasa
$nim=$_POST["nim"];
$nama=$_POST["nama"];
$email=$_POST["email"];
$uploadOk=1;

//Set lokasi dan nama file foto
$folderupload ="foto/";
$fileupload = $folderupload . basename($_FILES['foto']['name']); // foto/A12.2018.05555.jpg
$filefoto = basename($_FILES['foto']['name']);                  // A12.2018.0555.jpg

//ambil jenis file
$jenisfilefoto = strtolower(pathinfo($fileupload,PATHINFO_EXTENSION)); //jpg,png,gif

// Check jika file foto sudah ada
if (file_exists($fileupload)) {
    echo "Maaf, file foto sudah ada<br>";
    $uploadOk = 0;
}

// Check ukuran file
if ($_FILES["foto"]["size"] > 1000000) {
    echo "Maaf, ukuran file foto harus kurang dari 1 MB<br>";
    $uploadOk = 0;
}

// Hanya file tertentu yang dapat digunakan
if($jenisfilefoto != "jpg" && $jenisfilefoto != "png" && $jenisfilefoto != "jpeg"
&& $jenisfilefoto != "gif" ) {
    echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diperbolehkan<br>";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "Maaf, file tidak dapat terupload.<br>";
} else {
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $fileupload)) {
        // Membuat query
        $sql = "INSERT INTO mhs (nim, nama, email, foto) VALUES ('$nim', '$nama', '$email', '$filefoto')";
        if (mysqli_query($koneksi, $sql)) {
            echo "Data berhasil disimpan.";
        } else {
            echo "Data gagal tersimpan: " . mysqli_error($koneksi);
        }
    } else {
        echo "Data gagal tersimpan.";
    }
}

// Menutup koneksi
mysqli_close($koneksi);
?>