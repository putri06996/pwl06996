<!DOCTYPE html>
<html>
<head>
	<title>Sistem Informasi Akademik::Tambah Data Dosen</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="bootstrap533/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/styleku.css">
	<script src="bootstrap533/jquery/3.3.1/jquery-3.3.1.js"></script>
	<script src="bootstrap533/js/bootstrap.js"></script>

</head>
<body>
	<?php
	require "head.html";
	?>
	<div class="utama">		
		<br><br><br>		
		<h3>TAMBAH DATA DOSEN</h3>
		<div class="alert alert-success alert-dismissible" id="success" style="display:none;">
	  		<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
		</div>	
		<form method="post" action="sv_addMhs.php" enctype="multipart/form-data">
			<div class="form-group">
				<label for="npp">NPP :</label>
				<input class="form-control" type="text" name="npp" id="npp" required>
			</div>
			<div class="form-group">
				<label for="nama">Nama Dosen:</label>
				<input class="form-control" type="text" name="namadosen" id="namadosen">
			</div>
			<div class="form-group">
				<label for="homebase">Homebase</label>
				<input class="form-control" type="select" name="homebase" id="homebase">
			</div>
            <div>		
				<button type="submit" class="btn btn-primary" value="Simpan">Simpan</button>
			</div>
		</form>
	</div>
	<!--
	<script>
		$(document).ready(function(){
			$('#butsave').on('click',function(){			
				$('#butsave').attr('disabled', 'disabled');
				var nim 	= $('#nim').val();
				var nama	= $('#nama').val();
				var email 	= $('#email').val();
				
				$.ajax({
					type	: "POST",
					url		: "sv_addMhs.php",
					data	: {
								nim:nim,
								nama:nama,
								email:email
							  },
					contentType	:"undefined",					
					success : function(dataResult){						
						alert('success');
						$("#butsave").removeAttr("disabled");
						$('#fupForm').find('input:text').val('');
						$("#success").show();
						$('#success').html(dataResult);	
					}	   
				});
			});
		});
	</script>
	-->	
</body>
</html>