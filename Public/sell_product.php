<?php
    $page_title = 'Sell Your Product';
    include('Includes/header.html');
    include('Includes/config.inc.php');
    require(MySQL);
?>
<?php
      if (isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
          echo '<section class="row product-sell-container">
              <h2>Follow the steps below to Post your Product!</h2>
              <div class="row product-steps">
                  <form class="product-sell-form" action="" method="post" enctype="multipart/form-data">
                      <div class="row main-details">
                          <div class="row step">
                          <div class="col span-1-of-3">
                              <label for="product-name">Product Name</label>
                          </div>
                          <div class="col span 2-of-3">
                              <input type="text" name="product_name" id="product-name">';

?>
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (empty($_POST['product_name'])){
            echo '<p style="font-size: 0.8em; color: #e67e22;">The product name is required!</p>';
        }
        else{
            $product_name = strip_tags(trim($_POST['product_name']));
            $product_name = mysqli_real_escape_string($db,$product_name);
        }
    }
?>
<?php
      echo '
                        </div>
                    </div>
                     <div class="row step">
                        <div class="col span-1-of-3">
                            <label for="choosecategory">Choose Category</label>
                        </div>
                        <div class="col span 2-of-3">
                            <select name="category">
                                <option value="">Choose Category</option>
                                <option value="Jewellery">Jewellery</option>
                                <option value="Electronics">Electronics</option>
                                <option value="Fashion">Fashion</option>
                                <option value="Stationery">Stationery</option>
                                <option value="Food">Food & Drinks</option>
                                <option value="Services">Services</option>
                            </select>';
?>
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if ($_POST['category'] == NULL){
            echo '<p style="font-size: 0.8em; color:#e67e22;">Please select a category</p>';
        }
        else{
            $category = $_POST['category'];
        }
}
?>
<?php
    echo '</div>
</div>
<div class="row step">
    <div class="col span-1-of-3">
        <label for="choosecampus">Choose School/Campus</label>
    </div>
    <div class="col span 2-of-3">
        <select name="campus">
            <option value="">Select School/Campus</option>
            <option value="UG, Legon Campus">UG, Legon Campus</option>
            <option value="UG, City Campus">UG, City Campus</option>
            <option value="KNUST">KNUST</option>
            <option value="UDS, Tamale Campus">UDS, Tamale Campus</option>
            <option value="UDS, Wa Campus">UDS, Wa  Campus</option>
            <option value="UDS, Navrongo Campus">UDS, Navrongo Campus</option>
            <option value="UCC">UCC</option>
            <option value="UEW">UEW</option>
            <option value="UPS">UPS</option>
            <option value="UMAT">UMAT</option>
            <option value="GIMPA">GIMPA</option>
            <option value="UENR">UENR</option>
            <option value="UHAS">UHAS</option>
        </select>';
?>
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if ($_POST['campus'] == NULL){
            echo '<p style="font-size: 0.8em; color:#e67e22;">Please select your campus</p>';
        }
        else{
            $campus = $_POST['campus'];
        }
    }
?>
<?php
    echo '  </div>
  </div>
  <div class="row step">
      <div class="col span-1-of-3">
          <label for="price">Price(GHC)</label>
      </div>
      <div class="col span 2-of-3">
          <input type="number" name="price" id="price">';
?>
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (empty($_POST['price'])){
            echo '<p style="font-size: 0.8em; color:#e67e22;">Please give a price</p>';
        }
        elseif(ctype_alpha($_POST['price'])){
            echo '<p style="font-size: 0.8em; color: #e67e22;">Invalid input</p>';
        }
        else{
            $price = strip_tags(trim($_POST['price']));
            $price = mysqli_real_escape_string($db,$price);
        }
    }
?>
<?php
    echo '
        </div>
   </div>
   <div class="row step">
        <div class="col span-1-of-3">
            <label for="location">Your Location</label>
        </div>
        <div class="col span 2-of-3">
            <input type="text" name="location" id="location">';
?>
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (empty($_POST['location'])){
            echo '<p style="font-size: 0.8em; color:#e67e22;">Please give a location</p>';
        }
        elseif (is_numeric($_POST['location'])){
            echo '<p style="font-size: 0.8em; color: #e67e22;">Invalid input</p>';
        }
        else{
            $location = strip_tags(trim($_POST['location']));
            $location = mysqli_real_escape_string($db,$location);
        }
    }
?>
<?php
  echo '</div>
  </div>
<div class="row step">
  <div class="col span-1-of-3">
      <label for="contact-number">Contact Number</label>
  </div>
  <div class="col span 2-of-3">
      <input type="text" name="contact" id="contact-number">';
?>   <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST'){
          if (empty($_POST['contact'])){
              echo '<p style="font-size: 0.8em; color:#e67e22;">Please provide your contact</p>';
          }
          elseif (ctype_alpha($_POST['contact'])){
              echo '<p style="font-size: 0.8em; color: #e67e22;">Invalid input</p>';
          }
          else{
              $contact = strip_tags(trim($_POST['contact']));
              $contact = mysqli_real_escape_string($db,$contact);
          }
      }
 ?>
  <?php
      echo '
      </div>
  </div>
</div>

  <div class="row product-description step">
      <div class="col span-1-of-3">
          <label for="product-description">Product Description</label>
      </div>
      <div class="col span 2-of-3">
          <textarea name="description">

          </textarea>';
  ?>

  <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST'){
          if (empty($_POST['description'])){
              echo '<p style="font-size: 0.8em; color: #e67e22;">Please give a description</p>';
          }
          else{
              $description = strip_tags(trim($_POST['description']));
              $description = mysqli_real_escape_string($db,$description);
          }
      }
  ?>

          <?php
              echo '    </div>
                        </div>
                        <div class="row img-upload-container">
                            <h2>Add Image(s) Below</h2>
                            <div class="row">
                            <div class="col span-1-of-2 img-upload">
                               <label for="img-1"><i class="fas fa-upload"></i><span id="file-text">Upload Main Image</span></label>
                               <input type="file" name="image_one" id="img-1" accept=".jpg,.png,.jpeg"';
                ?>
                <?php
                  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                        if (is_uploaded_file($_FILES['image_one']['tmp_name'])){
                          $fileinfo = finfo_open(FILEINFO_MIME_TYPE); //Resource
                          $mimetype = finfo_file($fileinfo, $_FILES['image_one']['tmp_name']);

                          if (substr($mimetype, 0 , 5) != 'image'){
                                echo '<p style="font-size: 0.8em; color: #e67e22;">Please upload the right format</p>';
                          }
                          else{
                              $image_one = $_FILES['image_one']['name'];
                              $image_one_tmp = $_FILES['image_one']['tmp_name'];
                        }

                      }else{
                          echo '<p style="font-size: 0.8em; color: #e67e22;">Please upload at least one picture</p>';
                      }
                }
                ?>
                <?php
                      echo '</div>
                       <div class="col span-1-of-2 img-upload img-upload-2" id="img-upload-2">
                         <label for="img-2"><i class="fas fa-upload"></i><span id="file-text-2">Click here to add Image</span></label>
                         <input type="file" name="image_two" id="img-2">';
                ?>
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                      if (is_uploaded_file($_FILES['image_two']['tmp_name'])){
                        $fileinfo = finfo_open(FILEINFO_MIME_TYPE); //Resource
                        $mimetype = finfo_file($fileinfo, $_FILES['image_two']['tmp_name']);

                        if (substr($mimetype, 0 , 5) != 'image'){
                              echo '<p style="font-size: 0.8em; color: #e67e22;">Please upload the right format</p>';
                        }
                        else{
                          $image_two = $_FILES['image_two']['name'];
                          $image_two_tmp = $_FILES['image_two']['tmp_name'];
                    }
                  }
                      else{
                          $image_two = NULL;
                      }
                    }
                ?>
                <?php
                    echo '</div>
                  </div>
                  <div class="row">
                    <div class="col span-1-of-2 img-upload"  id="img-upload-3">
                      <label for="img-3"><i class="fas fa-upload"></i><span id="file-text-3">Click here to add Image</span></label>
                      <input type="file" name="image_three" id="img-3">';
                ?>
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                    if (is_uploaded_file($_FILES['image_three']['tmp_name'])){
                      $fileinfo = finfo_open(FILEINFO_MIME_TYPE); //Resource
                      $mimetype = finfo_file($fileinfo, $_FILES['image_three']['tmp_name']);

                      if (substr($mimetype, 0 , 5) != 'image'){
                            echo '<p style="font-size: 0.8em; color: #e67e22;">Please upload the right format</p>';
                      }
                      else{
                        $image_three = $_FILES['image_three']['name'];
                        $image_three_tmp = $_FILES['image_three']['tmp_name'];
                  }
                    }
                else{
                    $image_three = NULL;
                }
              }
                ?>
                  <?php
                      echo '</div>
                      <div class="col span-1-of-2 img-upload img-upload-4" id="img-upload-4">
                       <label for="img-4"><i class="fas fa-upload"></i><span id="file-text-4">Click here to add Image</span></label>
                       <input type="file" name="image_four" id="img-4">';
                  ?>

          <?php
          if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            if (is_uploaded_file($_FILES['image_four']['name'])){
              $fileinfo = finfo_open(FILEINFO_MIME_TYPE); //Resource
              $mimetype = finfo_file($fileinfo, $_FILES['image_four']['tmp_name']);

              if (substr($mimetype, 0 , 5) != 'image'){
                    echo '<p style="font-size: 0.8em; color: #e67e22;">Please upload the right format</p>';
              }
                else{
                  $image_four = $_FILES['image_four']['name'];
                  $image_four_tmp = $_FILES['image_four']['tmp_name'];
                }
          }
          else{
              $image_four = NULL;
          }
        }
          ?>
          <?php
              echo '  </div>
             </div>
          </div>
          <input type="submit" name="" value="Done" id="submit-btn">
      </form>
  </div>
</section>';

?>
<?php
  if ($_SERVER['REQUEST_METHOD']){
    if (isset($product_name,$category,$campus,$price,$location,$contact,$description,$image_one,$image_one_tmp) || isset($image_two,$image_three,$image_four
          , $image_two_tmp, $image_three_tmp, $image_four_tmp)){
          $dir = "../Uploads/"; //Directory

          $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $image_one); //Removing Extension
          $folder = $withoutExt;
          mkdir($dir . $withoutExt); //Create dir
          $temp_one = $dir . $withoutExt . '/' . $image_one;

          if (@move_uploaded_file($image_one_tmp, $temp_one )){
              //  echo 'File moved';
              //  echo 'File moved';
          }

          $temp_two = $dir . $withoutExt . '/' . $image_two;
        if ($image_two != NULL){
          if (@move_uploaded_file($image_two_tmp,$temp_two)){
            //  echo 'File moved';
          }
        }


          $temp_three = $dir . $withoutExt . '/' . $image_three;
        if($image_three != NULL){
          if (@move_uploaded_file($image_three_tmp, $temp_three)){
            //  echo 'File moved';
          }
        }
          $temp_four = $dir. $withoutExt . '/' . $image_four;
      if ($image_four != NULL){
          if (@move_uploaded_file($image_four_tmp,$temp_four)){
            //  echo 'File moved';
          }
      }
          $q = "INSERT INTO products(user_id,product_name,category,campus,price,location,contact,description,image_one,image_two,image_three,image_four,date_entered)
                VALUES ('$user_id','$product_name','$category','$campus','$price','$location','$contact','$description','$image_one',
                '$image_two','$image_three','$image_four', NOW())";

          $result = mysqli_query($db,$q);

          if (mysqli_affected_rows($db) == 1){
              echo '<p style="font-size: 0.8em; color: #e67e22;">Your product has been added</p>';
              $product_id = mysqli_insert_id($db);
              rename("../Uploads/" . $folder, "../Uploads/" . $product_id);
              $_POST = array();
          }
    }}

    else{
        echo 'Not all set';
    }

?>
<?php
}  else{
$_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
header("Location: login.php");
exit();
  }


    ?>

<?php
    include('Includes/footer.html');
?>
