<?php
	include('Includes/config.inc.php');

	$page_title = 'Logout';

	include('Includes/header.html');
	if (isset($_SESSION['user_id']) || isset($_SESSION['first_name'])){
		$_SESSION = array();

		session_destroy();
		setcookie(session_name(),'', time()-3600);
		$url = BASE_URL . 'index.php';
		header("Location: $url");
		//echo '<h4>You are now logged out! </h4>';
	}
	else{
		$url = BASE_URL . 'index.php';

		header("Location: $url");
		exit();
	}



	include("Includes/footer.html");
?>
