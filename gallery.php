<?php
include "upload_foto.php";

// Database connection check
$conn = new mysqli("localhost", "root", "", "premierleague");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination setup
$limit = 5; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$page = max(1, $page); // Ensure page is at least 1
$offset = ($page - 1) * $limit; // Offset for the SQL query

// Get the total number of records
$sql_count = "SELECT COUNT(*) AS total FROM gallery";
$result_count = $conn->query($sql_count);
$total_records = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_records / $limit);

// Retrieve data from database with pagination
$sql = "SELECT * FROM gallery ORDER BY tanggal DESC LIMIT $limit OFFSET $offset";
$hasil = $conn->query($sql);

if ($hasil === false) {
    die("Error in SQL query: " . $conn->error); // Check if query is successful
}

// Handle "simpan" (Save)
if (isset($_POST['simpan'])) {
    $tanggal = date("Y-m-d H:i:s");
    $username = $_SESSION['username'];
    $gambar = '';
    $nama_gambar = $_FILES['gambar']['name'];

    if ($nama_gambar != '') {
        $cek_upload = upload_foto($_FILES["gambar"]);

        if ($cek_upload['status']) {
            // If the file is uploaded successfully, get the file name
            $gambar = $cek_upload['message'];
        } else {
            echo "<script>
                alert('" . $cek_upload['message'] . "');
                document.location='admin.php?page=gallery';
            </script>";
            die;
        }
    }

    // Check if there is an ID (Edit operation)
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        if ($nama_gambar == '') {
            // If no new image is uploaded, keep the old one
            $gambar = $_POST['gambar_lama'];
        } else {
            // If a new image is uploaded, delete the old one
            unlink("img/" . $_POST['gambar_lama']);
        }

        // Update query
        $stmt = $conn->prepare("UPDATE gallery 
                                SET gambar = ?, tanggal = ?, username = ?
                                WHERE id = ?");
        $stmt->bind_param("sssi", $gambar, $tanggal, $username, $id);
        $simpan = $stmt->execute();
    } else {
        // Insert new gallery item
        $stmt = $conn->prepare("INSERT INTO gallery (gambar, tanggal, username) 
                                VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $gambar, $tanggal, $username);
        $simpan = $stmt->execute();
    }

    if ($simpan) {
        echo "<script>
            alert('Simpan data sukses');
            document.location='admin.php?page=gallery';
        </script>";
    } else {
        echo "<script>
            alert('Simpan data gagal');
            document.location='admin.php?page=gallery';
        </script>";
    }

    $stmt->close();
}

// Handle "hapus" (Delete)
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    $gambar = $_POST['gambar'];

    if ($gambar != '') {
        unlink("img/" . $gambar);
    }

    $stmt = $conn->prepare("DELETE FROM gallery WHERE id = ?");
    $stmt->bind_param("i", $id);
    $hapus = $stmt->execute();

    if ($hapus) {
        echo "<script>
            alert('Hapus data sukses');
            document.location='admin.php?page=gallery';
        </script>";
    } else {
        echo "<script>
            alert('Hapus data gagal');
            document.location='admin.php?page=gallery';
        </script>";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <!-- Add custom CSS for modal styling -->
    <style>
        /* Mengubah warna teks pada modal */
        .modal-content {
            color: black;
        }

        .modal-header .modal-title {
            color: black;
        }

        .modal-body {
            color: black;
        }

        .modal-footer {
            color: black;
        }

        /* Gaya untuk label dan input form */
        .form-label, .form-control {
            color: black;
        }

        /* Jika ada placeholder dalam input form */
        ::placeholder {
            color: black;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg"></i> Tambah gallery
    </button>

    <div class="row">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 30%;">Tanggal</th>
                        <th style="width: 40%;">Gambar</th>
                        <th style="width: 25%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if ($hasil->num_rows > 0) {
                    $no = $offset + 1; // Start numbering from the offset
                    while ($row = $hasil->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <strong><?= isset($row["tanggal"]) ? $row["tanggal"] : 'N/A' ?></strong>
                                <br>oleh: <?= isset($row["username"]) ? $row["username"] : 'Unknown' ?>
                            </td>
                            <td>
                                <?php
                                if (isset($row["gambar"]) && $row["gambar"] != '') {
                                    $image_path = 'img/' . $row["gambar"];
                                    if (file_exists($image_path)) {
                                ?>
                                        <img src="<?= $image_path ?>" width="100">
                                <?php
                                    } else {
                                        echo "Image not found.";
                                    }
                                } else {
                                    echo "No Image";
                                }
                                ?>
                            </td>
                            <td>
                                <!-- Edit and Delete Actions -->
                                <a href="#" title="edit" class="badge rounded-pill text-bg-success" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row["id"] ?>"><i class="bi bi-pencil"></i></a>
                                <a href="#" title="delete" class="badge rounded-pill text-bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row["id"] ?>"><i class="bi bi-x-circle"></i></a>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEdit<?= $row["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit gallery</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="post" action="" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="formGroupExampleInput2" class="form-label">Ganti Gambar</label>
                                                <input type="file" class="form-control" name="gambar">
                                            </div>
                                            <div class="mb-3">
                                                <label for="formGroupExampleInput3" class="form-label">Gambar Lama</label>
                                                <?php
                                                if ($row["gambar"] != '') {
                                                    if (file_exists('img/' . $row["gambar"])) {
                                                ?>
                                                        <br><img src="img/<?= $row["gambar"] ?>" width="100">
                                                <?php
                                                    }
                                                }
                                                ?>
                                                <input type="hidden" name="gambar_lama" value="<?= $row["gambar"] ?>">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <input type="submit" value="simpan" name="simpan" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="modalHapus<?= $row["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Hapus gallery</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="post" action="" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="formGroupExampleInput" class="form-label">Yakin akan menghapus gambar "<strong><?= $row["gambar"] ?></strong>"?</label>
                                                <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                                <input type="hidden" name="gambar" value="<?= $row["gambar"] ?>">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <input type="submit" value="Hapus" name="hapus" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                <?php
                    }
                } else {
                    echo "No records found.";
                }
                ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
                <?php } ?>
                <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Modal Tambah -->
        <div class="modal fade" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah gallery</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="formGroupExampleInput2" class="form-label">Gambar</label>
                                <input type="file" class="form-control" name="gambar">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" value="Simpan" name="simpan" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
// Close connection
$conn->close();
?>

<!-- Include Bootstrap JS (Make sure to include Bootstrap JS files) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
