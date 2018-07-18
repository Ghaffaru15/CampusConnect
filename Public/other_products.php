<?php
    $page_title = 'Products';
    include('Includes/header.html');
    include('Includes/config.inc.php');
    require(MySQL);
    $display = 2;
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
  if ($_SERVER['REQUEST_METHOD'] == 'POST'){


        if (isset($_POST['campus']) && ($_POST['category'] == NULL) && empty($_POST['search'])){
              $campus = $_POST['campus'];

              $q = "SELECT COUNT(product_id) FROM products WHERE campus='$campus'";
              $r = mysqli_query($db,$q);

              $row = mysqli_fetch_array($r);
              $records = $row[0];

              if ($records > $display){
                  $pages = ceil($records/$display);
              }
              else{
                  $pages = 1;
              }
              $start = 0;

              $query = "SELECT users.user_id,first_name, last_name, product_name, campus, product_id, price,
                        image_one FROM users, products WHERE users.user_id=products.user_id
                        AND campus='$campus' ORDER BY date_entered DESC LIMIT $start,$display";

              $result = mysqli_query($db,$query);


              echo '<div class="productsdisplay">';

              if (mysqli_num_rows($result) > 0){

                  while($row = mysqli_fetch_assoc($result)){
                      echo '<div class="productinfo">
                      <a href="inner_products_buy.php?id=' . $row['product_id'] . '&first_name=' . $row['first_name']
                      . '&last_name=' . $row['last_name'] .'"><img src="show_image.php?image=' . $row['product_id'] .
                      '&name=' . urlencode($row['image_one']) . '" /></a>
                                <h4 class="productname"> ' . $row['product_name'] . '</h4>
                                <h4 class="productprice"> ¢' . $row['price'] . '</h4>
                                <h4 class="sellerlocation"> ' . $row['campus'] . '</h4>
                            </div>';
                  }
                    echo '</div>';
                if ($pages > 1){
                echo '<br /><p align="center">';
                $current_page = ($start/$display) + 1;

                if ($current_page != 1){
                  echo '<a href="other_products.php?scamp=' .  ($start - $display) . '&pcamp=' . $pages . '&camp=' . $campus . '" style="color:blue;">Previous</a> ';
                }

                //Makes all pages numbered
                for ($i = 1; $i <= $pages; $i++){
                    if ($i != $current_page){
                        echo '<a href="other_products.php?scamp=' . (($display * ($i - 1))) . '&pcamp=' . $pages . '&camp=' . $campus . '"style="color:blue;">' . $i . '</a> ';
                    }
                    else{
                        echo $i . ' ';
                    }
                }
                //Next button link;
                if ($current_page != $pages){
                    echo '<a href="other_products.php?scamp=' .  ($start + $display) . '&pcamp=' . $pages . '&camp=' . $campus . ' "style="color:blue;">Next</a>';
                }
                echo '</p>';
              }
            }
            else{
                  echo '<div style="width:100%"><p>Your search returned no matches</p>
                        <p>Suggestions:</p>
                        <ul><li>Try fewer keywords</li>
                            <li>Try other campuses to connect with sellers</li>
                            <li>Try more general keywords<li></ul></div>';
            }
        }
        elseif (isset($_POST['category']) && ($_POST['campus'] == NULL) && empty($_POST['search'])){

              $category = $_POST['category'];
              $q = "SELECT COUNT(product_id) FROM products WHERE category='$category'";
              $r = mysqli_query($db,$q);

              $row = mysqli_fetch_array($r);
              $records = $row[0];

              if ($records > $display){
                  $pages = ceil($records/$display);
              }
              else{
                  $pages = 1;
              }
              $start = 0;

              $query = "SELECT users.user_id, first_name, last_name, product_name, category, product_id, price, image_one
                        FROM users,products WHERE users.user_id=products.user_id AND category='$category'
                        ORDER BY date_entered DESC LIMIT $start,$display";
              $result = mysqli_query($db,$query);
              echo '<div class="productsdisplay">';

              if (mysqli_num_rows($result) > 0){
                  while($row = mysqli_fetch_assoc($result)){
                      echo '<div class="productinfo">
                      <a href="inner_products_buy.php?id=' . $row['product_id'] . '&first_name=' . $row['first_name']
                      . '&last_name=' . $row['last_name'] .'"><img src="show_image.php?image=' . $row['product_id'] .
                      '&name=' . urlencode($row['image_one']) . '" /></a>
                                <h4 class="productname"> ' . $row['product_name'] . '</h4>
                                <h4 class="productprice"> ¢' . $row['price'] . '</h4>
                                <h4 class="sellerlocation"> ' . $row['category'] . '</h4>
                            </div>';
                  }
                  echo '</div>';
                  if ($pages > 1){
                  echo '<br /><p align="center">';
                  $current_page = ($start/$display) + 1;

                  if ($current_page != 1){
                    echo '<a href="other_products.php?scat=' .  ($start - $display) . '&pcat=' . $pages . '&cat=' . $category . '" style="color:blue;">Previous</a> ';
                  }

                  //Makes all pages numbered
                  for ($i = 1; $i <= $pages; $i++){
                      if ($i != $current_page){
                          echo '<a href="other_products.php?scat=' . (($display * ($i - 1))) . '&pcat=' . $pages . '&cat=' . $category . '"style="color:blue;">' . $i . '</a> ';
                      }
                      else{
                          echo $i . ' ';
                      }
                  }
                  //Next button link;
                  if ($current_page != $pages){
                      echo '<a href="other_products.php?scat=' .  ($start + $display) . '&pcat=' . $pages . '&cat=' . $category . ' "style="color:blue;">Next</a>';
                  }
                  echo '</p>';
                }
              }
              else{
                    echo '<div style="width:100%;"<p>Your search returned no matches</p>
                          <p>Suggestions:</p>
                          <ul><li>Try fewer keywords</li>
                              <li>Try other campuses to connect with sellers</li>
                              <li>Try more general keywords<li></ul></div>';
              }
        }
        elseif (isset($_POST['search']) && ($_POST['campus'] == NULL) && ($_POST['category'] == NULL)){

          $search = strip_tags(trim($_POST['search']));
          $search = mysqli_real_escape_string($db,$search);
          $q = "SELECT COUNT(product_id) FROM products WHERE product_name LIKE '%$search%'";
          $r = mysqli_query($db,$q);

          $row = mysqli_fetch_array($r);
          $records = $row[0];

          if ($records > $display){
              $pages = ceil($records/$display);
          }
          else{
              $pages = 1;
          }
          $start = 0;

            $query = "SELECT users.user_id, first_name, last_name, product_name, campus, product_id, price, image_one
                      FROM users,products WHERE users.user_id=products.user_id AND product_name LIKE '%$search%'
                      ORDER BY date_entered DESC LIMIT $start,$display";

            $result = mysqli_query($db,$query);
            echo '<div class="productsdisplay">';

            if (mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                  echo '<div class="productinfo">
                  <a href="inner_products_buy.php?id=' . $row['product_id'] . '&first_name=' . $row['first_name']
                  . '&last_name=' . $row['last_name'] .'"><img src="show_image.php?image=' . $row['product_id'] .
                  '&name=' . urlencode($row['image_one']) . '" /></a>
                            <h4 class="productname"> ' . $row['product_name'] . '</h4>
                            <h4 class="productprice"> ¢' . $row['price'] . '</h4>
                            <h4 class="sellerlocation"> ' . $row['campus'] . '</h4>
                        </div>';
                }
                echo '</div>';
                if ($pages > 1){
                echo '<br /><p align="center">';
                $current_page = ($start/$display) + 1;

                if ($current_page != 1){
                  echo '<a href="other_products.php?ssearch=' .  ($start - $display) . '&psearch=' . $pages . '&searchp=' . $search . '" style="color:blue;">Previous</a> ';
                }

                //Makes all pages numbered
                for ($i = 1; $i <= $pages; $i++){
                    if ($i != $current_page){
                        echo '<a href="other_products.php?ssearch=' . (($display * ($i - 1))) . '&psearch=' . $pages . '&search=' . $search . '"style="color:blue;">' . $i . '</a> ';
                    }
                    else{
                        echo $i . ' ';
                    }
                }
                //Next button link;
                if ($current_page != $pages){
                    echo '<a href="other_products.php?ssearch=' .  ($start + $display) . '&psearch=' . $pages . '&search=' . $search . ' "style="color:blue;">Next</a>';
                }
                echo '</p>';
              }
            }else{
                  echo '<div style="width:100%"><p>Your search returned no matches</p>
                        <p>Suggestions:</p>
                        <ul><li>Try fewer keywords</li>
                            <li>Try other campuses to connect with sellers</li>
                            <li>Try more general keywords<li></ul></div>';
            }

        }
        elseif (isset($_POST['campus']) && isset($_POST['category']) && empty($_POST['search'])){

          $campus = $_POST['campus'];
          $category = $_POST['category'];

          $q = "SELECT COUNT(product_id) FROM products WHERE campus='$campus' AND category='$category'";
          $r = mysqli_query($db,$q);

          $row = mysqli_fetch_array($r);
          $records = $row[0];

          if ($records > $display){
              $pages = ceil($records/$display);
          }
          else{
              $pages = 1;
          }
          $start = 0;

              $query = "SELECT users.user_id, first_name, last_name, product_name, campus, category, product_id, price, image_one
                        FROM users, products WHERE users.user_id=products.user_id AND campus='$campus' AND
                        category='$category' ORDER BY date_entered DESC LIMIT $start,$display";
              $result = mysqli_query($db,$query);
              echo '<div class="productsdisplay">';

              if (mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                echo '<div class="productinfo">
                <a href="inner_products_buy.php?id=' . $row['product_id'] . '&first_name=' . $row['first_name']
                . '&last_name=' . $row['last_name'] .'"><img src="show_image.php?image=' . $row['product_id'] .
                '&name=' . urlencode($row['image_one']) . '" /></a>
                          <h4 class="productname"> ' . $row['product_name'] . '</h4>
                          <h4 class="productprice"> ¢' . $row['price'] . '</h4>
                          <h4 class="sellerlocation"> ' . $row['campus'] . '</h4>
                          <h4 class="category"> ' . $row['category'] . '</h4>
                      </div>';
            }
            echo '</div>';
            if ($pages > 1){
            echo '<br /><p align="center">';
            $current_page = ($start/$display) + 1;

            if ($current_page != 1){
                echo '<a href="other_products.php?scampcat=' .  ($start - $display) . '&pcampcat=' . $pages . '&camp=' . $campus .
              '&cat=' . $category .  '" style="color:blue;">Previous</a> ';
            }

            //Makes all pages numbered
            for ($i = 1; $i <= $pages; $i++){
                if ($i != $current_page){
                    echo '<a href="other_products.php?scampcat=' . (($display * ($i - 1))) . '&pcampcat=' . $pages . '&camp=' . $campus .
                    '&cat=' . $category .  '"style="color:blue;">' . $i . '</a> ';
                }
                else{
                    echo $i . ' ';
                }
            }
            //Next button link;
            if ($current_page != $pages){
                echo '<a href="other_products.php?scampcat=' .  ($start + $display) . '&pcampcat=' . $pages . '&camp=' . $campus .
                '&cat=' . $category .  ' "style="color:blue;">Next</a>';
            }
            echo '</p>';
          }
        }
        else{
              echo '<div style="width: 100%"><p>Your search returned no matches</p>
                    <p>Suggestions:</p>
                    <ul><li>Try fewer keywords</li>
                        <li>Try other campuses to connect with sellers</li>
                        <li>Try more general keywords<li></ul></div>';
        }
      }
      elseif (isset($_POST['campus']) && isset($_POST['category']) && !empty($_POST['search'])){

        $campus = $_POST['campus'];
        $category = $_POST['category'];
        $search = strip_tags(trim($_POST['search']));
        $search = mysqli_real_escape_string($db,$search);

        $q = "SELECT COUNT(product_id) FROM products WHERE campus='$campus' AND category='$category' AND product_name
              LIKE '%$search%'
              ";
        $r = mysqli_query($db,$q);

        $row = mysqli_fetch_array($r);
        $records = $row[0];

        if ($records > $display){
            $pages = ceil($records/$display);
        }
        else{
            $pages = 1;
        }
        $start = 0;

          $query = "SELECT users.user_id, first_name, last_name, product_name, campus, category, product_id, price, image_one
                    FROM users, products WHERE users.user_id=products.user_id AND campus='$campus' AND
                    category='$category' AND product_name LIKE '%$search%' ORDER BY date_entered DESC LIMIT $start,$display";

          $result = mysqli_query($db,$query);
                    echo '<div class="productsdisplay">';
          if (mysqli_num_rows($result) > 0){
              while ($row = mysqli_fetch_assoc($result)){
                echo '<div class="productinfo">
                <a href="inner_products_buy.php?id=' . $row['product_id'] . '&first_name=' . $row['first_name']
                . '&last_name=' . $row['last_name'] .'"><img src="show_image.php?image=' . $row['product_id'] .
                '&name=' . urlencode($row['image_one']) . '" /></a>
                          <h4 class="productname"> ' . $row['product_name'] . '</h4>
                          <h4 class="productprice"> ¢' . $row['price'] . '</h4>
                          <h4 class="sellerlocation"> ' . $row['campus'] . '</h4>
                          <h4 class="category"> ' . $row['category'] . '</h4>
                      </div>';
              }
              echo '</div>';
              if ($pages > 1){
              echo '<br /><p align="center">';
              $current_page = ($start/$display) + 1;

              if ($current_page != 1){
                echo '<a href="other_products.php?scampcatsearch=' .  ($start - $display) . '&pcampcatsearch=' . $pages . '&camp=' . $campus .
                '&cat=' . $category . '&search=' . $search .  '" style="color:blue;">Previous</a> ';
              }

              //Makes all pages numbered
              for ($i = 1; $i <= $pages; $i++){
                  if ($i != $current_page){
                      echo '<a href="other_products.php?scampcatsearch=' . (($display * ($i - 1))) . '&pcampcatsearch=' . $pages . '&camp=' . $campus .
                      '&cat=' . $category . '&search=' . $search .  '"style="color:blue;">' . $i . '</a> ';
                  }
                  else{
                      echo $i . ' ';
                  }
              }
              //Next button link;
              if ($current_page != $pages){
                  echo '<a href="other_products.php?scampcatsearch=' .  ($start + $display) . '&pcampcatsearch=' . $pages . '&camp=' . $campus .
                  '&cat=' . $category . '&search=' . $search .  ' "style="color:blue;">Next</a>';
              }
              echo '</p>';
            }
          }
          else{
                echo '<div style="width: 100%"><p>Your search returned no matches</p>
                      <p>Suggestions:</p>
                      <ul><li>Try fewer keywords</li>
                          <li>Try other campuses to connect with sellers</li>
                          <li>Try more general keywords<li></ul></div>';
          }
      }

  }
  if ($_SERVER['REQUEST_METHOD'] == 'GET'){
      if (isset($_GET['scamp'], $_GET['pcamp'], $_GET['camp'])){

          $start = $_GET['scamp'];
          $pages = $_GET['pcamp'];
          $campus = $_GET['camp'];

          $query = "SELECT users.user_id, first_name, last_name, product_name, campus, product_id, price,
                    image_one FROM users, products WHERE users.user_id=products.user_id
                    AND campus='$campus' ORDER BY date_entered DESC LIMIT $start,$display";
          $result = mysqli_query($db,$query);

          echo '<div class="productsdisplay">';
          if (mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                echo '<div class="productinfo">
                <a href="inner_products_buy.php?id=' . $row['product_id'] . '&first_name=' . $row['first_name']
                . '&last_name=' . $row['last_name'] .'"><img src="show_image.php?image=' . $row['product_id'] .
                '&name=' . urlencode($row['image_one']) . '" /></a>
                          <h4 class="productname"> ' . $row['product_name'] . '</h4>
                          <h4 class="productprice"> ¢' . $row['price'] . '</h4>
                          <h4 class="sellerlocation"> ' . $row['campus'] . '</h4>
                      </div>';
            }
            echo '</div>';
          }
          echo '<br /><p align="center">';
          $current_page = ($start/$display) + 1;

          if ($current_page != 1){
            echo '<a href="other_products.php?scamp=' .  ($start - $display) . '&pcamp=' . $pages . '&camp=' . $campus . '" style="color:blue;">Previous</a> ';
          }

          //Makes all pages numbered
          for ($i = 1; $i <= $pages; $i++){
              if ($i != $current_page){
                  echo '<a href="other_products.php?scamp=' . (($display * ($i - 1))) . '&pcamp=' . $pages . '&camp=' . $campus . '"style="color:blue;">' . $i . '</a> ';
              }
              else{
                  echo $i . ' ';
              }
          }
          //Next button link;
          if ($current_page != $pages){
              echo '<a href="other_products.php?scamp=' .  ($start + $display) . '&pcamp=' . $pages . '&camp=' . $campus . ' "style="color:blue;">Next</a>';
          }
          echo '</p>';

      }

      elseif (isset($_GET['scat'], $_GET['pcat'], $_GET['cat'])){

          $start = $_GET['scat'];
          $pages = $_GET['pcat'];
          $category = $_GET['cat'];

          $query = "SELECT users.user_id, first_name, last_name, product_name, campus,category, product_id, price,
                    image_one FROM users, products WHERE users.user_id=products.user_id
                    AND category='$category' ORDER BY date_entered DESC LIMIT $start,$display";
          $result = mysqli_query($db,$query);

          echo '<div class="productsdisplay">';
          if (mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                echo '<div class="productinfo">
                <a href="inner_products_buy.php?id=' . $row['product_id'] . '&first_name=' . $row['first_name']
                . '&last_name=' . $row['last_name'] .'"><img src="show_image.php?image=' . $row['product_id'] .
                '&name=' . urlencode($row['image_one']) . '" /></a>
                          <h4 class="productname"> ' . $row['product_name'] . '</h4>
                          <h4 class="productprice"> ¢' . $row['price'] . '</h4>
                          <h4 class="sellerlocation"> ' . $row['category'] . '</h4>
                      </div>';
            }
            echo '</div>';
          }
          echo '<br /><p align="center">';
          $current_page = ($start/$display) + 1;

          if ($current_page != 1){
            echo '<a href="other_products.php?scat=' .  ($start - $display) . '&pcat=' . $pages . '&cat=' . $category . '" style="color:blue;">Previous</a> ';
          }

          //Makes all pages numbered
          for ($i = 1; $i <= $pages; $i++){
              if ($i != $current_page){
                  echo '<a href="other_products.php?scat=' . (($display * ($i - 1))) . '&pcat=' . $pages . '&cat=' . $category . '"style="color:blue;">' . $i . '</a> ';
              }
              else{
                  echo $i . ' ';
              }
          }
          //Next button link;
          if ($current_page != $pages){
              echo '<a href="other_products.php?scat=' .  ($start + $display) . '&pcat=' . $pages . '&cat=' . $category . ' "style="color:blue;">Next</a>';
          }
          echo '</p>';

      }

      elseif (isset($_GET['ssearch'],$_GET['psearch'], $_GET['search'])){
          $start = $_GET['ssearch'];
          $pages = $_GET['psearch'];
          $search = $_GET['search'];

          $query = "SELECT users.user_id, first_name, last_name, product_name, campus,category, product_id, price,
                    image_one FROM users, products WHERE users.user_id=products.user_id
                    AND product_name LIKE '%$search%' ORDER BY date_entered DESC LIMIT $start,$display";
          $result = mysqli_query($db,$query);

          echo '<div class="productsdisplay">';
          if (mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                echo '<div class="productinfo">
                <a href="inner_products_buy.php?id=' . $row['product_id'] . '&first_name=' . $row['first_name']
                . '&last_name=' . $row['last_name'] .'"><img src="show_image.php?image=' . $row['product_id'] .
                '&name=' . urlencode($row['image_one']) . '" /></a>
                          <h4 class="productname"> ' . $row['product_name'] . '</h4>
                          <h4 class="productprice"> ¢' . $row['price'] . '</h4>
                          <h4 class="sellerlocation"> ' . $row['campus'] . '</h4>
                      </div>';
            }
            echo '</div>';
          }
          else{
                echo '<p>Your search returned no matches</p>
                      <p>Suggestions:</p>
                      <ul><li>Try fewer keywords</li>
                          <li>Try other campuses to connect with sellers</li>
                          <li>Try more general keywords<li></ul>';
          }
          echo '<br /><p align="center">';
          $current_page = ($start/$display) + 1;

          if ($current_page != 1){
            echo '<a href="other_products.php?ssearch=' .  ($start - $display) . '&psearch=' . $pages . '&search=' . $search . '" style="color:blue;">Previous</a> ';
          }

          //Makes all pages numbered
          for ($i = 1; $i <= $pages; $i++){
              if ($i != $current_page){
                  echo '<a href="other_products.php?ssearch=' . (($display * ($i - 1))) . '&psearch=' . $pages . '&search=' . $search . '"style="color:blue;">' . $i . '</a> ';
              }
              else{
                  echo $i . ' ';
              }
          }
          //Next button link;
          if ($current_page != $pages){
              echo '<a href="other_products.php?ssearch=' .  ($start + $display) . '&psearch=' . $pages . '&search=' . $search . ' "style="color:blue;">Next</a>';
          }
          echo '</p>';

      }
      elseif (isset($_GET['pcampcat'],$_GET['scampcat'],$_GET['camp'],$_GET['cat'])){

          $start = $_GET['scampcat'];
          $pages = $_GET['pcampcat'];
          $category = $_GET['cat'];
          $campus = $_GET['camp'];

          $query = "SELECT users.user_id, first_name, last_name,  product_name, campus, category, product_id, price, image_one
                    FROM users, products WHERE users.user_id=products.user_id AND campus='$campus' AND
                    category='$category' ORDER BY date_entered DESC LIMIT $start,$display";
          $result = mysqli_query($db,$query);
          echo '<div class="productsdisplay">';

          if (mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
            echo '<div class="productinfo">
            <a href="inner_products_buy.php?id=' . $row['product_id'] . '&first_name=' . $row['first_name']
            . '&last_name=' . $row['last_name'] .'"><img src="show_image.php?image=' . $row['product_id'] .
            '&name=' . urlencode($row['image_one']) . '" /></a>
                      <h4 class="productname"> ' . $row['product_name'] . '</h4>
                      <h4 class="productprice"> ¢' . $row['price'] . '</h4>
                      <h4 class="sellerlocation"> ' . $row['campus'] . '</h4>
                      <h4 class="category"> ' . $row['category'] . '</h4>
                  </div>';
        }
        echo '</div>';

        echo '<br /><p align="center">';
        $current_page = ($start/$display) + 1;

        if ($current_page != 1){
          echo '<a href="other_products.php?scampcat=' .  ($start - $display) . '&pcampcat=' . $pages . '&camp=' . $campus .
          '&cat=' . $category .  '" style="color:blue;">Previous</a> ';
        }

        //Makes all pages numbered
        for ($i = 1; $i <= $pages; $i++){
            if ($i != $current_page){
                echo '<a href="other_products.php?scampcat=' . (($display * ($i - 1))) . '&pcampcat=' . $pages . '&camp=' . $campus .
                '&cat=' . $category .  '"style="color:blue;">' . $i . '</a> ';
            }
            else{
                echo $i . ' ';
            }
        }
        //Next button link;
        if ($current_page != $pages){
            echo '<a href="other_products.php?scampcat=' .  ($start + $display) . '&pcampcat=' . $pages . '&camp=' . $campus .
            '&cat=' . $category .  ' "style="color:blue;">Next</a>';
        }
        echo '</p>';
      }
    }
    elseif (isset($_GET['scampcatsearch'],$_GET['pcampcatsearch'],$_GET['camp'],$_GET['cat'],$_GET['search'])){
        $start = $_GET['scampcatsearch'];
        $pages = $_GET['pcampcatsearch'];
        $campus = $_GET['camp'];
        $category = $_GET['cat'];
        $search = $_GET['search'];

        $query = "SELECT users.user_id, first_name, last_name, product_name, campus, category, product_id, price, image_one
                  FROM users, products WHERE users.user_id=products.user_id AND campus='$campus' AND
                  category='$category' AND product_name LIKE '%$search%' ORDER BY date_entered DESC LIMIT $start,$display";

        $result = mysqli_query($db,$query);
                  echo '<div class="productsdisplay">';
        if (mysqli_num_rows($result) > 0){
            while ($row = mysqli_fetch_assoc($result)){
              echo '<div class="productinfo">
              <a href="inner_products_buy.php?id=' . $row['product_id'] . '&first_name=' . $row['first_name']
              . '&last_name=' . $row['last_name'] .'"><img src="show_image.php?image=' . $row['product_id'] .
              '&name=' . urlencode($row['image_one']) . '" /></a>
                        <h4 class="productname"> ' . $row['product_name'] . '</h4>
                        <h4 class="productprice"> ¢' . $row['price'] . '</h4>
                        <h4 class="sellerlocation"> ' . $row['campus'] . '</h4>
                        <h4 class="category"> ' . $row['category'] . '</h4>
                    </div>';
            }
            echo '</div>';

            echo '<br /><p align="center">';
            $current_page = ($start/$display) + 1;

            if ($current_page != 1){
              echo '<a href="other_products.php?scampcatsearch=' .  ($start - $display) . '&pcampcatsearch=' . $pages . '&camp=' . $campus .
              '&cat=' . $category . '&search=' . $search .  '" style="color:blue;">Previous</a> ';
            }

            //Makes all pages numbered
            for ($i = 1; $i <= $pages; $i++){
                if ($i != $current_page){
                    echo '<a href="other_products.php?scampcatsearch=' . (($display * ($i - 1))) . '&pcampcatsearch=' . $pages . '&camp=' . $campus .
                    '&cat=' . $category . '&search=' . $search .  '"style="color:blue;">' . $i . '</a> ';
                }
                else{
                    echo $i . ' ';
                }
            }
            //Next button link;
            if ($current_page != $pages){
                echo '<a href="other_products.php?scampcatsearch=' .  ($start + $display) . '&pcampcatsearch=' . $pages . '&camp=' . $campus .
                '&cat=' . $category . '&search=' . $search .  ' "style="color:blue;">Next</a>';
            }
            echo '</p>';
          }
    }
    elseif (isset($_GET['s'],$_GET['p'])){
        $start = $_GET['s'];
        $pages = $_GET['p'];

        $query = "SELECT users.user_id,first_name, last_name, product_name, campus, product_id, price, image_one
                  FROM users, products WHERE users.user_id=products.user_id ORDER BY
                  date_entered DESC LIMIT $start,$display";
        $result = mysqli_query($db,$query);
        echo '<div class="productsdisplay">';

        if (mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
              echo '<div class="productinfo">
              <a href="inner_products_buy.php?id=' . $row['product_id'] . '&first_name=' . $row['first_name']
              . '&last_name=' . $row['last_name'] .'"><img src="show_image.php?image=' . $row['product_id'] .
              '&name=' . urlencode($row['image_one']) . '" /></a>
                        <h4 class="productname"> ' . $row['product_name'] . '</h4>
                        <h4 class="productprice"> ¢' . $row['price'] . '</h4>
                        <h4 class="sellerlocation"> ' . $row['campus'] . '</h4>
                    </div>';
            }
            echo '</div>';

            echo '<br /><p align="center">';
            $current_page = ($start/$display) + 1;

            if ($current_page != 1){
              echo '<a href="other_products.php?s=' .  ($start - $display) . '&p=' . $pages . '" style="color:blue;">Previous</a> ';
            }

            //Makes all pages numbered
            for ($i = 1; $i <= $pages; $i++){
                if ($i != $current_page){
                    echo '<a href="other_products.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '"style="color:blue;">' . $i . '</a> ';
                }
                else{
                    echo $i . ' ';
                }
            }
            //Next button link;
            if ($current_page != $pages){
                echo '<a href="other_products.php?s=' .  ($start + $display) . '&p=' . $pages . '"style="color:blue;">Next</a>';
            }
            echo '</p>';
          }
    }

}
  ?>
<?php
    include('Includes/footer.html');
?>
