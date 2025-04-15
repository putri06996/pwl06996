<?php
    require "fungsi.php";

    $npp=$_POST["npp"];
    $namadosen=$_POST["namadosen"];
    $homebase=$_POST["homebase"];

    $npp =md5($npp);
    $simpan=mysqli_query($koneksi,"insert into dosen(npp,namadosen,homebase)
     values('$npp','$namadosen','$homebase')");
    if ($simpan) {
        echo "Data berhasil disimpan";
    } else {
        echo "data gagal tersimpan";
    }
?>