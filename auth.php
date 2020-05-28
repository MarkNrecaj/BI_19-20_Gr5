<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Document</title>
  <link rel="stylesheet" href="style/auth.css" />
</head>

<body>
  <script src="script/auth.js"></script>
  <?php
  include 'header.php';
  function login()
  {
    try {
    
    $email = $GLOBALS['email'];
    $conn = $GLOBALS['conn'];
    $password = $GLOBALS['password'];

    $sql = "SELECT * FROM users WHERE email ='$email'";
    $retval = mysqli_query($conn, $sql);
    if (mysqli_num_rows($retval) > 0) {
      $user_arr = [];
      while ($row = mysqli_fetch_assoc($retval)) {
        $user_arr[] = $row;
      }

      // var_dump($user_arr[0]);
      $password_db = $user_arr[0]['password'];
      if ($password_db == $password) {
        $_SESSION['id'] = $user_arr[0]['id'];
        $_SESSION['start'] = time();
        $_SESSION['expire'] = $_SESSION['start']  + 3600;
        setcookie("is_login", true, time() + 3600);

        echo "<script> logginSuccess();</script>";
      } else {
        echo "<script> incorrect_email_password();</script>";
        return;
      }
    } else {
      echo "<script> incorrect_email_password();</script>";
      return;
    }
    if (!$retval) {
      die("Nuk mund te shtohen te dhenat " . mysqli_connect_error());
    }
      
  } catch (\Throwable $th) {
    var_dump($th);
  }
  }

  function signup()
  {
    try {
      
    
    $conn = $GLOBALS['conn'];

    $email = $GLOBALS['email'];
    $password = $GLOBALS['password'];
    $name = $GLOBALS['name'];

    preg_match("/\+(.*)@/", $email, $match);
    $split = preg_split("/\+(.*)@/", $email);
    if (count($match) > 0 || count($split) > 0) {
      $email = preg_replace("/\+(.*)@/", "@", $email);
    }
    $sql = "SELECT * FROM users WHERE email ='$email'";

    $retval = mysqli_query($conn, $sql);
    if (mysqli_num_rows($retval) > 0) {
      echo "<script> user_exist();checkSignup(); </script>";

      return 'This users alredy exist';
    } else {

      $sql = "INSERT INTO users(fullname,email,password)
  VALUES ('$name' ,'$email','$password');";

      $retval = mysqli_query($conn, $sql);
      if (!$retval) {
        die("Nuk mund te shtohen te dhenat " . mysqli_connect_error());
      } else {
        echo "<script> signupSuccess();  checkLogin(); </script>";
      }
    }

    if (!$retval) {
      die("Nuk mund te shtohen te dhenat " . mysqli_connect_error());
    }
  } catch (\Throwable $th) {
    var_dump($th);
  }
  }
  if (isset($_POST['signup']) || isset($_POST['login_user'])) {
    $dbhost = 'localhost:3306';
    $dbuser = 'root';
    $dbpassword = '';
    $dbname = 'booking';

    $conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);

    if (!$conn) {
      die("Nuk mund te lidhet me db " . mysqli_connect_error());
    } else {
      $email = trim($_POST['email']);
      $password = trim($_POST['password']);
    }
    if (isset($_POST['signup'])) {
      $name = trim($_POST['fullname']);
      signup();
    } else if (isset($_POST['login_user'])) {
      login();
    }
    mysqli_close($conn);
  }
  ?>

  <!-- Login -->

  <section class="section-login">
    <div class="container">
      <div class="row">
        <div class="login">
          <div class="login__form">
            <form method="post" action="<?php $_PHP_SELF ?>">
              <div class="u-margin-bottom-small">
                <h2 class="heading-secondary">
                  Your informations
                </h2>
              </div>
              <div id="fullname" class="form__group">
                <input type="text" class="form__input" placeholder="Full name" id="fullname" name="fullname" />
                <label for="fullname" class="form__label">Full name</label>
              </div>
              <div class="form__group">
                <input type="email" class="form__input" placeholder="Email address" id="email" name="email" required />
                <label id="em1" for="email" class="form__label">Email address</label>
              </div>

              <div class="form__group">
                <input type="password" class="form__input" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}" placeholder="Password" id="password" name="password" required />
                <label id="pas1" for="password" class="form__label">Password</label>
              </div>

              <span id="incorrect" name="incorrect"></span>

              <div class="form__group u-margin-bottom-medium">
                <div class="form__radio-group">
                  <input onclick="checkSignup()" type="radio" class="form__radio-input" id="large" name="size" checked />
                  <label for="large" class="form__radio-label">
                    <span class="form__radio-button"></span>
                    Sign up
                  </label>
                </div>
                <div class="form__radio-group">
                  <input onclick="checkLogin()" type="radio" class="form__radio-input" id="small" name="size" />
                  <label for="small" class="form__radio-label">
                    <span class="form__radio-button"></span>
                    Login
                  </label>
                </div>
              </div>

              <div class="form__group">
                <button type="submit" name="signup" id="logsign" onclick="checkWhich()" class="btn btn--green">
                  Continue &rarr;
                </button>

                <!-- <input name="signup" type="submit" value=" Signuup" id="signup" class="update_button" /> -->
                <!-- notice added name="" -->
                <!-- <input name="login_user" type="submit" value=" Login" id="login_user" class="update_button" /> notice added name="" -->

              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- footer -->
  <?php include 'footer.php'; ?>
  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
</body>

</html>