<?php

	include('Includes/config.inc.php')
	;
	$page_title = 'Change Password';

	include('Includes/header.html');
	if (isset($_SESSION['user_id'])){
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		if (isset($_SESSION['user_id'])){
			$user_id = $_SESSION['user_id'];
		}
		if (!empty($_POST['current_password']) && (!empty($_POST['password']))){
			require(MySQL);

			$current_password = mysqli_real_escape_string($db, trim($_POST['current_password']));

			$new_password = mysqli_real_escape_string($db, trim($_POST['password']));

			$confirm_password = mysqli_real_escape_string($db, trim($_POST['confirm_password']));

			$query = "SELECT pass FROM users WHERE user_id=$user_id";

			$result = mysqli_query($db,$query);

			if (mysqli_num_rows($result) == 1 ){
				$row = mysqli_fetch_assoc($result);
				if ((sha1($current_password) == $row['pass']) && ($new_password == $confirm_password)){
					$q = "UPDATE users SET pass=sha1('$new_password') WHERE user_id=$user_id";

					$r = mysqli_query($db, $q);

					if (mysqli_affected_rows($db) == 1)
						echo '<p> You password was changed successfully</p>';
					else
						echo '<p> Could not change password, please try again </p>';
				}
				else{
					echo '<p> Either a wrong current password, or new password mismatch, please try again</p>';
				}
			}
			else{
				echo'<p> Could perform the query</p>';
			}
		}
		else{
			echo '<p> The field should not be empty</p>';
		}
	}
	echo '
  <div id="login_container">
    <div class="logincont">
         <p>Change Password</p>
         <form class="login" action="" method="post">
           <input type="password" name="current_password" value="" placeholder="Current Password"><br>
           <input type="password" name="password" value="" placeholder="Password"><br>
           <input type="password" name="confirm_password" placeholder="Confirm Password">
           <input type="submit" name="" value="Update">
         </form>


          </div>

  </div>

 ';


	include('Includes/footer.html');
	}
	else{
		header("Location: index.php");
	}
