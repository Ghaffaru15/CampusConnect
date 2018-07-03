<?php
  $page_title = 'Sell your product';
  include('Includes/header.html');
  include('Includes/config.inc.php');
  ?>
  <?php

    if (isset($_SESSION['user_id'])){
      $id = $_SESSION['user_id'];
echo '  <div id="sellcontainer">
  <div class="sellcontainer">
      <h1 style="color: blue;">Please provide the details of your product below
         to post your ad!</h1>
      <p id="selldisclaimer"><strong>DISCLAIMER:</strong> Campus Connect\'s ecommerce page is for only
      campus based businesses. Therefore only campus locations
      shall be accepted. </p>
';
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$errors = array();
		if (!empty($_POST['product_name'])){
			$product_name = trim($_POST['product_name']);
		}
		else{
			$error[] = 'You forgot to enter the product name';
		}
		if (!empty($_POST['description']))
			$description = trim($_POST['description']);
		else
			$error[] = ' You forgot to enter the product description';

		if (!empty($_POST['price']))
			$price = trim($_POST['price']);
		else
			$error[] = 'You forgot to enter the product price';

    if (!empty($_POST['contact']))
      $contact = trim($_POST['contact']);
    else {
      $error[] = 'Please enter your contact number';
    }
    if (isset($_POST['category']))
      $category = $_POST['category'];

    if (isset($_POST['university']))
        $university = $_POST['university'];


      if (is_uploaded_file($_FILES['image']['tmp_name'])){
  			$temp = "../Uploads/" . md5($_FILES['image']['name']);
  			 if (move_uploaded_file($_FILES['image']['tmp_name'], $temp)){
  				//echo '<p>File moved</p>';
  				$image = $_FILES['image']['name'];
  				}
  			else{
  				$error[] = 'Failed to move file ';
  				$temp = $_FILES['image']['tmp_name'];
  				}
  		}
  		else{
  			$error[] = 'File not uploaded';
  		}
  		if (empty($error)){
  			require(MySQL);
  			//$query1 = "SELECT * FROM sellers where username= '$username'";


  				$q = "INSERT INTO products(user_id,product_name,category,university,price,description,contact,image_name,date_entered) VALUES (?,?,?,?,?,?,?,?,?)";
  				$date = date("Y-m-d g:i:s");
  			//	$date = NOW();
  				$stmt = mysqli_prepare($db,$q);
  				mysqli_stmt_bind_param($stmt,'isssdssss',$id,$product_name,$category,$university,$price,$description,$contact,$image,$date);
  				mysqli_stmt_execute($stmt);

  					if (mysqli_stmt_affected_rows($stmt) == 1){
  						echo '<p align="center">The product has been added</p>';
  						//Rename image
  						$idd = mysqli_stmt_insert_id($stmt);
  						rename($temp,"../Uploads/"  . $idd);
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
    echo '
      <div class="sellform">
        <form class="" action="" method="post" enctype="multipart/form-data">
          <input type="text" name="product_name" value="" placeholder="Product Name">
          <select class="sellcategory" name="category">
            <option value="">Choose Category</option>
            <option value="Jewellery">Jewellery</option>
            <option value="Electronics">Electronics</option>
            <option value="Fashion">Fashion</option>
            <option value="Stationery">Stationery</option>
            <option value="Food">Food & Drinks</option>
            <option value="Services">Services</option>
          </select>
          <select class="schseldropdown" name="university">
            <option value="">Select School/Campus</option>
            <option value="UG, Legon Campus">UG, Legon Campus</option>
            <option value="UG, City Campus">UG, City Campus</option>
            <option value="KNUST">KNUST</option>
            <option value="UDS, Tamale Campus">UDS, Tamale Campus</option>
            <option value="UDS, Wa Campus">UDS, Wa Campus</option>
            <option value="UDS< Navrongo Campus">UDS, Navrongo Campus</option>
            <option value="UCC">UCC</option>
            <option value="UMAT">UMAT</option>
            <option value="UENR">UENR </option>
            <option value="ATU">ATU</option>
            <option value="KTU, Kumasi">KTU, Kumasi</option>
            <option value="KTU, Koforidua">KTU, Koforidua</option>
            <option value="STU">STU </option>
          </select>
          <input type="number" name="price" value="" placeholder="Price">
          <textarea name="description" rows="8" cols="30" placeholder="Product Description"></textarea>
      <!--    <input type="text" name="" value="" placeholder="Your Location"> -->
          <input type="text" name="contact" value="" placeholder="Contact Number">
          <input type="file" name="image" value="">
          <input type="submit" name="" value="Submit">
        </form>
      </div>
    </div>

</div>';
}
else{
  $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
  header("Location: login.php");
  exit();
}
?>
<?php
  include('Includes/footer.html');
?>
