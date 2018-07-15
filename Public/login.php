<?php
    $page_title = 'Login';
    include('Includes/header.html');
    include('Includes/config.inc.php');
    require(MySQL);
?>
<?php
    if (isset($_GET['signup'])){
        echo '<h3 align="center">You are now registered, </h3>';
    }
    if (!isset($_SESSION['user_id'])){ //If not already loggedin

      echo
          '
          <section class="row login-container">
              <h2>LOGIN!</h2>
              <form method="post" action="#" class="sign-up-form">
                  <div class="row">
                      <div class="col span-1-of-3">
                          <label for="email"><span>E</span>mail:</label>
                      </div>
                      <div class="col span-2-of-3">
                          <input type="text" name="email" id="firstname">
          ';
  ?>
  <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST'){
              if (empty($_POST['email'])){
                              echo '<p style="color: #e67e22; font-size: 0.8em;">The email field is required!</p>';
                        }

                }
  ?>
  <?php
              echo '
              </div>
          </div>

          <div class="row">
              <div class="col span-1-of-3">
                  <label for="pass-word"><span>P</span>assword:</label>
              </div>
              <div class="col span-2-of-3">
                  <input type="password" name="password" id="password">
                    ';
  ?>
  <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                          if (empty($_POST['password'])){
                                echo '<p style="color: #e67e22; font-size: 0.8em;">The password field is required!</p>';
                          }

                  }
  ?>
  <?php
              if ($_SERVER['REQUEST_METHOD'] == 'POST'){

                    if (!empty($_POST['email']) AND !empty($_POST['password'])){

                        $email = strip_tags(trim($_POST['email']));
                        $pass = strip_tags(trim($_POST['password']));

                        $email = mysqli_real_escape_string($db,$email);
                        $pass = mysqli_real_escape_string($db,$pass);

                        $q = "SELECT user_id, first_name FROM users WHERE email='$email' AND pass=sha1('$pass')";

                        $r = mysqli_query($db,$q);

                            if (mysqli_num_rows($r) == 1){
                                $row = mysqli_fetch_assoc($r);

                                $_SESSION['user_id'] = $row['user_id'];
                                $_SESSION['first_name'] = $row['first_name'];

                                $_SESSION['time_login'] = date('F j, Y  H:i');
                                $time_login = $_SESSION['time_login'];

                                  if (isset($_SESSION['redirect_to'])){

                                    $redirect = $_SESSION['redirect_to'];
                                    unset($_SESSION['redirect_to']);
                                    header("Location: sell_product.php");
                                  exit();
                                }
                                else{
                                  $url = BASE_URL  . 'index.php';

                                  header("Location: $url");
                        }
                    }
                    else{
                        echo '<p style="color: #e67e22; font-size: 0.8em;">The email and password does not match!</p>';
                    }
                  }
                }

                  ?>
                  <?php echo '
                  </div>
              </div>
              <input type="submit" name="" value="Login" id="submit-button">

              <div class="row forgot-password">
              <span><a href="forgot_password.php">Forgot Password?</a></span>
          </div>
          </form>
      </section>
';
}
else{
    $url = BASE_URL . 'index.php';
    header("Location: $url");
}

?>
<?php
    include('Includes/footer.html');
?>
