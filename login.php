<?php
// Memulai session atau melanjutkan session yang sudah ada
session_start();

// Menyertakan file koneksi
include "koneksi.php";

// Check jika sudah ada user yang login, arahkan ke halaman admin
if (isset($_SESSION['username'])) { 
    header("location:admin.php"); 
    exit();
}

// Proses login jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['user'];
    $password = md5($_POST['pass']);  // Enkripsi MD5 untuk password

    // Prepared statement untuk mencegah SQL injection
    $stmt = $conn->prepare("SELECT id, username FROM user WHERE username=? AND password=?");

    // Binding parameter
    $stmt->bind_param("ss", $username, $password);

    // Eksekusi statement
    $stmt->execute();

    // Menampung hasil eksekusi
    $hasil = $stmt->get_result();

    // Mengambil baris hasil sebagai array asosiatif
    if ($hasil->num_rows > 0) {
        $row = $hasil->fetch_assoc();

        // Simpan username dan user_id di session
        $_SESSION['username'] = $row['username'];
        $_SESSION['user_id'] = $row['id'];  // Menyimpan user_id untuk kebutuhan lainnya

        // Arahkan ke halaman admin setelah login berhasil
        header("location:admin.php");
        exit();
    } else {
        // Jika login gagal, beri pesan kesalahan
        $error_message = "Username atau Password salah!";
    }

    // Menutup statement dan koneksi
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login | Premier League</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
    <link rel="icon" href="img/logo.png" />
</head>
<body style="background-image: url('img/darkbgs.jpg'); background-size: cover; background-position: center;">
    <div class="container mt-5 pt-5">
        <div class="row">
            <div class="col-12 col-sm-8 col-md-6 m-auto">
                <div class="card border-0 shadow rounded-5">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <i class="bi bi-person-circle h1 display-4"></i>
                            <p>Login Your Account Bruh!</p>
                            <hr/>
                        </div>
                        <?php if (isset($error_message)) { ?>
                            <div class="alert alert-danger"><?php echo $error_message; ?></div>
                        <?php } ?>
                        <form action="" method="POST">
                            <input type="text" name="user" class="form-control my-4 py-2 rounded-4" placeholder="Username" required />
                            <input type="password" name="pass" class="form-control my-4 py-2 rounded-4" placeholder="Password" required />
                            <div class="text-center my-3 d-grid">
                                <button class="btn btn-danger rounded-4" style="background-color: #430A5D; border-color: #430A5D;">Login</button> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
