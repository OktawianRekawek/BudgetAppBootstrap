<?php

session_start();

if (!isset($_SESSION['logged_id'])) {
  header("Location: ../index.php");
  exit();
} else {
  
  require_once('database.php');
  
  $userId = $_SESSION['logged_id'];
  
  $categoriesQuery = $db->query("SELECT name FROM incomes_category_assigned_to_users WHERE user_id = '$userId'");
  
  $categories = $categoriesQuery->fetchAll();
  
  if (isset($_POST['amount'])) {
    
    $amount = $_POST['amount'];
    $selectedCategory = $_POST['category'];
    
    if (preg_match("/^[0-9]+(\,[0-9]{2})?$/", $amount)) {
      $correctAmount = str_replace(',','.',$amount);
    
    $categoryIdQuery = $db->query("SELECT id FROM incomes_category_assigned_to_users WHERE user_id = '$userId' AND name = '$selectedCategory'");
      
    $categoryId = $categoryIdQuery->fetchAll();
      
    $addIncomeQuery = $db->prepare('INSERT INTO incomes VALUES (NULL, :userid, :categoryId, :amount, :date, :desc)');
    $addIncomeQuery->bindValue(':userid', $userId, PDO::PARAM_INT);
    $addIncomeQuery->bindValue(':date', $_POST['date'], PDO::PARAM_INT);
    $addIncomeQuery->bindValue(':amount', $correctAmount, PDO::PARAM_INT);
    $addIncomeQuery->bindValue(':categoryId', $categoryId[0][0], PDO::PARAM_INT);
    $addIncomeQuery->bindValue(':desc', $_POST['comment'], PDO::PARAM_STR);
    $addIncomeQuery->execute();
      
    $_SESSION['incomeAdded'] = "Przychód został dodany!";
      
    } else {
      $_SESSION['e_amount'] = "Wpisz prawidłową kwotę!";
    }
    
  }
  
}

?>

<!DOCTYPE html>
<html lang="pl">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>MyBudget - Dodaj Przychód</title>
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

          <li class="nav-item active">
            <a class="nav-link" href="#"><i class="fas fa-wallet"></i> Dodaj Przychód </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="addExpense.php"><i class="fas fa-shopping-basket"></i> Dodaj Wydatek </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="balance.php"><i class="fas fa-balance-scale"></i> Przeglądaj Bilans </a>
          </li>

          <li class="nav-item">
            <a class="nav-link disabled" href="#"><i class="fas fa-cogs"></i> Ustawienia </a>
          </li>

        </ul>

        <a href="logout.php" class="btn btn-dark mr-md-1 my-1 font-weight-bold" role="button">
          <i class="fas fa-sign-out-alt"></i> Wyloguj się
        </a>

      </div>

    </nav>
  </header>
  <main class="container my-3">
    <div class="row addIncome">
      <header class="col-md-8 col-lg-6 mx-auto bg-sea text-center text-uppercase text-light py-2">
        <h1 class="h2 mb-0">Dodaj przychód</h1>
      </header>
      <div class="w-100"></div>
      <div class="col-md-8 col-lg-6 bg-light mx-auto py-3 text-center">
        <?php
         if (isset($_SESSION['incomeAdded'])) {
              echo '<div class="text-success h2 pb-3">'.$_SESSION['incomeAdded'].'</div>';
              unset($_SESSION['incomeAdded']);
            }
           
        ?>
        <form method="post">
          <div class="form-group row justify-content-center">
            <label for="amount" class="col-sm-3 col-form-label">Kwota</label>
            <div class="col-sm-8">
              <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-dollar-sign"></i></span></div>
                <input type="text" class="form-control" id="amount" name="amount">
              </div>
            </div>
            <?php
            if (isset($_SESSION['e_amount'])) {
              echo '<div class="input-err">'.$_SESSION['e_amount'].'</div>';
              unset($_SESSION['e_amount']);
            }
          ?>
          </div>

          <div class="form-group row justify-content-center">
            <label for="date" class="col-sm-3 col-form-label">Data</label>
            <div class="col-sm-8">
              <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar"></i></span></div>
                <input type="date" class="form-control" id="date" name="date" value="<?php
                                                                          echo date('Y-m-d');
                                                                         ?>" max="<?php
                                                                          echo date('Y-m-d');
                                                                         ?>">
              </div>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="category" class="col-sm-3 col-form-label">Kategoria</label>
            <div class="col-sm-8">
              <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-list"></i></span></div>
                <select name="category" id="category" class="form-control">
                  <?php
                  
                    foreach($categories as $category) {
                      echo "<option>{$category['name']}</option>";
                    }
                  
                  ?>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="comment" class="col-sm-3 col-form-label">Komentarz</label>
            <div class="col-sm-8">
              <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-comment"></i></span></div>
                <textarea class="form-control" id="comment" name="comment"></textarea>
              </div>
            </div>
          </div>

          <button type="submit" class="btn btn-info btn-lg font-weight-bold">Dodaj</button>
          <button type="reset" class="btn btn-danger btn-lg font-weight-bold ml-3">Anuluj</button>
        </form>
      </div>
    </div>
  </main>


  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

  <script src="../js/bootstrap.min.js"></script>

</body>

</html>
