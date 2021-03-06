<?php

session_start();

require_once 'database.php';

if (!isset($_SESSION['logged_id'])) {
  
  if (isset($_POST['email'])) {

    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');

    $userQuery = $db->prepare('SELECT id, password FROM users WHERE email = :email');
    $userQuery->bindValue(':email', $email, PDO::PARAM_STR);
    $userQuery->execute();

    $user = $userQuery->fetch();

    if ($user && password_verify($password, $user['password'])) {
      $_SESSION['logged_id'] = $user['id'];
      unset($_SESSION['bad_attempt']);
      header("Location: home.php");
      exit();
    } else {
      $_SESSION['bad_attempt'] = true;
      $_SESSION['email'] = $email;
    }
  }
} else {
  header("Location: home.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="pl">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>MyBudget - logowanie</title>
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
      <a href="../index.php" class="navbar-brand mr-auto"><i class="fas fa-search-dollar mr-1"></i> MyBudget</a>
      <a href="#" class="btn btn-dark mr-md-1 my-1 font-weight-bold" role="button">
        <i class="fas fa-sign-in-alt mr-1"></i> Zaloguj się
      </a>
      <a href="register.php" class="btn btn-info my-1 font-weight-bold" role="button"> <i class="fas fa-user-plus mr-1"></i> Zarejestruj się
      </a>
    </nav>
  </header>

  <main class="container my-3">

    <div class="row registration">
      <header class="col-md-8 col-lg-6 mx-auto bg-sea text-center text-uppercase text-light py-2">
        <h1 class="h2 mb-0">Logowanie</h1>
      </header>
      <div class="w-100"></div>
      <div class="col-md-8 col-lg-6 bg-light mx-auto py-3 text-center">
        <form method="post">
          <div class="form-group row justify-content-center">
            <label for="email" class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-8">
              <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                <input type="text" class="form-control" id="email" name="email" value="<?php
                  if (isset($_SESSION['email']))
                  {
                    echo $_SESSION['email'];
                    unset($_SESSION['email']);
                  }
                  ?>">
              </div>

            </div>
          </div>
          <div class="form-group row justify-content-center">
            <label for="password" class="col-sm-3 col-form-label">Hasło</label>
            <div class="col-sm-8">
              <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock"></i></span></div>
                <input type="password" class="form-control" id="password" name="password">
              </div>
            </div>
          </div>
          <?php
            if (isset($_SESSION['bad_attempt'])) {
              echo '<p class="input-err">Niepoprawny login lub hasło</p>';
              unset($_SESSION['bad_attempt']);
            }
          ?>
          <button type="submit" class="btn btn-info btn-lg font-weight-bold">Zaloguj</button>
        </form>
      </div>
      <div class="w-100"></div>
      <aside class="col-md-8 col-lg-6 mx-auto bg-sea text-center text-light py-2">
        <p class="font-weight-bold h5">Nie masz jeszcze konta?</p>
        <a href="register.php" class="btn btn-dark mr-md-1 font-weight-bold" role="button">
          Zarejstruj się
        </a>
      </aside>
    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

  <script src="../js/bootstrap.min.js"></script>

</body>

</html>
