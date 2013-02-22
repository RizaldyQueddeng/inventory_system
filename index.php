<?php 
  
  require_once("includes/database.php");


  if (isset($_POST['submit'])) {

    if (!strlen($_POST['username']) || !strlen($_POST['password'])) {
      $message = "Both fields are required!";
    } else {

      // clean data to prevent SQL injection
      $username = trim(mysql_real_escape_string($_POST['username']));
      $password = trim(mysql_real_escape_string($_POST['password']));
      $password = md5($password);

      // check data to see if username and password exist
      $query = "SELECT id, username
          FROM user
          WHERE username='$username'
          AND password='$password' LIMIT 1";
      $result = mysql_query($query);
      if (mysql_num_rows($result) == 1) {
        // username and password authenticated 
        // and only 1 match
        $found_user = mysql_fetch_array($result);
        $_SESSION['user_id'] = $found_user['id'];
        $_SESSION['username'] = $found_user['username'];

        header("location: home.php");
      } else {
        $message = "<strong>Login Failed!</strong> username and password did not match!";
      }
    }

  } else {
    $username="";
    $password="";
  }

 ?>

<?php include_once('includes/header.php'); ?>

  <body id="login">

    <div class="container">

      <h3>Inventory System</h3>
      <br>

      <form action="index.php" method="post" class="form-signin">
        
        <?php 
          if (!empty($message)) {
            $alert_message = "<div id='errorMessage' class='alert alert-success alert-error' data-alert='alert'><br>";
            $alert_message .= "<a class='close' data-dismiss='alert' href='#'>x</a>";
            $alert_message .= "<p>". $message ."</p>";
            $alert_message .= "</div>";

            echo $alert_message;
          } else {
            echo "<p class='form-signin-heading'>Sigin in with username and password to continue</p>";
          }
         ?>

        <div class="input-prepend">
          <span class="add-on">
            <i class="icon-user"></i>
          </span>
          <input type="text" class="input-large" placeholder="Username" name="username">
        </div>

        <div class="input-prepend">
          <span class="add-on">
            <i class="icon-lock"></i>
          </span>
          <input type="password" class="input-large" placeholder="Password" name="password">
        </div>

        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <input class="btn btn-inverse" type="submit" value="Sign in" name="submit">
      </form>

    </div> <!-- /container -->

<?php include_once('includes/footer.php') ?>