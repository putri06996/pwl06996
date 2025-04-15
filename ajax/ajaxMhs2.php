<?php

//memanggil file berisi fungsi2 yang sering dipakai
require "../fungsi.php";

require "../head.html";

$keyword=$_GET["keyword"];

$jmlDataPerHal = 5;	

//cari jumlah data
$sql="select * from mhs where nim like'%$keyword%' or
						  nama like '%$keyword%' or
						  email like '%$keyword%'";
						  	
						  
$qry = mysqli_query($koneksi,$sql) or die(mysqli_error($koneksi));
$jmlData = mysqli_num_rows($qry);

$jmlHal = ceil($jmlData / $jmlDataPerHal);
if (isset($_GET['hal'])){
	$halAktif=$_GET['hal'];
}else{
	$halAktif=1;
}

$awalData=($jmlDataPerHal * $halAktif)-$jmlDataPerHal;

//Jika tabel data kosong
$kosong=false;
if (!$jmlData){
	$kosong=true;
}
//data berdasar pencarian atau tidak
$sql="select * from mhs where nim like'%$keyword%' or
						  nama like '%$keyword%' or
						  email like '%$keyword%'
						  limit $awalData,$jmlDataPerHal";	


//Ambil data untuk ditampilkan
$hasil=mysqli_query($koneksi,$sql) or die(mysqli_error($koneksi));
		
?>
	</ul>	
	<!-- Cetak data dengan tampilan tabel -->
	<table class="table table-hover">
	<thead class="thead-light">
	<tr>
		<th>No.</th>
		<th>NIM</th>
		<th>Nama</th>
		<th>Email</th>
		<th>Foto</th>
		<th>Aksi</th>
	</tr>
	</thead>

	<tbody>
	<?php
	//jika data tidak ada
		$hasil=mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
		$no=1;
		while($row=mysqli_fetch_assoc($hasil)){
			?>	
			<tr>
				<td><?php echo $no?></td>
				<td><?php echo $row["nim"]?></td>
				<td><?php echo $row["nama"]?></td>
				<td><?php echo $row["email"]?></td>
				<td><img src="<?php echo "foto/".$row["foto"]?>" height="50"></td>
				<td>
				<a class="btn btn-outline-primary btn-sm" href="editMhs.php?kode=<?php echo $row['id']?>">Edit</a>
				<a class="btn btn-outline-danger btn-sm" href="hpsMhs.php?kode=<?php echo $row["id"]?>" id="linkHps" onclick="return confirm('Yakin dihapus nih?')">Hapus</a>
				</td>
			</tr>
			<?php 
			$no++;
		}
	?>
	</tbody>
	</table>
</div>
</body>
</html>	
