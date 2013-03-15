<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/session.php'); ?>
<?php require_once('includes/database.php'); ?>
<?php require_once('includes/databaseobject.php'); ?>
<?php require_once('includes/user.php'); ?>
<?php 
  if (!$session->is_logged_in()) {
    redirect_to("index.php");
  }

  if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $contact_number = $_POST['contact_number'];

    $required_fields = array(
      'username', 'password', 'confirm_password', 'email', 
      'first_name', 'last_name', 'address', 'age', 'gender', 'contact_number');
    $verified = true;
    foreach ($required_fields as $field) {
      if (!isset($_POST[$field]) || empty($_POST[$field])) {
        $verified = false;
      }
    }

    // check for empty fields
    if (!$verified) {
      $message = "<strong>User Registration Failed!</strong>&nbsp;&nbsp;&nbsp; All fields are required.";
    } else {
      if (!ctype_alpha($first_name) && !ctype_alpha($last_name)) {
        $message = "<strong>User Registration Failed!</strong>&nbsp;&nbsp;&nbsp; First Name and Last Name must consist of letters only.";
      } else {
        if (strlen($username) > 10) {
          $message = "<strong>User Registration Failed!</strong>&nbsp;&nbsp;&nbsp; Username must be 10 characters.";
        } elseif (!preg_match("/^[a-zA-Z0-9_\-]+$/", $username)) {
          $message = "<strong>User Registration Failed!</strong>&nbsp;&nbsp;&nbsp; Username is invalid.";
        } else {
          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "<strong>User Registration Failed!</strong>&nbsp;&nbsp;&nbsp; Invalid Email.";
          } else {
            if ($password != $confirm_password) {
              $message = "<strong>User Registration Failed!</strong>&nbsp;&nbsp;&nbsp; Password did not match.";
            } else {
              $user = new User();
              $user->username = $username;
              $user->password = hash("sha512", $password);
              $user->email = $email;
              $user->first_name = $first_name;
              $user->last_name = $last_name;
              $user->address = $address;
              $user->age = $age;
              $user->gender = $gender;
              $user->contact_number = $contact_number;

              if ($user->save()) {
                $session->message("User succesfully registered.");
                redirect_to("create_user.php");
              } else {
                $message = "User was not registered.";
              }
            }
          }
        }
      }
    }

  } else {
      $username = "";
      $password = "";
      $confirm_password = "";
      $email = "";
      $first_name = "";
      $last_name = "";
      $address = "";
      $age = "";
      $gender = "";
      $contact_number = "";
    }
 ?>

<?php include_once('includes/layouts/header.php'); ?>
  
  <div class="container-fluid">
    <div class="row-fluid">

      <div class="span2">
        <div class="well sidebar-nav">
          <ul class="nav nav-tabs nav-stacked">
            <li><a href="home.php"><i class="icon-home icon-white"></i>&nbsp;&nbsp;Home</a></li>
            <li><a href="inventory.php"><i class="icon-list icon-white"></i>&nbsp;&nbsp;Inventory</a></li>
            <li><a href="products.php"><i class="icon-barcode icon-white"></i>&nbsp;&nbsp;Products</a></li>
            <li><a href="sales.php"><i class="icon-tag icon-white"></i>&nbsp;&nbsp;Sales</a></li>
            <li><a href="purchase_order.php"><i class="icon-shopping-cart icon-white"></i>&nbsp;&nbsp;Purchase Order</a></li>
            <li class="active"><a href="#"><i class="icon-user icon-white"></i>&nbsp;&nbsp;Users</a></li>
          </ul>
        </div><!--/.well -->
      </div><!--/span-->

      <div class="span10">
        <div class="row-fluid content-header">
          <h1>Users</h1>
          <ul class="breadcrumb">
            <li><a href="home.php">Home</a> <span class="divider">/</span></li>
            <li><a href="admin_users.php">Users</a></li>
          </ul>
        </div> <!-- end of content-header -->

        <div class="row-fluid content-main">

          <?php output_message($message); ?>

          <ul class="nav nav-tabs">
            <li><a href="admin_users.php">Admin Users</a></li>
            <li class="active"><a href="create_user.php">Add User</a></li>
          </ul>

          <div class="tabb">
            <div class="box-header">
              <h5><i class="icon-plus-sign"></i><span class="break"></span> Add Admin User</h5>
            </div>

            <form action="create_user.php" method="post" class="create-user">
              <table id="personal_info">
                <thead>
                  <tr>
                    <td colspan="2"><h4>Personal Information</h4></td>
                  </tr>
                </thead>

                <tbody>
                  <tr>
                    <td><label>First Name</label></td>
                    <td><input type="text" name="first_name" value="<?php echo htmlentities($first_name); ?>"></td>
                  </tr>

                  <tr>
                    <td><label>Last Name</label></td>
                    <td><input type="text" name="last_name" value="<?php echo htmlentities($last_name); ?>"></td>
                  </tr>

                  <tr>
                    <td><label>Address</label></td>
                    <td><textarea name="address" cols="30" rows="4"><?php echo htmlentities($address); ?></textarea></td>
                  </tr>

                  <tr>
                    <td><label>Age</label></td>
                    <td><input type="number" name="age" value="<?php echo htmlentities($age); ?>"></td>
                  </tr>

                  <tr>
                    <td><label>Gender</label></td>
                    <td>
                      <select name="gender" class="input-small">
                        <option value="male">Male</option>
                        <option value="female">female</option>
                      </select>
                    </td>
                  </tr>

                  <tr>
                    <td><label>Contact Number</label></td>
                    <td><input type="number" name="contact_number" value="<?php echo htmlentities($contact_number); ?>"></td>
                  </tr>
                </tbody>
              </table> <!-- end of table#personal_info -->

              <table id="account_info">
                <thead>
                  <tr>
                    <td colspan="2"><h4>Account Information</h4></td>
                  </tr>
                </thead>

                <tbody>
                  <tr>
                    <td><label>Username</label></td>
                    <td><input type="text" name="username" value="<?php echo htmlentities($username); ?>"></td>
                  </tr>
              
                  <tr>
                    <td><label>Password</label></td>
                    <td><input type="password" name="password"></td>
                  </tr>

                  <tr>
                    <td><label>Confirm Password</label></td>
                    <td><input type="password" name="confirm_password"></td>
                  </tr>

                  <tr>
                    <td><label>Email Address</label></td>
                    <td><input type="text" name="email" value="<?php echo htmlentities($email); ?>"></td> 
                  </tr>
                </tbody>
              </table> <!-- end of table#account_info -->


              <div id="submit_button">
                <input type="submit" name="submit" class="btn btn-primary btn-large" value="Submit">
              </div>

            </form>
          </div> <!-- end of tab-pane -->

        </div> <!-- end of row-fluid -->
        
      </div><!--/span-->
    </div><!--/row-->

  </div><!--/.fluid-container-->
    
<?php include_once('includes/layouts/footer.php'); ?>