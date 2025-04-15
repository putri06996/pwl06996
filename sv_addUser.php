<?php
    require "fungsi.php";

    $username=$_POST["username"];
    $password=$_POST["password"];
    $status=$_POST["status"];

    $password =md5($password);
    $simpan=mysqli_query($koneksi,"insert into user(username,password,status)
     values('$username','$password','$status')");
    if ($simpan) {
        echo "Data berhasil disimpan";
    } else {
        echo "data gagar tersimpan";
    }
?>