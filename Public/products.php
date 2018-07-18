<?php
    $page_title = 'Products';
    include('Includes/header.html');
    include('Includes/config.inc.php');
?>
<section class="row product-buy-container">
    <h2>Products &#38; Services</h2>
    <form action="" method="post">
        <div class="row buy-filters">
            <div class="col span-1-of-2" id="school">
                <select name="campus">
                    <option value="">Select School/Campus</option>
                        <option value="UG, Legon Campus">UG, Legon Campus</option>
                        <option value="UG, City Campus">UG, City Campus</option>
                        <option value="KNUST">KNUST</option>
                        <option value="UDS, Tamale Campus">UDS, Tamale Campus</option>
                        <option value="UDS, Wa Campus">UDS, Wa  Campus</option>
                        <option value="UDS, Navrongo Campus">UDS, Navrongo Campus </option>
                        <option value="UCC">UCC</option>
                        <option value="UEW">UEW</option>
                        <option value="UPS">UPS</option>
                        <option value="UMAT">UMAT</option>
                        <option value="GIMPA">GIMPA</option>
                        <option value="UENR">UENR</option>
                </select>
            </div>
            <div class="col span-1-of-2" id="category">
                <select name="category">
                        <option value="">Choose Category</option>
                        <option value="Jewellery">Jewellery</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Fashion">Fashion</option>
                        <option value="Stationery">Stationery</option>
                        <option value="Food & Drinks">Food &  Drinks</option>
                        <option value="Services">Services</option>
                </select>
            </div>
        </div>
        <div class="row search-product">
            <div class="col span-3-of-4" id="search-button">
                <input type="text" name="search" id="search-products" placeholder="what are you looking for?">
            </div>
            <div class="col span-1-of-4">
               <input type="submit" name="" value="Submit"  id="search-btn">
            </div>
        </div>
    </form>
</section>

<?php
    require(MySQL);
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
          if (isset($_POST['campus']) && ($_POST['category'] == NULL) && empty($_POST['search'])){
                $campus = $_POST['campus'];
                $query = "SELECT users.user_id, product_name, campus, product_id, price,
                          image_one FROM users, products WHERE users.user_id=products.user_id
                          AND campus='$campus' ORDER BY date_entered DESC";
                $result = mysqli_query($db,$query);

                echo '<div class="productsdisplay">';

                if (mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        echo '<div class="productinfo">
                                  <img src="show_image.php?image=' . $row['product_id'] .
                                  '&name=' . urlencode($row['image_one']) . '" />
                                  <h4 class="productname"> ' . $row['product_name'] . '</h4>
                                  <h4 class="productprice"> ¢' . $row['price'] . '</h4>
                                  <h4 class="sellerlocation"> ' . $row['campus'] . '</h4>
                              </div>';
                    }
                    echo '</div>';
                }
          }
          elseif (isset($_POST['category']) && ($_POST['campus'] == NULL) && empty($_POST['search'])){
                $category = $_POST['category'];
                $query = "SELECT users.user_id, product_name, category, product_id, price, image_one
                          FROM users,products WHERE users.user_id=products.user_id AND category='$category'
                          ORDER BY date_entered DESC";
                $result = mysqli_query($db,$query);
                echo '<div class="productsdisplay">';

                if (mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        echo '<div class="productinfo">
                                  <img src="show_image.php?image=' . $row['product_id'] .
                                  '&name=' . urlencode($row['image_one']) . '" />
                                  <h4 class="productname"> ' . $row['product_name'] . '</h4>
                                  <h4 class="productprice"> ¢' . $row['price'] . '</h4>
                                  <h4 class="sellerlocation"> ' . $row['category'] . '</h4>
                              </div>';
                    }
                    echo '</div>';
                }
          }
          elseif (isset($_POST['search']) && ($_POST['campus'] == NULL) && ($_POST['category'] == NULL)){
              $search = strip_tags(trim($_POST['search']));
              $search = mysqli_real_escape_string($db,$search);
              $query = "SELECT users.user_id, product_name, campus, product_id, price, image_one
                        FROM users,products WHERE users.user_id=products.user_id AND product_name LIKE '%$search%'
                        ORDER BY date_entered DESC";

              $result = mysqli_query($db,$query);
              echo '<div class="productsdisplay">';

              if (mysqli_num_rows($result) > 0){
                  while($row = mysqli_fetch_assoc($result)){
                    echo '<div class="productinfo">
                              <img src="show_image.php?image=' . $row['product_id'] .
                              '&name=' . urlencode($row['image_one']) . '" />
                              <h4 class="productname"> ' . $row['product_name'] . '</h4>
                              <h4 class="productprice"> ¢' . $row['price'] . '</h4>
                              <h4 class="sellerlocation"> ' . $row['campus'] . '</h4>
                          </div>';
                  }
                  echo '</div>';
              }
          }
          elseif (isset($_POST['campus']) && isset($_POST['category']) && empty($_POST['search'])){
                $campus = $_POST['campus'];
                $category = $_POST['category'];

                $query = "SELECT users.user_id, product_name, campus, category, product_id, price, image_one
                          FROM users, products WHERE users.user_id=products.user_id AND campus='$campus' AND
                          category='$category' ORDER BY date_entered DESC";
                $result = mysqli_query($db,$query);
                echo '<div class="productsdisplay">';

                if (mysqli_num_rows($result) > 0){
                  while($row = mysqli_fetch_assoc($result)){
                  echo '<div class="productinfo">
                            <img src="show_image.php?image=' . $row['product_id'] .
                            '&name=' . urlencode($row['image_one']) . '" />
                            <h4 class="productname"> ' . $row['product_name'] . '</h4>
                            <h4 class="productprice"> ¢' . $row['price'] . '</h4>
                            <h4 class="sellerlocation"> ' . $row['campus'] . '</h4>
                            <h4 class="category"> ' . $row['category'] . '</h4>
                        </div>';
              }
              echo '</div>';
          }
        }
        elseif (isset($_POST['campus']) && isset($_POST['category']) && !empty($_POST['search'])){
            $category = $_POST['category'];
            $campus = $_POST['campus'];
            $search = strip_tags(trim($_POST['search']));
            $search = mysqli_real_escape_string($db,$search);

            $query = "SELECT users.user_id, product_name, campus, category, product_id, price, image_one
                      FROM users, products WHERE users.user_id=products.user_id AND campus='$campus' AND
                      category='$category' AND product_name LIKE '%$search%' ORDER BY date_entered DESC";

            $result = mysqli_query($db,$query);
                      echo '<div class="productsdisplay">';
            if (mysqli_num_rows($result) > 0){
                while ($row = mysqli_fetch_assoc($result)){
                  echo '<div class="productinfo">
                            <img src="show_image.php?image=' . $row['product_id'] .
                            '&name=' . urlencode($row['image_one']) . '" />
                            <h4 class="productname"> ' . $row['product_name'] . '</h4>
                            <h4 class="productprice"> ¢' . $row['price'] . '</h4>
                            <h4 class="sellerlocation"> ' . $row['campus'] . '</h4>
                            <h4 class="category"> ' . $row['category'] . '</h4>
                        </div>';
                }
                echo '</div>';
            }
        }
    }
    else{
        $query = "SELECT users.user_id, product_name, campus, product_id, price, image_one
                  FROM users, products WHERE users.user_id=products.user_id ORDER BY
                  date_entered DESC";
        $result = mysqli_query($db,$query);
        echo '<div class="productsdisplay">';

        if (mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
              echo '<div class="productinfo">
                        <img src="show_image.php?image=' . $row['product_id'] .
                        '&name=' . urlencode($row['image_one']) . '" />
                        <h4 class="productname"> ' . $row['product_name'] . '</h4>
                        <h4 class="productprice"> ¢' . $row['price'] . '</h4>
                        <h4 class="sellerlocation"> ' . $row['campus'] . '</h4>
                    </div>';
            }
            echo '</div>';
        }
    }
?>

<?php
    include("Includes/footer.html");
?>
