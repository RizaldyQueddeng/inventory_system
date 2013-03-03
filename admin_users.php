<?php require_once('includes/functions.php'); ?>
<?php require_once('includes/session.php'); ?>
<?php require_once('includes/database.php'); ?>
<?php require_once('includes/databaseobject.php'); ?>
<?php require_once('includes/user.php'); ?>
<?php 
  if (!$session->is_logged_in()) {
    redirect_to("index.php");
  }

 ?>

<?php include_once('includes/header.php'); ?>
  <body>

    <div class="navbar navbar-inverse navbar-static-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">DPoint Inventory System</a>
          <div class="nav-collapse collapse">
            <ul class="nav pull-right">
              <li class="dropdowm">
                <a href="#user" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user icon-white"></i>&nbsp;&nbsp;Account Settings&nbsp;&nbsp;<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#"><i class="icon-cog"></i>&nbsp;&nbsp;Profile</a></li>
                  <li><a href="logout.php"><i class="icon-off"></i>&nbsp;&nbsp;Logout</a></li>
                </ul>
              </li>
            </ul>
            <!-- <ul class="nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>
            </ul> -->
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span2">
          <div class="well sidebar-nav">
            <ul class="nav nav-tabs nav-stacked">
              <li><a href="home.php"><i class="icon-home icon-white"></i>&nbsp;&nbsp;Inventory</a></li>
              <li><a href="products.php"><i class="icon-barcode icon-white"></i>&nbsp;&nbsp;Products</a></li>
              <li><a href="#"><i class="icon-tag icon-white"></i>&nbsp;&nbsp;Sales</a></li>
              <li><a href="#"><i class="icon-shopping-cart icon-white"></i>&nbsp;&nbsp;Orders</a></li>
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

            <div class="tabbable">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#user_list" data-toggle="tab">Admin Users</a></li>
                <li><a href="#add_user" data-toggle="tab">Add User</a></li>
              </ul>
              <div class="tab-content">

                <div class="tab-pane active" id="user_list">
                  <table class="table table-striped table-bordered user-table">
                    <thead class="btn-success">
                      <th>
                        <input type="checkbox">&nbsp;&nbsp; All
                      </th>
                      <th>Username</th>
                      <th>Full Name</th>
                      <th>Gender</th>
                      <th>Contact Number</th>
                      <th>Actions</th>
                    </thead>
                    <tbody>
                      <?php 
                        $users = User::find_all();
                        foreach ($users as $user) {
                          echo "<tr><td>";
                          echo "<input type='checkbox'>";
                          echo "</td><td>";
                          echo $user->username;
                          echo "</td><td>";
                          echo $user->full_name();
                          echo "</td><td>"; 
                          echo $user->gender;
                          echo "</td><td>";
                          echo $user->contact_number;
                          echo "</td><td>";
                          echo "<div class='btn-group'>";
                          echo "<a href='#' class='btn'><i class='icon-pencil'></i></a>";
                          echo "<a href='#' class='btn'><i class='icon-trash'></i></a>";
                          echo "</div>";
                          echo "</td></tr>";
                        }
                        
                       ?>
                    </tbody>
                  </table>
                </div> <!-- end of tab-pane -->

                <div class="tab-pane tabbable-with-border" id="add_user">
                  <form action="create_user.php" method="post" class="form-horizontal add-item">
                    <div class="box-header">
                      <h5><i class="icon-plus-sign"></i><span class="break"></span> Add Admin User</h5>
                    </div>

                    <div class="control-group">
                      <label for="username" class="control-label">Username</label>
                      <div class="controls">
                        <input type="text" name="username" id="username">
                      </div>
                    </div> <!-- end of control-group -->

                    <div class="control-group">
                      <label for="password" class="control-label">Password</label>
                      <div class="controls">
                        <input type="text" name="password" id="password">
                      </div>
                    </div> <!-- end of control-group -->

                    <div class="control-group">
                      <label for="first_name" class="control-label">First Name</label>
                      <div class="controls">
                        <input type="text" name="first_name" id="first_name">
                      </div>
                    </div> <!-- end of control-group -->

                    <div class="control-group">
                      <label for="last_name" class="control-label">Last Name</label>
                      <div class="controls">
                        <input type="text" name="last_name" id="last_name">
                      </div>
                    </div> <!-- end of control-group -->

                    <div class="control-group">
                      <label for="gender" class="control-label">Gender</label>
                      <div class="controls">
                        <select name="gender" class="input-small">
                          <option value="male">Male</option>
                          <option value="female">female</option>
                        </select>
                      </div>
                    </div> <!-- end of control-group -->

                    <div class="control-group">
                      <label for="contact_number" class="control-label">Contact Number</label>
                      <div class="controls">
                        <input type="text" name="contact_number" id="contact_number">
                      </div>
                    </div> <!-- end of control-group -->

                    <div class="control-group">
                      <div class="controls">
                        <input type="submit" name="submit" class="btn btn-primary" value="Add">
                      </div>
                    </div>

                  </form>
                </div> <!-- end of tab-pane -->

               
              </div>
            </div>

          </div>
          
        </div><!--/span-->
      </div><!--/row-->

    </div><!--/.fluid-container-->
    
<?php include_once('includes/footer.php'); ?>
