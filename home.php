<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Inventory - Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="public/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet/less" type="text/css" href="public/css/style.less" />
    <link href="public/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- less compiler -->
    <script src="public/js/less.js" type="text/javascript"></script>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="public/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="public/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="public/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="public/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="public/ico/favicon.png">
  </head>

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
                  <li><a href="#"><i class="icon-off"></i>&nbsp;&nbsp;Logout</a></li>
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
              <li class="active"><a href="#"><i class="icon-home icon-white"></i>&nbsp;&nbsp;Inventory</a></li>
              <li><a href="#"><i class="icon-barcode icon-white"></i>&nbsp;&nbsp;Products</a></li>
              <li><a href="#"><i class="icon-tag icon-white"></i>&nbsp;&nbsp;Sales</a></li>
              <li><a href="#"><i class="icon-shopping-cart icon-white"></i>&nbsp;&nbsp;Orders</a></li>
              <li><a href="#"><i class="icon-user icon-white"></i>&nbsp;&nbsp;Users</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->

        <div class="span10">
          <div class="row-fluid content-header">
            <h1>Inventory</h1>
            <ul class="breadcrumb">
              <li><a href="home.php">Home</a> <span class="divider">/</span></li>
              <li><a href="inventory.php">Inventory</a></li>
            </ul>
          </div> <!-- end of content-header -->

          <div class="row-fluid content-main">

            <div class="tabbable">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#inventory" data-toggle="tab">Inventory</a></li>
                <li><a href="#additem" data-toggle="tab">Add Item</a></li>
                <li><a href="#addproduct" data-toggle="tab">Add Product</a></li>
                <li><a href="#editprice" data-toggle="tab">Edit Price</a></li>
              </ul>
              <div class="tab-content">

                <div class="tab-pane active" id="inventory">
                  <table class="table table-striped table-bordered">
                    <thead class="btn-success">
                      <th>Date</th>
                      <th>Item</th>
                      <th>Quantity left</th>
                      <th>Quantity Sold</th>
                      <th>Price</th>
                      <th>Sales</th>
                      <th>Action</th>
                    </thead>
                    <tbody>
                      <tr>
                        <td>2013-02-09</td>
                        <td>DP IP 7309</td>
                        <td>10</td>
                        <td>5</td>
                        <td>10,000.00</td>
                        <td>50,000.00</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>2013-02-09</td>
                        <td>DP IP 7309</td>
                        <td>10</td>
                        <td>5</td>
                        <td>10,000.00</td>
                        <td>50,000.00</td>
                        <td></td>
                      </tr>
                    </tbody>
                  </table>
                </div> <!-- end of tab-pane -->

                <div class="tab-pane" id="additem">
                  <form action="#" method="post" class="form-horizontal add-item">
                    <div class="box-header">
                      <h5><i class="icon-plus-sign"></i><span class="break"></span> Add an Item to inventory</h5>
                    </div>

                    <div class="control-group">
                      <label for="productName" class="control-label">Product Name</label>
                      <div class="controls">
                        <select name="productname" id="productName">
                          <option value="#">IP Camera</option>
                          <option value="#">Analog Camera</option>
                        </select>
                      </div>
                    </div> <!-- end of control-group -->

                    <div class="control-group">
                      <label for="numberOfItem" class="control-label">Number of Item</label>
                      <div class="controls">
                        <input type="text" name="numberitem" id="numberOfItem">
                      </div>
                    </div> <!-- end of control-group -->

                    <div class="control-group">
                      <div class="controls">
                        <input type="submit" name="submit" class="btn btn-primary" value="Add">
                      </div>
                    </div>

                  </form>
                </div> <!-- end of tab-pane -->

                <div class="tab-pane" id="addproduct">
                  <form action="#" method="post" class="form-horizontal add-item">
                    <div class="box-header">
                      <h5><i class="icon-plus-sign"></i><span class="break"></span> Add a Product to inventory</h5>
                    </div>

                    <div class="control-group">
                      <label for="productName" class="control-label">Product Name</label>
                      <div class="controls">
                        <input type="text" name="productname" id="productName" placeholder="phone number">
                      </div>
                    </div> <!-- end of control-group -->

                    <div class="control-group">
                      <label for="price" class="control-label">Price</label>
                      <div class="controls">
                        <input type="text" name="price" id="price" placeholder="price">
                      </div>
                    </div> <!-- end of control-group -->

                    <div class="control-group">
                      <label for="quantity" class="control-label">Quantity</label>
                      <div class="controls">
                        <input type="text" name="quantity" id="quantity" placeholder="quantity">
                      </div>
                    </div> <!-- end of control-group -->

                    <div class="control-group">
                      <div class="controls">
                        <input type="submit" name="submit" class="btn btn-primary" value="Add">
                      </div>
                    </div>

                  </form>
                </div>
                <div class="tab-pane" id="editprice">
                  <p>Edit Price</p>
                </div>
              </div>
            </div>

          </div>
          
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; Company 2012</p>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="public/js/jquery.js"></script>
    <script src="public/js/bootstrap-transition.js"></script>
    <script src="public/js/bootstrap-alert.js"></script>
    <script src="public/js/bootstrap-modal.js"></script>
    <script src="public/js/bootstrap-dropdown.js"></script>
    <script src="public/js/bootstrap-scrollspy.js"></script>
    <script src="public/js/bootstrap-tab.js"></script>
    <script src="public/js/bootstrap-tooltip.js"></script>
    <script src="public/js/bootstrap-popover.js"></script>
    <script src="public/js/bootstrap-button.js"></script>
    <script src="public/js/bootstrap-collapse.js"></script>
    <script src="public/js/bootstrap-carousel.js"></script>
    <script src="public/js/bootstrap-typeahead.js"></script>

  </body>
</html>
