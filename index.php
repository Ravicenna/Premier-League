<?php
include "koneksi.php"; 
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Premier League</title>
    <div id="currentTime" class="text-white mx-auto"></div>
    <link rel="icon" href="img/logo.png" />    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"/>
 
    <style>
      body.dark-mode small {
          color: white !important;
      }
    </style>
  </head>

  <body>
<!-- Nav -->
<nav class="navbar navbar-expand-lg sticky-top" style="background-color: #430A5D;">
    <div class="container">
        <img src="img/logo2.png" alt="Logo" style="width: 30px; height: 30px; margin-right: 5px;">
        <a class="navbar-brand text-white" href="#">Premier League</a>
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-dark">
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#article">Article</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#gallery">Gallery</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#schedule">Schedule</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#aboutme">About Me</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="login.php" target="_blank">Login</a>
                </li>
            </ul>
            <button id="darkModeToggle" class="btn btn-outline-light ms-3">
                <i id="modeIcon" class="bi bi-moon-stars-fill"></i> Dark Mode
            </button>
        </div>
    </div>
</nav>

      <section id="hero" class="text-center p-5 .bg-light text-sm-start">
        <div class="container">
            <div class="d-sm-flex align-items-center">
                <img src="img/logo1.webp" class="img-fluid me-sm-5" width="300">
                <img src="img/logolight.png" class="img-fluid me-sm-5" width="300">
                <div>
                    <h1 class="fw-bold display-4" style="color: #430A5D;">The Glory of English Football</h1>
                    <h4 class="lead display-6">Explore the origins of the Premier League and its journey to becoming one of the most-watched sports leagues in the world.</h4>
                </div>
            </div>
        </div>
    </section>

<!-- Article -->
<section id="article" class="text-center p-5">
      <div class="container">
        <h1 class="fw-bold display-4 pb-5">Article</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
          <?php
          $sql = "SELECT * FROM article ORDER BY tanggal DESC";
          $hasil = $conn->query($sql); 

          while($row = $hasil->fetch_assoc()){
          ?>
            <div class="col">
              <div class="card h-100">
                <img src="img/<?= $row["gambar"]?>" class="card-img-top p-5 pb-1" alt="..." />
                <div class="card-body">
                  <h5 class="card-title"><?= $row["judul"]?></h5>
                  <p class="card-text">
                    <?= $row["isi"]?>
                  </p>
                </div>
                <div class="card-footer">
                  <small class="text-body-secondary">
                    <?= $row["tanggal"]?>
                  </small>
                </div>
              </div>
            </div>
            <?php
          }
          ?> 
        </div>
      </div>
    </section>

<!-- Gallery -->
    <section id="gallery" class="text-center p-5">
        <div class="container">
          <h1 class="fw-bold display-5 pb-3" style="color: #430A5D;">Gallery</h1>
            <div id="carouselExample" class="carousel slide">
                <div class="carousel-inner p-3">
                  <div class="carousel-item active">
                    <img src="img/gallery1.jpg" class="d-block w-100" alt="Image 1">
                  </div>
                  <div class="carousel-item">
                    <img src="img/gallery2.jpg" class="d-block w-100" alt="Image 3">
                  </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
        </div>
    </section>

<!-- schedule begin -->
<section id="schedule" class="text-center p-5">
  <div class="container">
    <h1 class="fw-bold display-4 pb-5">Schedule</h1>
    <div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center">
      <div class="col">
        <div class="card h-100">
          <div class="card-header bg-danger text-white">SENIN</div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              Manchester United vs Newcastle United<br />16.20-18.00 | Old Trafford
            </li>
            <li class="list-group-item">
              Arsenal vs Aston Villa<br />20.00-22.00 | Emirates Stadium
            </li>
          </ul>
        </div>
      </div>
      <div class="col">
        <div class="card h-100">
          <div class="card-header bg-danger text-white">SELASA</div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              Tottenham Hotspur vs Everton<br />18.30-21.00 | Tottenham Hotspur Stadium
            </li>
          </ul>
        </div>
      </div>
      <div class="col">
        <div class="card h-100">
          <div class="card-header bg-danger text-white">RABU</div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              Liverpool vs Manchester United<br />16.00-18.00 | Anfield
            </li>
            <li class="list-group-item">
              Manchester City vs Chelsea<br />18.30-20.30 | Etihad Stadium
            </li>
            <li class="list-group-item">
              Arsenal vs Leeds United<br />21.00-23.00 | Emirates Stadium
            </li>
          </ul>
        </div>
      </div>
      <div class="col">
        <div class="card h-100">
          <div class="card-header bg-danger text-white">KAMIS</div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              Chelsea vs Fulham<br />16.20-18.00 | Stamford Bridge
            </li>
            <li class="list-group-item">
              Manchester United vs Liverpool<br />20.00-22.00 | Old Trafford
            </li>
          </ul>
        </div>
      </div>
      <div class="col">
        <div class="card h-100">
          <div class="card-header bg-danger text-white">JUMAT</div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              Manchester City vs Wolverhampton Wanderers<br />18.30-21.00 | Etihad Stadium
            </li>
          </ul>
        </div>
      </div>
      <div class="col">
        <div class="card h-100">
          <div class="card-header bg-danger text-white">SABTU</div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              Tottenham Hotspur vs Brighton & Hove Albion<br />16.20-18.00 | Tottenham Hotspur Stadium
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- about me begin -->
<section id="aboutme" class="text-center p-5">
<h1 class="fw-bold display-4 pb-5">About Me</h1>
  <div class="container">
    <div class="d-sm-flex align-items-center justify-content-center">
      <div class="p-3">
        <img
          src="img/son.jpg"
          class="rounded-circle border shadow"
          width="300"
        />
      </div>
      <div class="p-md-5 text-sm-start">
        <h3 class="lead">A11.2023.12345</h3>
        <h1 class="fw-bold">Ravicenna Mahardhika</h1>
        Program Studi Teknik Informatika<br />
        <a href="https://dinus.ac.id/" class="fw-bold text-decoration-none"
          >Universitas Dian Nuswantoro</a
        >
      </div>
    </div>
  </div>
</section>


<!-- Footer -->
    <footer class="text-center p-5 text-white" style="background-color: #430A5D;">
        <div>
          <a href="instagram.com" class="text-white" style="font-size: 2rem;"><i class="bi bi-facebook"></i></a>
          <a href="instagram.com" class="text-white" style="font-size: 2rem;"><i class="bi bi-instagram"></i></a>
          <a href="instagram.com" class="text-white" style="font-size: 2rem;"><i class="bi bi-twitter-x"></i></a>
        </div>
        <div>
            Ravicenna Mahardhika &copy, 2024
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
    crossorigin="anonymous"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const darkModeToggle = document.getElementById('darkModeToggle');
    const body = document.body;
    const logo1 = document.querySelector('img[src="img/logo1.webp"]');
    const logolight = document.querySelector('img[src="img/logolight.png"]');
    const navbar = document.querySelector('nav');
    const navbarLinks = document.querySelectorAll('.nav-link'); 
    const brand = document.querySelector('.navbar-brand'); 
    const sections = document.querySelectorAll('#hero, #article, #gallery, #schedule, #aboutme');
    const sectionTexts = document.querySelectorAll('#hero h1, #hero h4, #article h1, #gallery h1, #schedule h1, #aboutme'); 
    const footer = document.querySelector('footer');
    const footerIcons = footer.querySelectorAll('i');
    const footerText = footer.querySelector('div:last-child');
    const articleSection = document.getElementById('article');
    const cards = document.querySelectorAll('.card');
    const smallTexts = document.querySelectorAll('small.text-body-secondary');
    const cardHeaders = document.querySelectorAll('.card-header');
    const scheduleSection = document.getElementById('schedule'); // Select the schedule section
    const scheduleLists = document.querySelectorAll('#schedule ul.list-group'); // Select all <ul> elements in the schedule section
    const scheduleItems = document.querySelectorAll('#schedule li.list-group-item'); // Select all <li> elements in the schedule section

    // Initial setup for light mode
    logolight.style.display = 'none';
    sections.forEach(section => section.style.backgroundColor = '#00FFC6');
    if (articleSection) {
        articleSection.style.backgroundImage = "url('img/darkbgs.jpg')";
        articleSection.style.backgroundSize = 'cover';
        articleSection.style.backgroundPosition = 'center';
    }
    cardHeaders.forEach(header => {
        header.style.backgroundColor = '#430A5D';
        header.classList.remove('bg-danger'); // Remove bg-danger class if present
    });
    scheduleSection.style.backgroundImage = "url('img/darkbgs.jpg')";
    scheduleSection.style.backgroundSize = 'cover';
    scheduleSection.style.backgroundPosition = 'center';

    
    cards.forEach(card => {
        card.style.backgroundColor = '#DEF7EF';
    });

   
    scheduleLists.forEach(list => {
        list.style.backgroundColor = '#DEF7EF';
    });
    scheduleItems.forEach(item => {
        item.style.backgroundColor = '#DEF7EF'; // Set <li> background color for light mode
    });

    darkModeToggle.addEventListener('click', () => {
        body.classList.toggle('dark-mode');

        if (body.classList.contains('dark-mode')) {
            darkModeToggle.innerHTML = '<i id="modeIcon" class="bi bi-sun-fill"></i> Light Mode';

            if (articleSection) {
                articleSection.style.backgroundImage = "url('img/lightbg.jpg')";
            }
            sections.forEach(section => section.style.backgroundColor = '#43004d');
            scheduleSection.style.backgroundImage = "url('img/lightbg.jpg')";

            // Dark mode styling
            navbar.style.backgroundColor = '#1F0030';
            brand.style.color = 'white';
            navbarLinks.forEach(link => link.style.color = 'white');
            logo1.style.display = 'none';
            logolight.style.display = 'inline-block';
            sectionTexts.forEach(text => text.style.color = 'white');
            footer.style.backgroundColor = '#1F0030';
            footerIcons.forEach(icon => icon.style.color = 'white');
            footerText.style.color = 'white';
            smallTexts.forEach(small => small.style.color = 'white');
            cardHeaders.forEach(header => header.style.backgroundColor = '#430A5D');
            cards.forEach(card => {
                card.style.backgroundColor = '#1F0030'; // Set card background color for dark mode
                card.style.color = 'white';
            });

            // Set <ul> and <li> elements in schedule section to dark mode color
            scheduleLists.forEach(list => {
                list.style.backgroundColor = '#1F0030';
            });
            scheduleItems.forEach(item => {
                item.style.backgroundColor = '#1F0030'; // Set <li> background color for dark mode
                item.style.color = 'white'; // Set text color to white
            });

        } else {
            darkModeToggle.innerHTML = '<i id="modeIcon" class="bi bi-moon-stars-fill"></i> Dark Mode';

            if (articleSection) {
                articleSection.style.backgroundImage = "url('img/darkbgs.jpg')";
            }
            sections.forEach(section => section.style.backgroundColor = '#00FFC6');
            scheduleSection.style.backgroundImage = "url('img/darkbgs.jpg')";

            // Light mode styling
            navbar.style.backgroundColor = '#430A5D';
            brand.style.color = 'white';
            navbarLinks.forEach(link => link.style.color = 'white');
            logo1.style.display = 'inline-block';
            logolight.style.display = 'none';
            sectionTexts.forEach(text => text.style.color = '#430A5D');
            footer.style.backgroundColor = '#430A5D';
            footerIcons.forEach(icon => icon.style.color = 'white');
            footerText.style.color = 'white';
            smallTexts.forEach(small => small.style.color = '');
            cardHeaders.forEach(header => header.style.backgroundColor = '#430A5D');
            cards.forEach(card => {
                card.style.backgroundColor = '#DEF7EF'; // Reset card background color for light mode
                card.style.color = '';
            });

            // Reset <ul> and <li> elements in schedule section to light mode color
            scheduleLists.forEach(list => {
                list.style.backgroundColor = '#DEF7EF';
            });
            scheduleItems.forEach(item => {
                item.style.backgroundColor = '#DEF7EF'; // Reset <li> background color for light mode
                item.style.color = ''; // Reset text color
            });
        }
    });

    // Hover effects for dark mode toggle button
    darkModeToggle.addEventListener('mouseenter', () => {
        darkModeToggle.style.backgroundColor = body.classList.contains('dark-mode') ? '#430A5D' : '#1F0030'; 
        darkModeToggle.style.color = 'white'; 
        darkModeToggle.style.border = '1px solid white'; 
    });

    darkModeToggle.addEventListener('mouseleave', () => {
        darkModeToggle.style.backgroundColor = body.classList.contains('dark-mode') ? '#1F0030' : '#430A5D'; 
        darkModeToggle.style.color = 'white'; 
        darkModeToggle.style.border = '1px solid white'; 
    });
});
</script>


</body>
</html>

