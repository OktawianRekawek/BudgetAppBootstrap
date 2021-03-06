<?php

session_start();

if (isset($_SESSION['logged_id'])) {
  header("Location: www/home.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="pl">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>MyBudget</title>
  <meta name="description" content="Aplikacja do prowadzenia budżetu osobistego">
  <meta name="keywords" content="budżet, finanse, osobiste, pieniądze, oszczędności">
  <meta name="author" content="Oktawian Rękawek">
  <meta http-equiv="X-Ua-Compatible" content="IE=edge">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/main.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <!--[if lt IE 9]>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->

</head>

<body>

  <header class="container-fluid bg-sea text-light">
    <nav class="container navbar navbar-dark">
      <a href="#" class="navbar-brand mr-auto"><i class="fas fa-search-dollar mr-1"></i> MyBudget</a>
      <a href="www/login.php" class="btn btn-dark mr-md-1 my-1 font-weight-bold" role="button">
        <i class="fas fa-sign-in-alt mr-1"></i> Zaloguj się
      </a>
      <a href="www/register.php" class="btn btn-info my-1 font-weight-bold" role="button"> <i class="fas fa-user-plus mr-1"></i> Zarejestruj się
      </a>

    </nav>
  </header>

  <main class="container my-3">
    <div class="row baner justify-content-center no-gutters">
      <div class="col-lg-6 mt-3 px-3">
        <p class="text-uppercase h2">Kontroluj wydatki!</p>
        <p class="text-uppercase h2 text-right">Buduj oszczędności!</p>

        <p class="my-4 px-3 px-sm-5 slogan">Zapanuj nad swoimi pieniędzmi dzięki aplikacji <strong>MyBudget</strong>! <a href="www/register.php" class="text-info font-weight-bold">Zarejestruj się</a> teraz i już od dziś zacznij spełniać swoje marzenia oraz ciesz się życiem wolnym od kłopotów finansowych!</p>

        <blockquote class="blockquote text-center display-4">
          <p class="mb-0 cite px-3 mt-5">„Zrobić budżet to wskazać swoim pieniądzom, dokąd mają iść, zamiast się zastanawiać, gdzie się rozeszły.”</p>
          <footer class="blockquote-footer text-right pb-2">John C. Maxwell </footer>
        </blockquote>

      </div>
      <div class="col-lg-6 align-self-end">
        <img class="img-fluid" src="img/wallet-2292428_1920.jpg" alt="">
      </div>
    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

  <script src="js/bootstrap.min.js"></script>

</body>

</html>
