<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/session.php'); ?>
<?php require_once('includes/database.php'); ?>
<?php require_once('includes/user.php'); ?>
<?php 
  if (!$session->is_logged_in()) {
    redirect_to("index.php");
  }

  // 1. the current page number ($current_page)
  $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

  // 2. records per page ($per_page)
  $per_page = 10;

  if (isset($_POST['search_submit'])) {

    $keyword = $_POST['keyword'];

    // 3. total record count ($total_count)
    $total_count = User::count_search($keyword);

    // Use pagination to find images
    $pagination = new Pagination($page, $per_page, $total_count);

    $sql = "SELECT * FROM users ";
    $sql .= "WHERE first_name LIKE '%" .$keyword. "%' ";
    $sql .= "OR last_name LIKE '%" .$keyword. "%' ";
    $sql .= "LIMIT {$per_page} ";
    $sql .= "OFFSET {$pagination->offset()}";

    $users = User::find_by_sql($sql);
    if (!$users) {
      $message = "No Records Found.";
    }

  } else {

    // 3. total record count ($total_count)
    $total_count = User::count_all();

    // Use pagination to find images
    $pagination = new Pagination($page, $per_page, $total_count);

    // Instead of finding all records, just find the records for this page

    $query = "SELECT * FROM users ";
    $query .= "LIMIT {$per_page} ";
    $query .= "OFFSET {$pagination->offset()}";
    $users = User::find_by_sql($query);
      
  }

  if (isset($_POST['edit_submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $contact_number = $_POST['contact_number'];
    $id = $_POST['id'];

    $required_fields = array(
      'username', 'email', 'first_name', 'last_name', 'address', 'age', 'gender', 'contact_number', 'id');
    $verified = true;
    foreach ($required_fields as $field) {
      if (!isset($_POST[$field]) || empty($_POST[$field])) {
        $verified = false;
      }
    }

    // check for empty fields
    if (!$verified) {
      $message = "<strong>Update User Failed!</strong>&nbsp;&nbsp;&nbsp; All fields are required.";
    } else {
      if (!ctype_alpha($first_name) && !ctype_alpha($last_name)) {
        $message = "<strong>Update User Failed!</strong>&nbsp;&nbsp;&nbsp; First Name and Last Name must consist of letters only.";
      } else {
        if (strlen($username) > 10) {
          $message = "<strong>Update User Failed!</strong>&nbsp;&nbsp;&nbsp; Username must be 10 characters.";
        } elseif (!preg_match("/^[a-zA-Z0-9_\-]+$/", $username)) {
          $message = "<strong>Update User Failed!</strong>&nbsp;&nbsp;&nbsp; Username is invalid.";
        } else {
          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "<strong>Update User Failed!</strong>&nbsp;&nbsp;&nbsp; Invalid Email.";
          } else {
            $user = new User();
            $user->username = $username;
            $user->email = $email;
            $user->first_name = $first_name;
            $user->last_name = $last_name;
            $user->address = $address;
            $user->age = $age;
            $user->gender = $gender;
            $user->contact_number = $contact_number;
            $user->id = $id;

            if ($user->update_userinfo()) {
              $session->message("User information succesfully updated.");
              redirect_to("admin_users.php");
            } else {
              $message = "User information was not updated.";
            }
          }
        }
      }
    }

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

          <div class="row-fluid">
            <div class="span8">
              <ul class="nav nav-tabs">
                <li class="active"><a href="admin_users.php">Admin Users</a></li>
                <li><a href="create_user.php">Add User</a></li>
              </ul>
            </div>

            <div class="span3">
              <form action="admin_users.php" method="post" class="form-search list">
                <div class="input-append">
                  <input type="text" name="keyword" class="input-medium search-query">
                  <input type="submit" name="search_submit" class="btn btn-primary" value="Search">
                </div>
              </form>
            </div>
          </div> <!-- end of row-fluid -->

          <table class="table table-striped table-bordered user-table">
            <thead class="btn-success">
              <th>ID</th>
              <th>Username</th>
              <th>Full Name</th>
              <th>Email</th>
              <th>Contact Number</th>
              <th>Actions</th>
            </thead>
            <tbody>
              <?php 
                foreach ($users as $user) {
                  echo "<tr><td>";
                  echo $user->id;
                  echo "</td><td>";
                  echo $user->username;
                  echo "</td><td>";
                  echo $user->full_name();
                  echo "</td><td>"; 
                  echo $user->email;
                  echo "</td><td>";
                  echo $user->contact_number;
                  echo "</td><td>";
                  echo "<div class='btn-group'>";
                  echo "<a href='#view{$user->id}' role='button' class='btn' data-toggle='modal'><i class='icon-eye-open'></i></a>";
                  echo "<a href='#edit{$user->id}' role='button' class='btn' data-toggle='modal'><i class='icon-pencil'></i></a>";
                  echo "<a href='delete_user.php?id=". $user->id ."' class='btn tooltip_dialog' data-toggle='tooltip' data-placement='left' title='Delete Record' onclick='return confirmAction()'><i class='icon-trash'></i></a>";
                  echo "</div>";
                  echo "</td></tr>";
                }
               ?>
            </tbody>
          </table>

          <a href="admin_users.php" class="btn btn-large left tooltip_dialog" data-toggle="tooltip" data-placement="right" title="Refresh Admin Users List"><i class="icon-refresh"></i></a>

          <div class="pagination pagination-right">
            <ul>
              <?php 
                if ($pagination->total_pages() > 1) {
                  
                  if ($pagination->has_previous_page()) {
                    echo "<li><a href=\"admin_users.php?page=";
                    echo $pagination->previous_page();
                    echo "\">Previous</a></li>";
                  }

                  for ($i=1; $i <= $pagination->total_pages(); $i++) { 
                    if ($i == $page) {
                      echo "<li class='active'><span>{$i}</span></li>";
                    } else {
                      echo "<li><a href=\"admin_users.php?page={$i}\">{$i}</a></li>";
                    }
                  }

                  if ($pagination->has_next_page()) {
                    echo "<li><a href=\"admin_users.php?page=";
                    echo $pagination->next_page();
                    echo "\">Next</a></li>";
                  }
                }
               ?>
            </ul>
          </div> <!-- end of pagination -->

          <?php foreach($users as $user): ?>
            <div id="view<?php echo $user->id; ?>" class="modal hide fade user-info" tabindex="1" role="dialog" aria-labelledby="view_details" aria-hidden="true">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h3 id="view_details">Admin Information Details</h3>
              </div>
              <div class="modal-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th colspan="2">Account Information</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Username</td>
                      <td><?php echo $user->username; ?></td>
                    </tr>
                    <tr>
                      <td>Full Name</td>
                      <td><?php echo $user->full_name(); ?></td>
                    </tr>
                    <tr>
                      <td>Address</td>
                      <td><?php echo $user->address; ?></td>
                    </tr>
                    <tr>
                      <td>Age</td>
                      <td><?php echo $user->age; ?></td>
                    </tr>
                    <tr>
                      <td>Gender</td>
                      <td><?php echo $user->gender; ?></td>
                    </tr>
                    <tr>
                      <td>Contact Number</td>
                      <td><?php echo $user->contact_number; ?></td>
                    </tr>
                    <tr>
                      <td>Email Address</td>
                      <td><?php echo $user->email; ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
              </div>
            </div> <!-- end of modal -->
          <?php endforeach; ?>

          <?php foreach($users as $user): ?>
            <div id="edit<?php echo $user->id; ?>" class="modal hide fade user-edit" tabindex="1" role="dialog" aria-labelledby="edit_user" aria-hidden="true">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h3 id="edit_user">Admin Information Details</h3>
              </div>
              <div class="modal-body">
                <form action="admin_users.php" method="post" class="create-user">

                  <table id="personal_info">
                    <thead>
                      <tr>
                        <td colspan="2"><h4>Personal Information</h4></td>
                      </tr>
                    </thead>

                    <tbody>
                      <tr>
                        <td><label>First Name</label></td>
                        <td><input type="text" name="first_name" value="<?php echo $user->first_name; ?>"></td>
                      </tr>
                      <tr>
                        <td><label>Last Name</label></td>
                        <td><input type="text" name="last_name" value="<?php echo $user->last_name; ?>"></td>
                      </tr>
                      <tr>
                        <td><label>Address</label></td>
                        <td><textarea name="address" cols="30" rows="4"><?php echo $user->address; ?></textarea></td>
                      </tr>
                      <tr>
                        <td><label>Age</label></td>
                        <td><input type="number" name="age" value="<?php echo $user->age; ?>"></td>
                      </tr>
                      <tr>
                        <td><label>Gender</label></td>
                        <td>
                          <select name="gender" class="input-small">
                            <?php 
                              if ($user->gender == "male") {
                                echo "<option selected='selected' value='male'>Male</option>";
                                echo "<option value='female'>female</option>";
                              } elseif ($user->gender == "female") {
                                echo "<option value='male'>Male</option>";
                                echo "<option selected='selected' value='female'>female</option>";
                              }
                             ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td><label>Contact Number</label></td>
                        <td><input type="number" name="contact_number" value="<?php echo $user->contact_number; ?>"></td>
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
                        <td><input type="text" name="username" value="<?php echo $user->username; ?>"></td>
                      </tr>
                      <tr>
                        <td><label>Email Address</label></td>
                        <td><input type="text" name="email" value="<?php echo $user->email; ?>"></td> 
                      </tr>
                      <tr>
                        <td></td>
                        <td><input type="text" name="id" value="<?php echo $user->id; ?>" style="visibility: hidden"></td>
                      </tr>
                    </tbody>
                  </table> <!-- end of table#account_info -->


                  <div id="submit_button">
                    <input type="submit" name="edit_submit" class="btn btn-primary" value="Submit">
                  </div>

                </form>
              </div> <!-- end of modal-body -->
              <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
              </div>
            </div> <!-- end of modal -->
          <?php endforeach; ?>

        </div> <!-- end of row-fluid -->
        
      </div><!--/span-->
    </div><!--/row-->

  </div><!--/.fluid-container-->

<?php include_once('includes/layouts/footer.php'); ?>