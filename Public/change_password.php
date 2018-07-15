<?php

	include('Includes/config.inc.php')
	;
	$page_title = 'Change Password';

	include('Includes/header.html');
	if (isset($_SESSION['user_id'])){

      $user_id = $_SESSION['user_id'];

	echo '
  <section class="row sign-up-container">
      <h2>Change Password!</h2>
      <form method="post" action="#" class="sign-up-form">
          <div class="row">
              <div class="col span-1-of-3">
                  <label for="current_password"><span>C</span>urrent<span> P</span>assword:</label>
              </div>
              <div class="col span-2-of-3">
                  <input type="password" name="current_password" id="firstname">
 ';
 ?>
 <?php
     if ($_SERVER['REQUEST_METHOD'] == 'POST'){
             if (empty($_POST['current_password'])){
                             echo '<p style="color: #e67e22; font-size: 0.8em;">The current password field is required!</p>';
                       }

               }
 ?>
 <?php
             echo '
             </div>
         </div>

         <div class="row">
             <div class="col span-1-of-3">
                 <label for="pass-word"><span>N</span>ew<span> P</span>assword:</label>
             </div>
             <div class="col span-2-of-3">
                 <input type="password" name="new_password" id="password">
                   ';
 ?>
 <?php
               if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                 $new_pass = FALSE;
                         if (empty($_POST['new_password'])){
                               echo '<p style="color: #e67e22; font-size: 0.8em;">The new password field is required!</p>';
                         }
                         elseif (strlen($_POST['new_password']) < 8){
                            echo '<p style="font-size: 0.8em; color: #e67e22"> Your password should be more than 8 characters!</p>';
                            //$error[] = ' ';
                          }
                          else{
                              $new_pass = TRUE;
                          }

                 }
 ?>
 <?php
             echo '
             </div>
         </div>

         <div class="row">
             <div class="col span-1-of-3">
                 <label for="pass-word"><span>C</span>onfirm<span> P</span>assword:</label>
             </div>
             <div class="col span-2-of-3">
                 <input type="password" name="confirm_password" id="password">
                   ';
 ?>
 <?php
               if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                         if (empty($_POST['confirm_password'])){
                               echo '<p style="color: #e67e22; font-size: 0.8em;">The confirm password field is required!</p>';
                         }

                 }
 ?>
 <?php
 if ($_SERVER['REQUEST_METHOD'] == 'POST'){

   if (!empty($_POST['current_password']) && (!empty($_POST['new_password'])) && $new_pass){
      require(MySQL);

        $current_password = mysqli_real_escape_string($db, strip_tags(trim($_POST['current_password'])));

        $new_password = mysqli_real_escape_string($db, strip_tags(trim($_POST['new_password'])));

        $confirm_password = mysqli_real_escape_string($db, strip_tags(trim($_POST['confirm_password'])));

        $query = "SELECT pass FROM users WHERE user_id=$user_id";

        $result = mysqli_query($db,$query);

        if (mysqli_num_rows($result) == 1 ){
            $row = mysqli_fetch_assoc($result);

            if ((sha1($current_password) == $row['pass']) && ($new_password == $confirm_password)){
                $q = "UPDATE users SET pass=sha1('$new_password') WHERE user_id=$user_id";

                    $r = mysqli_query($db, $q);

                    if (mysqli_affected_rows($db) == 1)
                        echo '<p style="font-size: 0.8em; color:#e67e22;"> Your password was changed successfully</p>';
                    else
                        echo '<p style="font-size: 0.8em; color: #e67e22;"> Could not change password,  </p>';
            }
            else{
                echo '<p style="font-size: 0.8em; color: #e67e22;"> Either a wrong current password, or new password mismatch</p>';
            }
        }
        else{
            echo'<p style="font-size: 0.8em; color: #e67e22"> Could perform the query</p>';
        }
  }

}
?>
 <?php echo '
      </div>
      </div>
  <input type="submit" name="" value="Change" id="submit-button">

</form>
</section>
';
?>

<?php

	include('Includes/footer.html');
}
else{
	 header("Location: index.php");
}
  ?>
