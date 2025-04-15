<?php
//memanggil file pustaka fungsi
require "fungsi.php";

//memindahkan data kiriman dari form ke var biasa
$iduser=$_POST["iduser"];
$username=$_POST["username"];
$status=$_POST["status"];
$uploadOk=1;

//membuat query
$sql="update user set username='$username',
					 status='$status'
					 where iduser='$iduser'";
mysqli_query($koneksi,$sql) or die(mysqli_error($koneksi));
header("location:ajaxUpdateUser.php");
?>