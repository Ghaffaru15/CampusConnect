<?php

	$image = FALSE;
	$name = (!empty($_GET['name'])) ? $_GET['name'] : 'print_image';
	if (isset($_GET['image']) && filter_var($_GET['image'],FILTER_VALIDATE_INT, array('min_range' => 1))){
		$image = 'C:/xampp/Campus/' . $_GET['image'];

		if (!file_exists($image) OR (!is_file($image))){
		$image = FALSE;
		}
	}

	if (!$image){
		$image= 'images/unavailable.png';
		$name = 'unavailable.png';
	}

	$info = getimagesize($image);
	$fs = filesize($image);

	//send content info
	header("Content-Type: " . $info['mime'] ."\n");
	header("Content-Disposition: inline; filename=" . $name.  "\n");
	header("Content-Length: " . $fs .  "\n");

	//Send file
	readfile($image);
?>
