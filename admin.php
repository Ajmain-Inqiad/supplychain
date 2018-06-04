<?php require_once ("dbconnect.php"); ?>
<?php require_once ('includes/admin_header.php'); ?>
              <!-- Main Menu -->
              <div class="side-menu-container">
                  <ul class="nav navbar-nav">
                      <li class="active"><a href="admin.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                      <li><a href="employeeList.php"><span class="glyphicon glyphicon-user"></span>Employee List</a></li>
                      <li><a href="orderlist.php"><span class="glyphicon glyphicon-th-list"></span> Order List </a></li>
                      <li><a href="clientlist.php"><span class="glyphicon glyphicon-briefcase"></span> Client List </a></li>
                      <li><a href="adminsetting.php"><span class="glyphicon glyphicon-cog"></span> Profile Setting </a></li>
                      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>

                  </ul>
              </div><!-- /.navbar-collapse -->
          </nav>

      </div>

      <!-- Main Content -->
      <div class="container-fluid">
          <div class="side-body">
             <h1 id="msg"> </h1>
             <pre> <b> Welcome Admin</b> </pre>
          </div>
      </div>
  </div>
<?php require_once ('includes/admin_footer.php'); ?>
