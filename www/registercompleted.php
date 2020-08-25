<?php
  session_start();

  if (!isset($_SESSION['registersucceed']))
  {
    header('Location: register.php');
    exit();
  }
  else
  {
    unset($_SESSION['registersucceed']);
  }

  //usuwany zmienne pamietanych wpisane wartosci formularza
  if(isset($_SESSION['fr_name'])) unset($_SESSION['fr_name']);
  if(isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
  if(isset($_SESSION['fr_password'])) unset($_SESSION['fr_password']);


  //Usuwanie błędów rejestracji
  if(isset($_SESSION['e_name'])) unset($_SESSION['e_name']);
  if(isset($_SESSION['e_email'])) unset($_SESSION['e_mail']);
  if(isset($_SESSION['e_password'])) unset($_SESSION['e_password']);
?>


<!DOCTYPE html>
<html lang="pl">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>MyBudget - rejestracja</title>
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
    <nav class="container navbar navbar-dark">
      <a href="../index.html" class="navbar-brand mr-auto"><i class="fas fa-search-dollar mr-1"></i> MyBudget</a>
      <a href="login.html" class="btn btn-dark mr-md-1 my-1 font-weight-bold" role="button">
        <i class="fas fa-sign-in-alt mr-1"></i> Zaloguj się
      </a>
      <a href="register.php" class="btn btn-info my-1 font-weight-bold" role="button"> <i class="fas fa-user-plus mr-1"></i> Zarejestruj się
      </a>
    </nav>
  </header>

  <main class="container my-3">

    <div class="row registration">
      <header class="col-md-8 col-lg-6 mx-auto bg-sea text-center text-uppercase text-light py-2">
        <h1 class="h2 mb-0">Rejestracja zakończona</h1>
      </header>
      <div class="w-100"></div>
      <div class="col-md-8 col-lg-6 bg-light mx-auto py-3 text-center">
        <p class="font-weight-bold h5">Dziękujemy za rejestrację!</p>
        <p class="font-weight-bold h5">Możesz się już zalogować na swoje konto!</p>
      </div>
      <div class="w-100"></div>
      <aside class="col-md-8 col-lg-6 mx-auto bg-sea text-center text-light py-2">
        <a href="login.php" class="btn btn-dark mr-md-1 font-weight-bold" role="button">
          Zaloguj się
        </a>
      </aside>
    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

  <script src="../js/bootstrap.min.js"></script>

</body>

</html>
