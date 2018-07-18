<?php

	$image = FALSE;
	$name = (!empty($_GET['name'])) ? $_GET['name'] : 'print_image';
	if (isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT, array('min_range' => 1))){
		$image = '../Uploads/' . $_GET['id']. '/' . $name;

		if (!file_exists($image) OR (!is_file($image))){
		$image = FALSE;
		}
	}

	if (!$image){
		$image= 'Images/unavailable.png';
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
