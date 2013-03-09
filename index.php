<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/database.php'); ?>
<?php require_once('includes/session.php'); ?>
<?php require_once('includes/user.php'); ?>
<?php 

  if ($session->is_logged_in()) {
    redirect_to("home.php");
  }

  if (isset($_POST['submit'])) {
    
    $username = trim($_POST['username']);
    $password = trim(md5($_POST['password']));

    if (!strlen($username) || !strlen($password)) {
      $message = "Both fields are required!";
    } else {
       // Check database if username and password exist
      $found_user = User::authenticate($username, $password);
      
      if ($found_user) {
        $session->login($found_user);
        redirect_to("home.php");
      } else {
        // username and password combination doesn't exist in database
        $message = "Username and Password did not match!";
      }
    }

  } else {
    $username = "";
    $password = "";
  }
?>



<?php include_once('includes/header.php'); ?>

  <body id="login">

    <div class="container">

      <h3>Dpoint Inventory System</h3>
      <br>

      <form action="index.php" method="post" class="form-signin">
        <p class='form-signin-heading'>Sigin in with username and password to continue</p>

        <?php output_message($message); ?>

        <div class="input-prepend">
          <span class="add-on">
            <i class="icon-user"></i>
          </span>
          <input type="text" class="input-large" placeholder="Username" name="username" maxlength="30" value="<?php htmlentities($username); ?>">
        </div>

        <div class="input-prepend">
          <span class="add-on">
            <i class="icon-lock"></i>
          </span>
          <input type="password" class="input-large" placeholder="Password" name="password" maxlength="30" value="<?php htmlentities($password); ?>">
        </div>

        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <input class="btn btn-inverse" type="submit" value="Sign in" name="submit">
      </form>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
  </body>
</html>

<?php if(isset($database)) { $database->close_connection(); } ?>