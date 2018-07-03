<?php
    $page_title = 'Sign up';
    include('Includes/header.html');
    include('Includes/config.inc.php');

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		require(MySQL);
		$trimmed = array_map('trim', $_POST);
		$fn = $ln = $e = $p = $check = FALSE;

		if (preg_match('/^[A-Z \'.-]{2,20}$/i',$trimmed['first_name'])){
			$fn = mysqli_real_escape_string($db,$trimmed['first_name']);
		}
		else{
			echo '<p class="error"> Please provide your first name </p>';
		}

		if (preg_match('/^[A-Z \.-]{2,40}$/i',$trimmed['last_name'])){
			$ln = mysqli_real_escape_string($db,$trimmed['last_name']);
		}
		else{
			echo '<p class="error"> Please provide your last name </p>';
		}

		if (filter_var($trimmed['email'], FILTER_VALIDATE_EMAIL)){
			$e = mysqli_real_escape_string($db, $trimmed['email']);
		}
		else{
			echo '<p class="error"> Please provide your email </p>';
		}
		if (preg_match('/^\w{4,20}$/',$trimmed['password1']) && strlen($trimmed['password1']) >= 8 ){
			if ($trimmed['password1'] == $trimmed['password2']){
				$p = mysqli_real_escape_string($db,$trimmed['password1']);

				$password_length = 1;
			}

			else{
				echo '<p class="error"> The password entered does not match </p>';
			}
		}
		else{
			echo '<p class="error"> Please check your password </p>';
		}
/*		if (isset($_POST['checkbox'])){
			$check = 1;
		}
		else{
			$check = 0;
			echo '<p class="error"> Please agree to our terms and conditions </p>';
		}
*/
		if ($fn && $ln && $e && $p  && $password_length){
			//Checking for valid email address
			$query = "SELECT user_id FROM users where email='$e'";

			$result = mysqli_query($db, $query) ;

			if (mysqli_num_rows($result) == 0){
				//Generate activation code
				$activation = md5(uniqid(rand(),true));
				$q = "INSERT into users(first_name,last_name,email,pass,active,date_registered) VALUES ('$fn', '$ln','$e', sha1('$p'), '$activation', NOW())";

				$r = mysqli_query($db,$q) ;

				if (mysqli_affected_rows($db) == 1){
					$body = "Thank you for registering at Campus Connect, To activate your account, please click <br />";
					$link = BASE_URL . 'activate.php?x='. urlencode($e) . "&y=$activation";
					//mail($trimmed['email'], 'Registeration Confirmation', $link ,'From: admin@gmail.com');

					echo $body . '<a href="' . $link . '"> here </a>';

				}
				else{
					echo '<p class="error">You could not be registered due to system error. We apologize for any inconvenience </p>';
				}
			}
			else{
				echo '<p class="error">That email is already registered with us, please login rather </p>';
			}
		}
		else{
			echo '<p class="error"> Please try again </p>';
		}
		mysqli_close($db);
	}

?>
<?php
  if (isset($_SESSION['user_id'])){
    $url = BASE_URL . 'index.php';
      header("Location: $url");
  }
  else{
    echo '
    <div id="signup_container">
    <div class="logincont">
    <form class="login" action="" method="post">
        <input type="text" name="first_name" value="" placeholder="First Name"><br>
        <input type="text" name="last_name" value="" placeholder="Surname">
        <input type="text" name="email" value="" placeholder="Email Address">

        <input type="password" name="password1" value="" placeholder="Password">';
                                ?>
                 <?php
                   if (isset($_POST['password1'])){
                     if (strlen($_POST['password1']) < 8){
                       echo '<p> You password should be more than 8 characters</p>';
                       //$error[] = ' ';
                     }
                     else{
                       //$password_length = 1;
                     }
                   }
                 ?>
                 <?php echo '
                <input type="password" name="password2" value="" placeholder="Repeat password">

                         <input type="submit" name="" value="Create My Account!"> <br />
                        <a href="login.php" class="form-log-in-with-existing">Already have an account? Login here &rarr;</a>
                    </div>



        </div>
    </form>
    </div>';
  }
?>

<?php
  include('Includes/footer.html');
?>
