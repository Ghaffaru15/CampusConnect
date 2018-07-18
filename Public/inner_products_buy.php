<?php
    $page_title = 'Product details';
    include('Includes/header.html');
    include('Includes/config.inc.php');
    require(MySQL);
    function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
?>
    <?php
        if (isset($_GET['id']) AND isset($_GET['first_name']) AND isset($_GET['last_name'])){
            $product_id = $_GET['id'];
            $first_name = $_GET['first_name'];
            $last_name = $_GET['last_name'];

            $q = "SELECT product_name, category, campus,price, description,location, contact, image_one, image_two, image_three,
                  image_four, date_entered FROM products WHERE product_id=$product_id";

            $r = mysqli_query($db,$q);
            echo '<section class="inner-container">';
            echo '<section class="row inner-product-buy-container">';
            if (mysqli_num_rows($r) > 0){
                while ($row = mysqli_fetch_assoc($r)){
                    echo '<h4>' . $row['product_name'] . '</h4>';
                    echo '<p>posted by: <span>' . $first_name . ' ' . $last_name . '</span></p>';
                    echo '<p>date posted: <span>' . time_elapsed_string($row['date_entered']) . '</span></p>';
                    echo '<div class="row">
                        <div class="col span-1-of-2 product-imgs">
                            <div class="row main-img"><img src="view_image.php?name=' . $row['image_one'] . '&id='
                            . $product_id . '"></div>
                            <div class="row other-imgs">
                                <div class="col span-1-of-4"><img src="view_image.php?name=' . $row['image_one'] . '&id='
                                . $product_id . ' "alt=" "></div>'?>
                                <?php
                                if (file_exists($row['image_two'])){

                                echo '<div class="col span-1-of-4"><img src="view_image.php?name=' . $row['image_two'] . '&id='
                                . $product_id . '  " alt=" "></div>';
                                } ?>
                                <?php
                                if (file_exists($row['image_three'])){

                                echo '<div class="col span-1-of-4"><img src="view_image.php?name=' . $row['image_three'] . '&id='
                                . $product_id . '  " alt=" "></div>';
                                }
                                ?>
                                <?php
                                if (file_exists($row['image_four'])){
                                echo '<div class="col span-1-of-4"><img src="view_image.php?name=' . $row['image_four'] . '&id='
                                . $product_id . '  " alt=" "></div>';
                              }
                              ?>
                              <?php echo '
                            </div>
                            </div>
                            <div class="col span 2-of-5 product-minor-details">
                                <div class="row inner-price minor-details">
                                    <h5>Price:</h5>
                                    <p id="inner-price">¢' . $row['price'] . ' </p>
                                </div>
                                <div class="row product-category minor-details">
                                    <h5>Category:</h5>  <p>' . $row['category'] . '</p>
                                    </div>
                                    <div class="row school minor-details">
                                        <h5>School/Campus:</h5>
                                        <p>' . $row['campus'] . '</p>
                                    </div>
                                    <div class="location minor-details">
                                        <h5>Location:</h5>
                                        <p>' . $row['location'] . '</p>
                                    </div>
                                    <div class="contact-number minor-details">
                                        <h5>Contact Number:</h5>
                                        <p>' . $row['contact'] . '</p>
                                    </div>
                                    </div>
                                </div>
                                <div class="row product-description">' . nl2br($row['description']) .
                                      '
                                </div></section></section>';
                }
            }
        }
    ?>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
    <!--  <script src="Javascripts/main.js"></script> -->
<?php
    include('Includes/footer.html');
?>
