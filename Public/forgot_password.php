<?php
	include('Includes/config.inc.php');

	$page_title = 'Password reset';

	include('Includes/header.html');

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
				echo '<p class="error"> The email is not registered </p>';
			}
		}
		else{
			echo '<p class="error"> You forgot to enter your email </p>';
		}

		if ($user_id){
			$password = substr(md5(uniqid(rand(), true)), 3, 10);

			$query = "UPDATE users SET pass=sha1('$password') WHERE user_id=$user_id LIMIT 1";

			$result = mysqli_query($db,$query);

			if (mysqli_affected_rows($db) == 1 ){
				echo '<p>Your password has been reset to ' . $password . ', Login with this password, and change it later.</p>';
			}


		}
		else{
			echo '<p> Error retrieving data </p>';
		}
	}
?>

<div id="login_container">
  <div class="logincont">
       <p>Reset Password</p>
       <form class="login" action="" method="post">
         <input type="text" name="email" value="" placeholder="Email"><br>
    <!--     <input type="password" name="password" value="" placeholder="Password"> -->
         <input type="submit" name="" value="Reset">
       </form>

          <!--         <a href="reset_password.php" class="form-forgotten-password">Forgotten password &middot;</a>
                   <a href="register.php" class="form-create-an-account">Create an account &rarr;</a>
-->               </div>

</div>

<?php
	include('Includes/footer.html');
?>
