<?php
// Memulai session hanya jika belum dimulai
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}

// Ambil user_id dari session
$user_id = $_SESSION['user_id'];  // Menggunakan user_id dari session

// Ambil data profil pengguna berdasarkan user_id
$sql = "SELECT * FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);  // Menyaring berdasarkan user_id
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();  // Ambil data pengguna

// Variabel untuk menampilkan notifikasi
$profileUpdated = false;
$profileUpdateFailed = false;

// Proses perubahan profil
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];
    $photo = $user['photo'];  // photo lama, jika tidak diganti
    
    // Proses photo profil baru
    if ($_FILES['photo']['name'] != '') {
        $target_dir = "img/"; 
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        
        // Memindahkan file yang diupload
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            $photo = basename($_FILES["photo"]["name"]);
        } else {
            $profileUpdateFailed = true;  // Menandakan kegagalan
        }
    }

    // Enkripsi password baru jika diubah
    if (!empty($password)) {
        $password = md5($password);  // Enkripsi MD5
    } else {
        $password = $user['password'];  // Jika password tidak diubah
    }

    // Update data pengguna (hanya password dan photo yang dapat diubah)
    $sql_update = "UPDATE user SET password = ?, photo = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);  // Inisialisasi $stmt_update
    $stmt_update->bind_param("ssi", $password, $photo, $user_id);
    
    if ($stmt_update->execute()) {
        $profileUpdated = true;
    } else {
        $profileUpdateFailed = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .profile-container {
            background-color: rgba(255, 255, 255, 0.8); /* Set white with transparency */
            color: black; /* Set text color to black */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 0 auto; /* Center align */
            max-width: 600px; /* Set a maximum width */
            text-align: center; /* Center text */
        }
        .profile-container img {
            width: 200px;
            height: auto; /* Maintain aspect ratio */
            margin: 0 auto; /* Center align */
            display: block;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="profile-container text-center mx-auto">
            <h2>Profile Management</h2>
            <hr><br>
            <?php if ($profileUpdated): ?>
                <div class="alert alert-success">
                    Profile Updated!
                </div>
            <?php endif; ?>

            <?php if ($profileUpdateFailed): ?>
                <div class="alert alert-danger">
                    Profile Update Failed! Please try again.
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <!-- photo Profil -->
                <div class="mb-3 justify-content-center text-center mx-auto">
                    <label for="photo" class="form-label">Current Photo</label><br>
                    <img src="img/<?= !empty($user['photo']) && file_exists('img/' . $user['photo']) ? $user['photo'] : 'default.jpg' ?>" alt="photo Profil" class="rounded-circle border shadow mb-4">
                    <input type="file" class="form-control mx-auto" id="photo" name="photo">
                    <input type="hidden" name="current_photo" value="<?= $user['photo'] ?>">
                </div><br>

                <!-- Password -->
                <div class="mb-3 justify-content-center text-center mx-auto">
                    <label for="password" class="form-label">Change Password</label>
                    <div class="input-group mx-auto">
                        <input type="password" class="form-control" id="password" name="password">
                        <button type="button" class="btn btn-outline-secondary" onclick="showHidePassword()">
                            <i class="bi bi-eye-slash-fill" id="eye-icon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary justify-content-center mx-auto">Save Change</button>
            </form>
        </div>
    </div>
    
    <script>
        function showHidePassword() {
            var passwordInput = document.getElementById("password");
            var eyeIcon = document.getElementById("eye-icon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("bi-eye-slash-fill");
                eyeIcon.classList.add("bi-eye-fill");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("bi-eye-fill");
                eyeIcon.classList.add("bi-eye-slash-fill");
            }
        }
    </script>
</body>
</html>
