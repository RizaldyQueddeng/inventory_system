<?php 
  
  require_once("../includes/database.php");

  if (isset($database)) {
    echo "true";
  } else {
    echo "false";
  }
  echo "<br />";

  echo $database->escape_value("It's working?" . "<br />");

  // $sql = "INSERT INTO users (id, username, password, first_name, last_name) ";
  // $sql .= "VALUES (2, 'khel', 'admin', 'mykhel', 'raagas')";
  // $result = $database->query($sql);

  $sql = "SELECT * FROM users WHERE id = 2";
  $result_set = $database->query($sql);
  $found_user = $database->fetch_array($result_set);
  echo $found_user['username'];

 ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Inventory - Signin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet/less" type="text/css" href="css/style.less" />
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- less compiler -->
    <script src="js/less.js" type="text/javascript"></script>


    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="ico/favicon.png">
  </head>

  <body id="login">

    <div class="container">

      <h3>Inventory System</h3>
      <br>

      <form class="form-signin">
        <p class="form-signin-heading">Sigin in with username and password to continue</p>

        <div class="input-prepend">
          <span class="add-on">
            <i class="icon-user"></i>
          </span>
          <input type="text" class="input-large" placeholder="Username">
        </div>

        <div class="input-prepend">
          <span class="add-on">
            <i class="icon-lock"></i>
          </span>
          <input type="password" class="input-large" placeholder="Password">
        </div>

        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <input class="btn btn-inverse" type="submit" value="Sign in">
      </form>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
