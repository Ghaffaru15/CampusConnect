<?php
  $page_title = 'Delete Product';
    include('Includes/header.html');
    include('Includes/config.inc.php');

    if (isset($_SESSION['user_id']) AND isset($_GET['id'])){
        $user_id = $_GET['id'];
        require(MySQL);
        echo '<br /><h3 align="center">Are you sure you want to delete this product</h3><br /><div align="center"><form action="" method="post"><input type="submit"
        value="Yes" /><a href="view_products.php" align="center">No</a></div><div class="productsdisplay">';
        $query = "SELECT users.user_id, contact, product_id, university, product_name, price,image_name,description FROM users,products WHERE
         users.user_id=products.user_id AND product_id=$user_id ";

         $result = mysqli_query($db,$query);

         if (mysqli_num_rows($result) ==1 ){
            while($row = mysqli_fetch_assoc($result)){
              echo '<div class="productinfo">
              <img src="show_image.php?image=' . $row['product_id'] . '&name=' . urlencode($row['image_name']) . '" />
              <h4 class="productname"> ' . $row['product_name'] . '</h4>
              <h4 class="productprice"> ' . $row['price'] . 'gh</h4>
              <h4 class="sellerlocation"> ' . $row['university'] . '</h4>
            </div>';
            }
            echo '<div>';
         }
         if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $q = "DELETE FROM products WHERE product_id=$user_id LIMIT 1";

            $r = mysqli_query($db,$q);

            if (mysqli_affected_rows($db) ==1 ){
                echo '<p>Product, has been deleted.. <a href="view_products.php">View your products</a></p>';
            }
            else{
              echo '<p>Could not delete product</p>';
            }
         }
    }

?>

<?php
  include('Includes/footer.html');
?>
