<?php

session_start();

if (isset($_POST['email'])) {
  
  $validation_OK = true;
  
  $name = $_POST['name'];
  if (strlen($name)<3 || strlen($name) > 20) {
    $validation_OK=false;
    $_SESSION['e_name']="Nazwa musi posiadać od 3 do 20 znaków!";
  }
  
  if (ctype_alnum($name)==false) {
    $validation_OK=false;
    $_SESSION['e_name']="Nazwa może składać się tylko z liter i cyfr (bez polskich znaków)";
  }
  
  $email = $_POST['email'];
  $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
    
  if((filter_var($emailB,FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email)) {
    $validation_OK=false;
    $_SESSION['e_email']="Podaj poprawny adres e-mail";
  }
  
  $password = $_POST['password'];

  if ((strlen($password)<8)||(strlen($password)>20))
  {
    $validation_OK = false;
    $_SESSION['e_password'] = "Hasło musi posiadać od 8 do 20 znaków";
  }

  $password_hash = password_hash($password, PASSWORD_DEFAULT);
  
  $_SESSION['fr_name'] = $name;
  $_SESSION['fr_email'] = $email;
  $_SESSION['fr_password'] = $password;
  
  require_once 'database.php';
  
  $emailQuery = $db->prepare('SELECT email FROM users WHERE email = :email');
  $emailQuery->bindValue(':email', $email, PDO::PARAM_STR);
  $emailQuery->execute();

  if($emailQuery->rowCount()){
    $validation_OK=false;
    $_SESSION['e_email'] = "Istnieje już konto przypisane do tego adresu e-mail";
  }
  
  if ($validation_OK) {
    $query = $db->prepare('INSERT INTO users VALUES (NULL, :username, :password, :email)');
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->bindValue(':username', $name, PDO::PARAM_STR);
    $query->bindValue(':password', $password_hash, PDO::PARAM_STR);
    $query->execute();
    
    $userIdQuery = $db->query("SELECT id FROM users WHERE email='$email'");
    $userID = $userIdQuery->fetchAll();
    
    $newUserID = $userID[0][0];
    
    $expensesCategoryQuery = $db->query("SELECT name FROM expenses_category_default");
    $expensesCategories = $expensesCategoryQuery->fetchAll();

    foreach ($expensesCategories as $expCategory){
      $query = $db->prepare("INSERT INTO expenses_category_assigned_to_users VALUES (NULL, '$newUserID', :category)");
      $query->bindValue(':category', $expCategory['name'], PDO::PARAM_STR);
      $query->execute();
    }

    $incomesCategoryQuery = $db->query("SELECT name FROM incomes_category_default");
    $incomesCategories = $incomesCategoryQuery->fetchAll();

    foreach ($incomesCategories as $incCategory){
      $query = $db->prepare("INSERT INTO incomes_category_assigned_to_users VALUES (NULL, '$newUserID', :category)");
      $query->bindValue(':category', $incCategory['name'], PDO::PARAM_STR);
      $query->execute();
    }

    $paymentMethodsQuery = $db->query("SELECT name FROM payment_methods_default");
    $paymentMethods = $paymentMethodsQuery->fetchAll();

    foreach ($paymentMethods as $payMethod){
      $query = $db->prepare("INSERT INTO payment_methods_assigned_to_users VALUES (NULL, '$newUserID', :method)");
      $query->bindValue(':method', $payMethod['name'], PDO::PARAM_STR);
      $query->execute();
    }
    
    $_SESSION['registersucceed']=true;
    header('Location: registercompleted.php');
    
  }
}

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
      <a href="#" class="btn btn-info my-1 font-weight-bold" role="button"> <i class="fas fa-user-plus mr-1"></i> Zarejestruj się
      </a>
    </nav>
  </header>

  <main class="container my-3">

    <div class="row registration">
      <header class="col-md-8 col-lg-6 mx-auto bg-sea text-center text-uppercase text-light py-2">
        <h1 class="h2 mb-0">Rejestracja</h1>
      </header>
      <div class="w-100"></div>
      <div class="col-md-8 col-lg-6 bg-light mx-auto py-3 text-center">
        <form method="post">
          <div class="form-group row justify-content-center">
            <label for="name" class="col-sm-3 col-form-label">Nazwa</label>
            <div class="col-sm-8">
              <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                <input type="text" class="form-control" id="name" name="name" value="<?php
                if (isset($_SESSION['fr_name'])) {
                  echo $_SESSION['fr_name'];
                  unset($_SESSION['fr_name']);
                }
                ?>">
              </div>
              <?php
              if (isset($_SESSION['e_name'])) {
                echo '<div class="input-err">'.$_SESSION['e_name'].'</div>';
                unset($_SESSION['e_name']);
              }
              ?>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="email" class="col-sm-3 col-form-label">E-mail</label>
            <div class="col-sm-8">
              <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope-square"></i></span></div>
                <input type="email" class="form-control" id="email" name="email" value="<?php
                if (isset($_SESSION['fr_email'])) {
                  echo $_SESSION['fr_email'];
                  unset($_SESSION['fr_email']);
                }
                ?>">
              </div>
              <?php
                if (isset($_SESSION['e_email'])) {
                  echo '<div class="input-err">'.$_SESSION['e_email'].'</div>';
                  unset($_SESSION['e_email']);
                }
              ?>
            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="password" class="col-sm-3 col-form-label">Hasło</label>
            <div class="col-sm-8">
              <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock"></i></span></div>
                <input type="password" class="form-control" id="password" name="password" value="<?php
                if (isset($_SESSION['fr_password'])) {
                  echo $_SESSION['fr_password'];
                  unset($_SESSION['fr_password']);
                }
                ?>">
              </div>
              <?php
                if (isset($_SESSION['e_password'])) {
                  echo '<div class="input-err">'.$_SESSION['e_password'].'</div>';
                  unset($_SESSION['e_password']);
                }
              ?>
            </div>
          </div>
          <button type="submit" class="btn btn-info btn-lg font-weight-bold">Zarejestruj</button>
        </form>
      </div>
      <div class="w-100"></div>
      <aside class="col-md-8 col-lg-6 mx-auto bg-sea text-center text-light py-2">
        <p class="font-weight-bold h5">Masz już konto?</p>
        <a href="login.html" class="btn btn-dark mr-md-1 font-weight-bold" role="button">
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
