<?php require_once ("dbconnect.php"); ?>
<?php require_once ('includes/admin_header.php'); ?>
<?php require_once ('function.php'); ?>
<?php
$msg="";
if(isset($_POST['submit'])){
  $password = password_encrypt($_POST["password"]);
  $username = $_SESSION['username'];
  $sql = "UPDATE admin SET password='$password' WHERE username='$username'";
  $result = $connect->query($sql);
  if($result){
    $msg = "success";
  }
}

?>
              <!-- Main Menu -->
              <div class="side-menu-container">
                  <ul class="nav navbar-nav">
                      <li><a href="admin.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                      <li><a href="employeeList.php"><span class="glyphicon glyphicon-user"></span>Employee List</a></li>
                      <li><a href="orderlist.php"><span class="glyphicon glyphicon-th-list"></span> Order List </a></li>
                      <li><a href="clientlist.php"><span class="glyphicon glyphicon-briefcase"></span> Client List </a></li>
                      <li class="active"><a href="adminsetting.php"><span class="glyphicon glyphicon-cog"></span> Profile Setting </a></li>
                      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>

                  </ul>
              </div><!-- /.navbar-collapse -->
          </nav>

      </div>

      <!-- Main Content -->
      <div class="container-fluid">
          <div class="side-body">
            <br>
             <pre style="text-align:center"> <b>Admin Profile Setting</b> </pre>
             <br>
             <div class="row">
               <div class="col-md-7" style="padding-left:30%">
                 <form accept-charset="UTF-8" role="form" method="post" action="">
                   <fieldset>
                     <div class="input-group form-group">
                       <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                       <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                     </div>
                     <input class="btn btn-lg btn-default btn-block" id="submit" type="submit" name="submit" value="Update">
                   </fieldset>
                 </form>
                 <?php
                 if($msg != ""){?>
                   <br>
                   <div class="alert alert-success">
                     <strong>Successful!</strong> record updated.
                   </div>
                 <?php
                  }
                  ?>
               </div>

             </div>
          </div>
      </div>
  </div>
<?php require_once ('includes/admin_footer.php'); ?>
