<?php

session_start();

if (!isset($_SESSION['logged_id'])) {
  header("Location: ../index.php");
  exit();
} else {
  
  require_once('database.php');
  
  $userId = $_SESSION['logged_id'];
  
  //$currentDate = now();
  $selectedPeriod="Bieżący miesiąc";
  
  if (isset($_POST['period'])){
    $selectedPeriod = $_POST['period'];
    if ($selectedPeriod == "Poprzedni miesiąc") {
      $startDate = mktime(0,0,0,date('m')-1,1,date('Y')) ;
      $endDate = mktime(0,0,0,date('m'),0,date('Y')) ;
    }
    else if ($selectedPeriod == "Bieżący rok") {
      $startDate = mktime(0,0,0,1,1,date('Y')) ;
      $endDate = mktime(0,0,0,12,31,date('Y')) ;
    } else {
    $startDate = mktime(0,0,0,date('m'),1,date('Y')) ;
    $endDate = mktime(0,0,0,date('m')+1,0,date('Y')) ;
    }
  } else {
    $startDate = mktime(0,0,0,date('m'),1,date('Y')) ;
    $endDate = mktime(0,0,0,date('m')+1,0,date('Y')) ;
  }
  
  
 if ($selectedPeriod == "Niestandardowy" && isset($_POST['date1']) && isset($_POST['date2']) && ($_POST['date1'] <= $_POST['date2'])) {
    $startDateSQL = $_POST['date1'];
    $endDateSQL = $_POST['date2'];
  } else {
    $startDateSQL = date("Y-m-d",$startDate);
    $endDateSQL = date("Y-m-d",$endDate);
  }
  
  $expenseQuery = $db->query("SELECT c.name, SUM(amount) as amount
                              FROM expenses_category_assigned_to_users as c, expenses as e, users as u
                              WHERE c.user_id='$userId'
                              AND c.id = e.expense_category_assigned_to_user_id
                              AND e.user_id = u.id
                              AND c.user_id = u.id
                              AND e.date_of_expense BETWEEN '$startDateSQL' AND '$endDateSQL'
                              GROUP BY c.name");
  
  $expenses = $expenseQuery->fetchAll();
  
  $incomeQuery = $db->query("SELECT c.name, SUM(amount) as amount
                              FROM incomes_category_assigned_to_users as c, incomes as i, users as u
                              WHERE c.user_id='$userId'
                              AND c.id = i.income_category_assigned_to_user_id
                              AND i.user_id = u.id
                              AND c.user_id = u.id
                              AND i.date_of_income BETWEEN '$startDateSQL' AND '$endDateSQL'
                              GROUP BY c.name");

  $incomes = $incomeQuery->fetchAll();
  
  
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
            <a class="nav-link" href="addExpense.php"><i class="fas fa-shopping-basket"></i> Dodaj Wydatek </a>
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
      <div class="col-md-8 col-lg-6 bg-light mx-auto py-3 text-center">
        <form method="post">
          <div class="form-group row justify-content-center">
            <label for="period" class="col-sm-3 col-form-label">Okres</label>
            <div class="col-sm-8">
              <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-list"></i></span></div>
                <select name="period" id="period" class="form-control" onchange="submit(this);">

                  <option <?php if ($selectedPeriod=="Bieżący miesiąc" ) echo "selected" ;?>>Bieżący miesiąc</option>
                  <option <?php if ($selectedPeriod=="Poprzedni miesiąc" ) echo "selected" ;?>>Poprzedni miesiąc</option>
                  <option <?php if ($selectedPeriod=="Bieżący rok" ) echo "selected" ;?>>Bieżący rok</option>
                  <option <?php if ($selectedPeriod=="Niestandardowy" ) echo "selected" ;?>>Niestandardowy</option>
                </select>

              </div>
            </div>
          </div>
          <?php
          if ($selectedPeriod=="Niestandardowy" ){
            echo '<div class="form-group row justify-content-center">
                      <label for="date1" class="col-sm-1 col-form-label">Od</label>
                      <div class="col-xl-5">
                        <div class="input-group">
                          <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar"></i></span></div>
                          <input type="date" class="form-control id="date1" name="date1" value="';
            if(isset($_POST['date1'])) echo $_POST['date1'];
            echo '">
                        </div>
                      </div>
                      <label for="date2" class="col-sm-1 col-form-label">Do</label>
                      <div class="col-xl-5">
                        <div class="input-group">
                          <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar"></i></span></div>
                          <input type="date" class="form-control id="date2" name="date2" value="';
            if(isset($_POST['date2'])) echo $_POST['date2'];
            echo '">
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-info btn-lg font-weight-bold">Wyszukaj</button>';
          }
          ?>
        </form>
        <?php
          if ($selectedPeriod!="Niestandardowy" ){
            echo '<h3 class="text-center">'.date('d.m.Y',$startDate).' - '.date('d.m.Y',$endDate).'</h3>';
          }
          ?>

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
            $incomesSum = 0;
            foreach ($incomes as $income) {
              echo "<div class='col-6'><p>
              {$income['name']}
              </p>
                    </div>
                    <div class='col-6 text-right'>
                      <p>".number_format($income['amount'], 2, ',', ' ')."</p>
                    </div>";
              $incomesSum += $income['amount'];
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
            $expenesSum = 0;
            foreach ($expenses as $expense) {
              echo "<div class='col-6'><p>
              {$expense['name']}
              </p>
                    </div>
                    <div class='col-6 text-right'>
                      <p>".number_format($expense['amount'], 2, ',', ' ')."</p>
                    </div>";
              $expenesSum += $expense['amount'];
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
            <h3>
              <?php echo number_format($incomesSum, 2, ',', ' ');?>
            </h3>
          </div>
        </div>
      </div>
      <div class="col-md-5 bg-light m-1 expanses-sum order-3">
        <div class="row">
          <div class="col-6">
            <h3>Suma:</h3>
          </div>
          <div class="col-6 text-right">
            <h3>
              <?php echo number_format($expenesSum, 2, ',', ' ');?>
            </h3>
          </div>
        </div>
      </div>
      <div class="col-md-8 bg-light order-4 text-center my-3 py-3">
        <?php
        $balance = $incomesSum - $expenesSum;
        echo "<h3>Bilans: ".number_format($balance, 2, ',', ' ')." PLN</h3>";
        if ($balance > 0) {
          echo '<p class="h4 text-success">Gratulacje! Świetnie zarządzasz finansami!</p>';
        } else {
          echo '<p class="h4 text-danger">Uważaj! Twoje finanse mają się kiepsko!</p>';
        }
        ?>
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
