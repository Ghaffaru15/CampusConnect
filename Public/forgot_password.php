<?php
    $page_title = 'Login';
    include('Includes/header.html');
    include('Includes/config.inc.php');
    require(MySQL);
?>
<?php

    if (!isset($_SESSION['user_id'])){ //If not already loggedin

      echo
          '
          <section class="row login-container">
              <h2>Reset Password</h2>
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
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (!empty($_POST['email'])){
          require(MySQL);
          $email = mysqli_real_escape_string($db, $_POST['email']);
          $q = "SELECT user_id,first_name FROM users WHERE email='$email'";

          $r = mysqli_query($db, $q);

          if (mysqli_num_rows($r) == 1){
              while ($row= mysqli_fetch_assoc($r)){
                  $user_id  = $row['user_id'];
              }
          }
          else{
              echo '<p style="font-size: 0.8em; color:#e67e22;"> The email is not registered </p>';
            }
          }
          else{
              echo '<p style="font-size: 0.8em; color: #e67e22;"> You forgot to enter your email </p>';
            }

      if ($user_id){
          $password = substr(md5(uniqid(rand(), true)), 3, 10);

          $query = "UPDATE users SET pass=sha1('$password') WHERE user_id=$user_id LIMIT 1";

          $result = mysqli_query($db,$query);

            if (mysqli_affected_rows($db) == 1 ){
                echo '<p style="font-size: 0.8em; color:#e67e22;">Your password has been reset to <b>' . $password . '</b>, Login with this password, and change it later.</p>';
            }


      }
      else{
          echo '<p> Error retrieving data </p>';
      }
    }
  ?>
                  <?php echo '
                  </div>
              </div>
              <input type="submit" name="" value="Reset" id="submit-button">
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
