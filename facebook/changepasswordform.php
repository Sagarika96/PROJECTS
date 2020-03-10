<?php
    $lifetime = 15 * 60;
    $path = "/labs/lab6";
    $domain = "madhavans1.com";
    $secure = TRUE;
    $httponly = TRUE;
    session_set_cookie_params($lifetime,$path,$domain,$secure,$httponly);
    session_start();
    require "session_auth.php";
    $rand = bin2hex(openssl_random_pseudo_bytes(16));
    $_SESSION["nocsrftoken"] = $rand;
?>
<html>
      <h1>Change Password</h1>
      <h4>Secad-s19-madhavans1 Lab 6.2 SAGARIKA MADHAVAN</h4>
<?php
  //some code here
  echo "Current time: " . date("Y-m-d h:i:sa")
?>
          <form action="changepassword.php" method="POST" class="form login">
            <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>" />
                Username: <!--<input type="text" class="text_field" name="username" /> /-->
                <?php echo htmlentities($_SESSION["username"]); ?>
                <br>
                New Password: <input type="password" class="text_field" name="newpassword" /> <br>
                <button class="button" type="submit">
                  Change Password
                </button>
		<a href="index.php">Go to Home</a>
          </form>
  </html>
