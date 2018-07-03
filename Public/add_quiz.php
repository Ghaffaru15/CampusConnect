<?php
	session_start();
	
	if (isset($_SESSION['qm_id']) && isset($_SESSION['first_name'])){
		$id = $_SESSION['qm_id'];
		echo 'Logged in as ' . $_SESSION['first_name'];
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$errors = array();
		if (!empty($_POST['program'])){
			$program = trim($_POST['program']);
		}
		else{
			$error[] = 'You forgot to enter the Program';
		}
		if (!empty($_POST['course_name']))
			$course_name = trim($_POST['course_name']);
		else
			$error[] = ' You forgot to enter the product course name';

		
			
		if (is_uploaded_file($_FILES['file']['tmp_name'])){
			$temp = "C:/xampp/Quiz_files/" . md5($_FILES['file']['name']);
			 if (move_uploaded_file($_FILES['file']['tmp_name'], $temp)){
				//echo '<p>File moved</p>';
				$file = $_FILES['file']['name'];
				}
			else{
				$error[] = 'Failed to move file ';
				$temp = $_FILES['file']['tmp_name'];
				}
		}
		else{
			$error[] = 'File not uploaded';
		}
		if (empty($error)){
			require('C:\xampp\mysql_connect.php');
			//$query1 = "SELECT * FROM sellers where username= '$username'";

		
				$q = "INSERT INTO quiz(qm_id,program,course_name,file_name,date_entered) VALUES (?,?,?,?,?)";
				$date = date("Y-m-d g:i:s");
			//	$date = NOW();
				$stmt = mysqli_prepare($db,$q);
				mysqli_stmt_bind_param($stmt,'issss',$id,$program,$course_name,$file,$date);
				mysqli_stmt_execute($stmt);
				
					if (mysqli_stmt_affected_rows($stmt) == 1){
						echo '<p>The product has been added</p>';
						//Rename image
						$idd = mysqli_stmt_insert_id($stmt);
						rename($temp,"C:/xampp/Quiz_files/"  . $idd);
						$_POST = array();
					}
					else{
						echo '<p>Your submission could not be processed</p>';
					}
					mysqli_stmt_close($stmt);
			
			if (isset($temp) && file_exists($temp) && is_file($temp)){
					unlink($temp);
			 }
		}
		else{
			echo '<h4>Errors</h4>	
			<p> The following errors occured:<br />';
			foreach ($error as $msg ) {
				# code...
				echo $msg  .'<br />';
			}
		}
		}
		echo '<h3 align="center"> Fill to add a quiz pack </h3>';
		
		echo '<form action="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="MAX_FILE_SIZE" value="524288"/>
		<table align="center">
	<tr>
		<td>University Program</td>
		<td><input type="text" name="program" /></td>
	</tr>
	<tr>
		<td>Course name</td>
		<td><input type="text" name="course_name" /></td>
	</tr>
	
	<tr>
		<td>Upload file </td>
		<td><input type="file" name="file" /></td>
	</tr>
	<tr>
<td>	<input type="submit" name="submit" value="Submit" /></td>
</tr>
</table>

</form>';
echo '<a href="signout.php">Logout</a>';
	}
	
	else{
	echo '<p> Access Denied </p>';
	}
	
?>