<?php
    $page_title = 'Sign up';
    include('Includes/header.html');
    include('Includes/config.inc.php');
    require(MySQL);
?>


<?php
  if (isset($_SESSION['user_id'])){
    $url = BASE_URL . 'index.php';
      header("Location: $url");
  }
  else{
    echo '

    <section class="row sign-up-container">
      <h2>SIGN UP!</h2>
        <form method="post" action="" class="sign-up-form">
            <div class="row">
                <div class="col span-1-of-3">
                    <label for="first-name"><span>F</span>irst <span>N</span>ame:</label>
                </div>
                <div class="col span-2-of-3">
                    <input type="text" name="first_name" id="firstname">'; ?>
        <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                    if (empty($_POST['first_name'])){ //Empty inputs
                        echo '<p style="color: #e67e22; font-size: 0.8em;">The first name field is required!</p>';
                    }
                    elseif (!ctype_alpha($_POST['first_name'])){ //Numeric inputs
                        echo '<p style="color: #e67e22; font-size: 0.8em;">Invalid input!</p>';
                    }
                    else{ //Safe input
                        $fn = strip_tags(trim($_POST['first_name']));
                        $fn = mysqli_real_escape_string($db,$fn);
                    }
                }
        ?>
        <?php
        echo '

        </div>
    </div>
    <div class="row">
        <div class="col span-1-of-3">
            <label for="surname"><span>S</span>urname:</label>
        </div>
        <div class="col span-2-of-3">
            <input type="text" name="last_name" id="surname">'; ?>

        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                if (empty($_POST['last_name'])){
                    echo '<p style="color: #e67e22; font-size: 0.8em";>The surname field is required!</p>';
                }
                elseif (!ctype_alpha($_POST['last_name'])){
                    echo '<p style="color: #e67e22; font-size: 0.8em";> Invalid input!</p>';
                }
                else{
                    $ln = strip_tags(trim($_POST['last_name']));
                    $ln = mysqli_real_escape_string($db,$ln);
                }
            }
        ?>
        <?php

        echo '
         </div>
      </div>
      <div class="row">
          <div class="col span-1-of-3">
              <label for="email-address"><span>E</span>mail <span>A</span>ddress:</label>
          </div>
          <div class="col span-2-of-3">
             <input type="email" name="email" id="email-address">';

        ?>
        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){

                if (empty($_POST['email'])){
                    echo '<p style="color: #e67e22; font-size: 0.8em";>Email field is required!</p>';
                }
                elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                    echo '<p style="color: #e67e22; font-size: 0.8em";>Invalid email format</p>';
                }
                else{

                    $e = strip_tags(trim($_POST['email']));
                  //  $email = mysqli_real_escape_string($db,$e);
                    $query = "SELECT user_id FROM users where email='$e'";

                    $result = mysqli_query($db, $query);

                    if (mysqli_num_rows($result) == 0){
                        $email = mysqli_real_escape_string($db,$e);
                    }
                    else{
                        echo '<p style="color: #e67e22; font-size: 0.8em";>Email is already registered</p>';
                    }
                }
            }
        ?>
        <?php
            echo '</div>
        </div>
        <div class="row">
            <div class="col span-1-of-3">
                <label for="contact-number"><span>C</span>ontact <span>N</span>umber:</label>
            </div>
            <div class="col span-2-of-3">
                <input type="text" name="contact" id="contact-number">';
        ?>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            if (empty($_POST['contact'])){
                echo '<p style="color: #e67e22; font-size: 0.8em";>The contact field is required!</p>';
            }
            elseif (ctype_alpha($_POST['contact'])){
                echo '<p style="color: #a40101; font-size: 12px";> Invalid input!</p>';
            }
            else{
                $ct = strip_tags(trim($_POST['contact']));
                $ct = mysqli_real_escape_string($db,$ct);
            }
        }
         ?>
        <?php
        echo '
        </div>
    </div>
    <div class="row">
        <div class="col span-1-of-3">
            <label for="pass-word"><span>P</span>assword:</label>
        </div>
        <div class="col span-2-of-3">
            <input type="password" name="password1" id="password">';
                      ?>
                 <?php
                   if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                     if (empty($_POST['password1'])){
                          echo '<p style="color: #e67e22; font-size: 0.8em";>Password field is required!</p>';
                     }
                    elseif (strlen($_POST['password1']) < 8){
                       echo '<p style="font-size: 0.8em; color: #e67e22"> You password should be more than 8 characters!</p>';
                       //$error[] = ' ';
                     }
                     else{
                        $pass = trim($_POST['password1']);
                     }
                   }
                 ?>
                 <?php echo '</div>
             </div>
             <div class="row">
                 <div class="col span-1-of-3">
                     <label for="repeat-password"><span>R</span>epeat <span>P</span>assword:</label>
                 </div>
                 <div class="col span-2-of-3">
                     <input type="password" name="password2">'; ?>
                  <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                            if (empty($_POST['password2'])){
                                echo '<p style="color: #e67e22; font-size: 0.8em;">Please confirm password!</p>';
                            }
                            elseif (trim($_POST['password1'] != trim($_POST['password2']))){
                                echo '<p style="color: #e67e22; font-size: 0.8em;">Password do not match!</p>';
                            }
                            else{
                                $p = strip_tags(trim($_POST['password2']));
                                $p = mysqli_real_escape_string($db,$p);
                            }
                        }
                   ?>
                   <?php echo '
                   </div>
               </div>
               <input type="submit" name="" value="Register!" id="submit-button">

           </form>
       </section>';
  }
?>
<?php
    if (isset($fn,$ln,$email,$p,$ct)){
			//Checking for valid email address

			//	$activation = md5(uniqid(rand(),true));
				$q = "INSERT into users(first_name,last_name,email,pass,contact,date_registered) VALUES ('$fn', '$ln','$email', sha1('$p'),'$ct', NOW())";

				$r = mysqli_query($db,$q) ;

				if (mysqli_affected_rows($db) == 1){
				//	$body = "Thank you for registering at Campus Connect, To activate your account, please click <br />";
					//$link = BASE_URL . 'activate.php?x='. urlencode($e) . "&y=$activation";
					//mail($trimmed['email'],   'Registeration Confirmation', $link ,'From: admin@gmail.com');
		//			echo $body . '<a href="' . $link . '"> here </a>';
        $url = BASE_URL . "login.php?signup=1";
        header("Location: $url");

				}
				else{
					echo '<p class="error">You could not be registered due to system error. We apologize for any inconvenience </p>';
				}
			}


		else{
		//	echo '<p class="error"> Please try again </p>';
		}

		mysqli_close($db);

?>
<?php
  include('Includes/footer.html');
?>
