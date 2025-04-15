<!DOCTYPE html>
<html>
<head>
	<title>Sistem Informasi Akademik::Tambah Data Pengguna</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="bootstrap533/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/styleku.css">
	<script src="bootstrap533/jquery/jquery-3.7.1.min.js"></script>
	<script src="bootstrap533/js/bootstrap.js"></script>

	<style>
	.error {
		color: red;
		font-size: 0.9em;
		display: none;
	}

	#nim {
		width: 150px;
	}
	#ajaxResponse {
		margin-top: 15px;
	}
	</style>
	<script>
	$(document).ready(function() {
	// membuat fungsi untuk mengecek username pada database
	function checkUsernameExists(username) {
		$.ajax({
			url: 'cek_data_kembar_User.php',
			type: 'POST',
			data: {
				username: username
			},
			success: function(response) {
				if (response === 'exists') {
					showError("* Username sudah ada, silahkan isikan yang lain");
					$("#username").val("").focus();
					return false;
				} else {
					hideError();
					$("#password").focus();
				}
			}
		});
	} 
	
	function validateUsername() { 
		var username = $("#username").val();
		var errorMsg = "";
	
		// Cek apakah username kosong
		if (username.trim() === "") {
			errorMsg = "* Username tidak boleh kosong!";
			showError(errorMsg);
			return false;
		}
		return true;
	}

	function showError(message) {
		$("#usernameError").text(message).show();
	}
	function hideError() {
		$("#usernameError").hide();
	}
	
	// Event listeners
	$("#username").on("blur", function() {
		if (validateUsername()) {
			checkUsernameExists($(this).val());
		}
	}).on("keypress", function(event) {
		if (event.which === 13) {
			event.preventDefault();
			if (validateUsername()) {
				checkUsernameExists($(this).val());
			}		
		}		
	}).on("input", function() {
		hideError();
	});
	
	// Form submission with AJAX
	$("#mahasiswaForm").on("submit", function(event) {
		event.preventDefault();
		if (!validateUsername()) {
			return false;
		}
		var formData = new FormData(this);
		$.ajax({
			url: 'sv_addUser.php',
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			success: function(response) {
				$("#ajaxResponse").html(response);
				$("#mahasiswaForm")[0].reset();
			},
			error: function() {
				$("#ajaxResponse").html("Terjadi kesalahan saat mengirim data.");
			}
		});
	});
});
</script>

</head>

<body>
<?php require "head.html"; ?>
	<div class="utama">
		<br><br><br>
		<h3>TAMBAH DATA PENGGUNA</h3>
		<form id="mahasiswaForm" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label for="username">Username:</label>
				<input class="form-control" type="text" name="username" id="username" placeholder="username" required>
				<span id="usernameError" class="error"></span>
			</div>
			<div class="form-group">
				<label for="password">Password:</label>
				<input class="form-control" type="password" name="password" id="password" required>
			</div>
			<div class="form-group">
				<label for="status">Status:</label>
				<input class="form-control" type="text" name="status" id="status" required>
			</div><br>
			<div>
				<button type="submit" class="btn btn-primary" value="simpan">Simpan</button>
			</div>
		</form>
		<div id="ajaxResponse"></div>
	</div>
</body>

</html>