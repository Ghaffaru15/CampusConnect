<?php
  $page_title = 'Login';
  include('Includes/header.html');
  include('Includes/config.inc.php');

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		require(MySQL);

		$trimmed = array_map('trim',$_POST);

		$email = mysqli_real_escape_string($db,$trimmed['email']);

		$password = mysqli_real_escape_string($db,$trimmed['password']);

		$q = "SELECT user_id, first_name FROM users WHERE email='$email' AND pass=sha1('$password') AND active IS NULL";

		$r = mysqli_query($db,$q);

		if (mysqli_num_rows($r) == 1){
			$row = mysqli_fetch_assoc($r);
    //  session_start();
			$_SESSION['user_id'] = $row['user_id'];
			$_SESSION['first_name'] = $row['first_name'];
			//$_SESSION['user_level'] = $row['user_level'];
			$_SESSION['time_login'] = date('F j, Y  H:i');
			$time_login = $_SESSION['time_login'];
			//$q = "UPDATE users SET last_login=" . $time_login . "WHERE user_id=" . $row['user_id']  ."AND last_login IS NULL";

			$r = mysqli_query($db,$q);

			if (mysqli_affected_rows($db) == 1){
          if (isset($_SESSION['redirect_to'])){

          $redirect = $_SESSION['redirect_to'];
          unset($_SESSION['redirect_to']);
          header("Location: sell.php");
          exit();
        }
        else{
					$url = BASE_URL  . 'index.php';

			header("Location: $url");
    }
  }

		}
		else{
			echo '<p class="error"> Email and password does not match, or Account not activated </p>';
		}
		mysqli_close($db);
	}
?>
<div id="login_container">
  <div class="logincont">
       <p>Login here!</p>
       <form class="login" action="" method="post">
         <input type="text" name="email" value="" placeholder="Email"><br>
         <input type="password" name="password" value="" placeholder="Password">
         <input type="submit" name="" value="Login!">
       </form>

                   <a href="forgot_password.php" class="form-forgotten-password">Forgotten password &middot;</a>
                   <a href="register.php" class="form-create-an-account">Create an account &rarr;</a>
               </div>

</div>

<?php
  include('Includes/footer.html');
?>
