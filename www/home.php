<?php

session_start();

if (!isset($_SESSION['logged_id'])) {
  header("Location: ../index.php");
  exit();
}

require_once('database.php');
  
$userId = $_SESSION['logged_id'];

$userNameQuery = $db -> query("SELECT username FROM users WHERE id = '$userId'");
$userName = $userNameQuery->fetchAll();


?>

<!DOCTYPE html>
<html lang="pl">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>MyBudget - Start</title>
  <meta name="description" content="Aplikacja do prowadzenia budżetu osobistego">
  <meta name="keywords" content="budżet, finanse, osobiste, pieniądze, oszczędności">
  <meta name="author" content="Oktawian Rękawek">
  <meta http-equiv="X-Ua-Compatible" content="IE=edge">

  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/main.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <!--[if lt IE 9]>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->

</head>

<body>

  <header class="container-fluid bg-sea text-light">
    <nav class="container navbar navbar-dark navbar-expand-xl">
      <a href="../index.php" class="navbar-brand mr-auto"><i class="fas fa-search-dollar mr-1"></i> MyBudget</a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="mainmenu">

        <ul class="navbar-nav mr-auto">

          <li class="nav-item active">
            <a class="nav-link" href="#"><i class="fas fa-home"></i> Start </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="addIncome.php"><i class="fas fa-wallet"></i> Dodaj Przychód </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="addExpense.php"><i class="fas fa-shopping-basket"></i> Dodaj Wydatek </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="balance.php"><i class="fas fa-balance-scale"></i> Przeglądaj Bilans </a>
          </li>

          <li class="nav-item">
            <a class="nav-link disabled" href="#"><i class="fas fa-cogs"></i> Ustawenia </a>
          </li>

        </ul>

        <a href="logout.php" class="btn btn-dark mr-md-1 my-1 font-weight-bold" role="button">
          <i class="fas fa-sign-out-alt"></i> Wyloguj się
        </a>

      </div>

    </nav>
  </header>

  <main class="container my-3">
    <div class="row baner justify-content-center no-gutters">
      <div class="col-lg-6 mt-3 px-3">
        <p class="text-uppercase h2">Witaj
          <?= $userName[0]['username'];?>!
        </p>

        <p class="my-4 px-3 px-sm-5 slogan">Aplikacja <strong>MyBudget</strong> pomoże Ci kontolować swoje finanse. Co chcesz teraz zrobić?</p>

        <ul class="navbar-nav mr-auto mb-3">


          <li class="nav-item">
            <a class="nav-link btn btn-success mr-md-1 my-1 font-weight-bold" href="addIncome.php"><i class="fas fa-wallet"></i> Dodaj Przychód </a>
          </li>

          <li class="nav-item">
            <a class="nav-link btn btn-danger mr-md-1 my-1 font-weight-bold" href="addExpense.php"><i class="fas fa-shopping-basket"></i> Dodaj Wydatek </a>
          </li>

          <li class="nav-item">
            <a class="nav-link btn btn-info mr-md-1 my-1 font-weight-bold" href="balance.php"><i class="fas fa-balance-scale"></i> Przeglądaj Bilans </a>
          </li>

          <li class="nav-item">
            <a class="nav-link disabled btn btn-dark mr-md-1 my-1 font-weight-bold" href="#"><i class="fas fa-cogs"></i> Ustawenia </a>
          </li>
          <li class="nav-item">
            <a href="../index.php" class="nav-link btn btn-dark mr-md-1 my-1 font-weight-bold" role="button">
              <i class="fas fa-sign-out-alt"></i> Wyloguj się
            </a>
          </li>
        </ul>
      </div>
      <div class="col-lg-6 align-self-end">
        <img class="img-fluid" src="../img/wallet-2292428_1920.jpg" alt="">
      </div>
    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

  <script src="../js/bootstrap.min.js"></script>

</body>

</html>
