<?php

// Menyertakan file koneksi
include "koneksi.php";

// Check jika sudah ada user yang login, arahkan ke halaman admin
if (!isset($_SESSION['username'])) { 
    header("location:login.php"); 
    exit();
}

//query untuk mengambil data article
$sql1 = "SELECT * FROM article ORDER BY tanggal DESC";
$hasil1 = $conn->query($sql1);

//menghitung jumlah baris data article
$jumlah_article = $hasil1->num_rows;

//query untuk mengambil data gallery
$sql2 = "SELECT * FROM gallery ORDER BY tanggal DESC";
$hasil2 = $conn->query($sql2);

//menghitung jumlah baris data gallery
$jumlah_gallery = $hasil2->num_rows;
?>

<!-- Display the Article and Gallery cards directly -->
<div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center pt-4">
    <!-- Article Card -->
    <div class="col">
        <a href="admin.php?page=article" class="text-decoration-none">
            <div class="card border border-danger mb-3 shadow hover-card" style="max-width: 18rem;">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="p-3">
                            <h5 class="card-title"><i class="bi bi-newspaper"></i> Article</h5> 
                        </div>
                        <div class="p-3">
                            <span class="badge rounded-pill text-bg-danger fs-2"><?= $jumlah_article; ?></span>
                        </div> 
                    </div>
                </div>
            </div>
        </a>
    </div> 

    <!-- Gallery Card -->
    <div class="col">
        <a href="admin.php?page=gallery" class="text-decoration-none">
            <div class="card border border-danger mb-3 shadow hover-card" style="max-width: 18rem;">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="p-3">
                            <h5 class="card-title"><i class="bi bi-camera"></i> Gallery</h5> 
                        </div>
                        <div class="p-3">
                            <span class="badge rounded-pill text-bg-danger fs-2"><?= $jumlah_gallery; ?></span>
                        </div> 
                    </div>
                </div>
            </div>
        </a>
    </div> 
</div>

<style>
    /* Hover effect for the cards */
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-card:hover {
        transform: scale(1.05);  /* Slightly enlarge the card */
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);  /* Add a shadow effect */
    }

    /* Optional: Add active click effect */
    .hover-card:active {
        transform: scale(1);  /* Reset the size to normal when clicking */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);  /* Smaller shadow when clicked */
    }
</style>
