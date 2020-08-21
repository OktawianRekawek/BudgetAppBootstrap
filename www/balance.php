<?php

session_start();

if (!isset($_SESSION['logged_id'])) {
  header("Location: ../index.php");
  exit();
} else {
  
  require_once('database.php');
  
  $userId = $_SESSION['logged_id'];
  
  $expenseCategoriesQuery = $db->query("SELECT name FROM expenses_category_assigned_to_users WHERE user_id = '$userId'");
  
  $expenseCategories = $expenseCategoriesQuery->fetchAll();
  
  $incomeCategoriesQuery = $db->query("SELECT name FROM incomes_category_assigned_to_users WHERE user_id = '$userId'");
  
  $incomeCategories = $incomeCategoriesQuery->fetchAll();
  
  
}

?>

<!DOCTYPE html>
<html lang="pl">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>MyBudget - Przeglądaj Bilans</title>
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

          <li class="nav-item">
            <a class="nav-link" href="home.php"><i class="fas fa-home"></i> Start </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="addIncome.php"><i class="fas fa-wallet"></i> Dodaj Przychód </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="addExpanse.php"><i class="fas fa-shopping-basket"></i> Dodaj Wydatek </a>
          </li>

          <li class="nav-item active">
            <a class="nav-link" href="#"><i class="fas fa-balance-scale"></i> Przeglądaj Bilans </a>
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
    <div class="row justify-content-center balance">
      <header class="col-md-8 col-lg-6 mx-auto bg-sea text-center text-uppercase text-light py-2">
        <h1 class="h2 mb-0">Przegląd Bilansu</h1>
      </header>
      <div class="w-100"></div>
      <div class="col-md-8 col-lg-6 bg-light mx-auto pt-3 text-center">
        <form>
          <div class="form-group row justify-content-center">
            <label for="period" class="col-sm-3 col-form-label">Okres</label>
            <div class="col-sm-8">
              <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-list"></i></span></div>
                <select name="period" id="period" class="form-control">

                  <option>Bieżący miesiąc</option>
                  <option>Poprzedni miesiąc</option>
                  <option>Bieżący rok</option>
                  <option>Niestandardowy</option>
                </select>
              </div>
            </div>
          </div>
        </form>
        <h3 class="text-center">01.05.2020 - 31.05.2020</h3>
      </div>
      <div class="w-100 my-2"></div>
      <div class="col-md-5 bg-light mx-1 incomes">
        <h2 class="text-center py-2">Przychody</h2>
        <div class="row px-4">
          <div class="col-6 border-bottom mb-3">
            <h4>Kategoria</h4>
          </div>
          <div class="col-6 text-right border-bottom mb-3">
            <h4>Wartość [PLN]</h4>
          </div>
          <?php
            foreach ($incomeCategories as $incomeCategory) {
              echo "<div class='col-6'><p>
              {$incomeCategory['name']}
              </p>
                    </div>
                    <div class='col-6 text-right'>
                      <p>2000.00</p>
                    </div>";
            }
          ?>
        </div>
      </div>
      <div class="col-md-5 bg-light mx-1 expanses order-2 order-md-1">
        <h2 class="text-center py-2">Wydatki</h2>
        <div class="row px-4">
          <div class="col-6 border-bottom mb-3">
            <h4>Kategoria</h4>
          </div>
          <div class="col-6 text-right border-bottom mb-3">
            <h4>Wartość [PLN]</h4>
          </div>
          <?php
            foreach ($expenseCategories as $expenseCategory) {
              echo "<div class='col-6'><p>
              {$expenseCategory['name']}
              </p>
                    </div>
                    <div class='col-6 text-right'>
                      <p>2000.00</p>
                    </div>";
            }
          ?>
        </div>
      </div>
      <div class="col-md-5 bg-light m-1 incomes-sum order-1 order-md-2 border-top">
        <div class="row">
          <div class="col-6">
            <h3>Suma:</h3>
          </div>
          <div class="col-6 text-right">
            <h3>3500.00</h3>
          </div>
        </div>
      </div>
      <div class="col-md-5 bg-light m-1 expanses-sum order-3">
        <div class="row">
          <div class="col-6">
            <h3>Suma:</h3>
          </div>
          <div class="col-6 text-right">
            <h3>2600.00</h3>
          </div>
        </div>
      </div>
      <div class="col-md-8 bg-light order-4 text-center my-3 py-3">
        <h3>Bilans: 900.00 PLN</h3>
        <p class="h4 text-success">Gratulacje! Świetnie zarządzasz finansami!</p>
      </div>
      <div class="col-md-6 bg-light incomes-graph order-5">
        <img src="../img/Pie-chart.jpg" alt="" class="img-fluid">
      </div>
      <div class="col-md-6 bg-light expanses-graph order-6">
        <img src="../img/Pie-chart.jpg" alt="" class="img-fluid">
      </div>
    </div>
  </main>


  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

  <script src="../js/bootstrap.min.js"></script>

</body>

</html>
