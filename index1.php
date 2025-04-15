<?php
session_start(); // Memulai session
require "fungsi.php"; // Pastikan file ini berisi koneksi ke database

if (isset($_SESSION['username'])) {
	header("Location: homeAdmin.php");
	exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = trim($_POST['username']);
	$passw = trim($_POST['passw']); // Password tanpa hashing

	if (!empty($username) && !empty($passw)) {
		$sql1 = "SELECT iduser, username, password, status FROM user WHERE username = ?";
		if ($stmt = $koneksi->prepare($sql1)) {
			$stmt->bind_param('s', $username);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows == 1) {
				$user = $result->fetch_assoc();
				if (md5($passw) === $user['password']) { // Sesuaikan dengan hashing MD5
					$_SESSION['userid'] = $user['iduser']; // Simpan iduser dalam session
					$_SESSION['username'] = $user['username'];
					$_SESSION['status'] = $user['status']; // Simpan status user
					header("Location: homeAdmin.php");
					exit();
				} else {
					$error = "Password salah.";
				}
			} else {
				$error = "User tidak ditemukan.";
			}

			$stmt->close();
		}
	} else {
		$error = "Username dan Password tidak boleh kosong.";
	}

	$koneksi->close();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login Sistem</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap533/css/bootstrap.css">
    <script src="bootstrap533/js/bootstrap.js"></script>
    <script src="bootstrap533/jquery/jquery-3.7.1.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="w-25 mx-auto text-center mt-5">
            <div class="card bg-dark text-light">
                <div class="card-body">
                    <h2 class="card-title">LOGIN</h2>
                    <?php if (!empty($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
                    <form method="post" action="">
                        
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input class="form-control" type="text" name="username" id="username">
                        </div>
                        <div class="form-group">
                            <label for="passw">Password</label>
                            <input class="form-control" type="password" name="passw" id="passw">
                        </div>
                        <div><br>
                            <button class="btn btn-info" type="submit">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

