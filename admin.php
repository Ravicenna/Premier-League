<?php
session_start();

include "koneksi.php";  

//check jika belum ada user yang login arahkan ke halaman login
if (!isset($_SESSION['username'])) { 
    header("location:login.php"); 
    exit();
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Premier League | Admin</title>
    <link rel="icon" href="img/logo.png" />
    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
    />
    <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
    crossorigin="anonymous"
    />
    <style> 
        html, body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            margin: 0;
            background: url('img/bg3.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            flex: 1;
        }

        .welcome-text {
            font-size: 2rem;
            font-weight: bold;
            color: white;
            text-align: center;
            animation: moveTextVertical 2s infinite;
        }

        @keyframes moveTextVertical {
            0% { transform: translateY(0); }
            50% { transform: translateY(10px); }
            100% { transform: translateY(0); }
        }

        .page-content, .page-content h4, .page-content p {
            color: white;
            font-weight: bold;
        }

        .page-title {
            border-bottom: 2px solid white;
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <!-- nav begin -->
    <nav class="navbar navbar-expand-lg sticky-top" style="background-color: #430A5D;">
    <div class="container">
        <img src="img/logo2.png" alt="Logo" style="width: 30px; height: 30px; margin-right: 5px;">
        <a class="navbar-brand text-white" href="#">Premier League</a>
        <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
        >
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-light">
            <li class="nav-item">
                <a class="nav-link text-white" href="admin.php?page=dashboard">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="admin.php?page=article">Article</a>
            </li> 
            <li class="nav-item">
                <a class="nav-link text-white" href="admin.php?page=gallery">Gallery</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="admin.php?page=profile">Profile</a>
            </li> 
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?= $_SESSION['username'] ?>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li> 
                </ul>
            </li> 
        </ul>
        </div>
    </div>
    </nav>
    <!-- nav end -->
    <!-- content begin -->
    <section id="content" class="p-5 page-content">
        <div class="container text-center"> 
            <?php if(!isset($_GET['page']) || $_GET['page'] === 'dashboard'): ?>
                <p class="welcome-text">Welcome <?= $_SESSION['username'] ?>!</p>
            <?php endif; ?>
        </div>
        <div class="container"> 
            <?php if(isset($_GET['page'])): ?>
                <h4 class="lead display-6 pb-2 page-title"><?= ucfirst($_GET['page'])?></h4>
                <?php include($_GET['page'].".php"); ?>
            <?php else: ?>
                <h4 class="lead display-6 pb-2 page-title">Dashboard</h4>
                <?php include("dashboard.php"); ?>
            <?php endif; ?>
        </div>
    </section>
    <!-- content end -->
    <!-- footer begin -->
    <footer class="text-center p-5 text-white mt-auto" style="background-color: #430A5D;">
        <div>
            <a href="instagram.com" class="text-white" style="font-size: 2rem;"><i class="bi bi-facebook"></i></a>
            <a href="instagram.com" class="text-white" style="font-size: 2rem;"><i class="bi bi-instagram"></i></a>
            <a href="instagram.com" class="text-white" style="font-size: 2rem;"><i class="bi bi-twitter-x"></i></a>
        </div>
        <div>
            Ravicenna Mahardhika &copy, 2024
        </div>
    </footer>
    <!-- footer end -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
