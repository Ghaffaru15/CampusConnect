<?php
  $page_title = 'View Products';
  include('Includes/header.html');
  include('Includes/config.inc.php');
?>
  <?php
      require(MySQL);
      if (isset($_SESSION['user_id']))      {
            $user_id = $_SESSION['user_id'];

        echo ' <div class="productsdisplay">';
            $query = "SELECT users.user_id, contact, product_id, university, product_name, price,image_name,description FROM users,products WHERE
             users.user_id=products.user_id AND users.user_id=$user_id ORDER BY date_entered DESC";

             $result = mysqli_query($db,$query);

             if (mysqli_num_rows($result)  > 0){
               while($row = mysqli_fetch_assoc($result)){
                    echo '<div class="productinfo">
                    <img src="show_image.php?image=' . $row['product_id'] . '&name=' . urlencode($row['image_name']) . '" />
                    <h4 class="productname"> ' . $row['product_name'] . '</h4>
                    <h4 class="productprice"> ¢' . $row['price'] . '</h4>
                    <h4 class="sellerlocation"> ' . $row['university'] . '</h4>
                    <p align="center"><a href="edit_product.php?id='. $row['product_id'] . '">Edit?</a></p>
                    <p align="center"><a href="delete_product.php?id=' . $row['product_id'] .  '">Delete?</a></p>
                  </div>';
               }
               echo '</div>';
             }
    }
    else{
      header('Location: index.php');
    }
  ?>
<?php
    include('Includes/footer.html');
?>
