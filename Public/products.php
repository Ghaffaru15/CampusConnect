<?php
  $page_title = 'Products Catalog';
  include('Includes/header.html');
  include('Includes/config.inc.php');
?>


  <div class="buycont">
    <h1>Products & Services</h1>
    <div class="buyfilters">
      <form class="" action="" method="post" id="searchform">
        <input type="text" name="search" value="" placeholder="what are you looking for?">
        <input type="submit" name="" value="Search" id="searchbutton">
      </form>
      <form action="" method="post" id="categoryform">
        <select class="catdropdown" name="category" onchange="this.form.submit()" >
          <option value="">Choose Category</option>
          <option value="Jewellery">Jewellery</option>
          <option value="Electronics">Electronics</option>
          <option value="Fashion">Fashion</option>
          <option value="Stationery">Stationery</option>
          <option value="Food">Food & Drinks</option>
          <option value="Services">Services</option>
        </select>
      </form>
      <form action="" method="post" id="filter">
        <select class="schseldropdown" name="buyfilters" onchange="this.form.submit()" >
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
      </form>
    </div>
  </div>
<?php
require(MySQL);

$query = "SELECT users.user_id, contact, product_id, university, product_name, price,image_name,description FROM users,products WHERE
 users.user_id=products.user_id ORDER BY date_entered DESC";
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  if (isset($_POST['search'])){
  $item = trim(strip_tags($_POST['search']));
  $item = mysqli_real_escape_string($db,$item);

    $query = "SELECT users.user_id, contact, university, product_id, product_name, price,image_name,description FROM users,products WHERE
    users.user_id=products.user_id AND product_name LIKE '%$item%' ORDER BY date_entered DESC";
  }
  if (isset($_POST['buyfilters'])){
  $filter = trim($_POST['buyfilters']);
  $query = "SELECT users.user_id, contact, university,category, product_id, product_name, price,image_name,description FROM users,products WHERE
 users.user_id=products.user_id AND university='$filter' ORDER BY date_entered DESC";
  }

  if (isset($_POST['category'])){
    $category = trim($_POST['category']);
    $query = "SELECT users.user_id, contact, university, category, product_id,product_name, price, image_name, description FROM users, products where
    users.user_id=products.user_id AND category='$category' ORDER BY date_entered DESC";
  }
}
echo '
<div class="productsdisplay">';

 $result = mysqli_query($db,$query);
if (mysqli_num_rows($result) > 0){
  while($row=mysqli_fetch_assoc($result)){
    echo '
        <div class="productinfo">
        <img src="show_image.php?image=' . $row['product_id'] . '&name=' . urlencode($row['image_name']) . '" />
        <h4 class="productname"> ' . $row['product_name'] . '</h4>
        <h4 class="productprice"> ¢' . $row['price'] . '</h4>
        <h4 class="sellerlocation"> ' . $row['university'] . '</h4>
      </div>';
}
echo '</div>';
    }
?>

<?php
  include('Includes/footer.html');
?>
