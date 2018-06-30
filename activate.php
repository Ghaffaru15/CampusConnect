<?php
	include('Includes/config.inc.php');
	$page_title = 'Activate Account';

	include('Includes/header.html');

	if (isset($_GET['x'], $_GET['y']) && filter_var($_GET['x'], FILTER_VALIDATE_EMAIL) && (strlen($_GET['y'] ) == 32)){
		require(MySQL);
		//$trimmed = array_map('trim',$_GET);
		$email = mysqli_real_escape_string($db,$_GET['x']);
		$activation = mysqli_real_escape_string($db,$_GET['y']);

		$query  = "UPDATE users SET active=NULL WHERE email='$email' AND active='$activation' LIMIT 1";

		$result = mysqli_query($db,$query);

		if (mysqli_affected_rows($db) == 1){
			echo '<h3>Your account is now active, you can now   <a href="login.php" class="form-log-in-with-existing">Login here &rarr;</a></h3>';
		}
		else{
			echo '<p class="error"> Your account could not be activated, please re-check the link or contact your system admin </p>';
		}
	}
	else{
		//redirect user
		$url = BASE_URL . 'index.php';

		header("Location: $url");
	}

	include('Includes/footer.html');
?>
