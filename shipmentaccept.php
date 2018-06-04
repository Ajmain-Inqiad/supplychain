<?php require_once ("dbconnect.php"); ?>
<?php require_once ('includes/employee_header.php'); ?>
<?php
if($_SESSION['job_type'] == "Supervisor"){
    $supersql = $connect->query("SELECT id FROM employee WHERE username='$username'");
    $row = $supersql->fetch_assoc();
    $supid = $row['id'];
    $resultsql = $connect->query("SELECT * FROM shipment_accept INNER JOIN orders ON shipment_accept.order_id = orders.id AND shipment_accept.client_id = orders.client_id AND orders.supervisor = '$supid'");
}
?>
              <!-- Main Menu -->
              <meta http-equiv="refresh" content="60">
              <div class="side-menu-container">
                  <ul class="nav navbar-nav">
                      <li><a href="employee.php"><span class="glyphicon glyphicon-home"></span>Home</a></li>
                      <li><a href="empcheckorder.php"><span class="glyphicon glyphicon-save"></span>Check Order</a></li>
                      <?php if($_SESSION['job_type'] == "Manager") { ?>
                      <li><a href="addemp.php"><span class="glyphicon glyphicon-cloud-upload"></span>Add Employee</a></li>
                      <li><a href="addproduct.php"><span class="glyphicon glyphicon-paperclip"></span>Add Product</a></li>
                      <li><a href="shipmentreq.php"><span class="glyphicon glyphicon-road"></span>Shipment Request</a></li>
                      <li><a href="emptrackproduct.php"><span class="glyphicon glyphicon-map-marker"></span>Vehicle Location</a></li>
                       <li><a href="showclient.php"><span class="glyphicon glyphicon-equalizer"></span>Client Graph</a></li>
                       <li><a href="driverlist.php"><span class="glyphicon glyphicon-user"></span>Driver List</a></li>
                       <li><a href="warehouseinfo.php"><span class="glyphicon glyphicon-tent"></span>Warehouse Info</a></li>
                      <?php }elseif($_SESSION['job_type'] == "Supervisor") { ?>
                          <li class="active"><a href="shipmentaccept.php"><span class="glyphicon glyphicon-tent"></span>Accepted Shipment</a></li>
                      <?php }?>
                      <li><a href="empsetting.php"><span class="glyphicon glyphicon-cog"></span>Profile Setting</a></li>
                      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>

                  </ul>
              </div><!-- /.navbar-collapse -->
          </nav>

      </div>

      <!-- Main Content -->
      <div class="container-fluid">
          <div class="side-body">
            <br>
             <pre> <b> Shipment Accept</b> </pre>
             <br>
             <p>Page reload after each 60 sec</p>
             <br>
             <table class='table table-hover' style='width:100%;'>
               <thead>
                   <tr>
                     <th>Order ID</th>
                     <th>Client</th>
                   </tr>
               </thead>

               <tbody>
                   <?php while ($row = $resultsql->fetch_assoc()) {?>
                       <tr>
                           <td><?php echo $row['order_id']; ?></td>
                           <?php
                           $client = $row['client_id'];
                           $clientsql = $connect->query("SELECT fullname FROM client WHERE id='$client'");
                           $clientrow = $clientsql->fetch_assoc();
                           $client_name = $clientrow['fullname'];
                           ?>
                           <td><?php echo $client_name; ?></td>
                       </tr>
                   <?php } ?>
               </tbody>
           </table>
          </div>
      </div>
  </div>
<?php require_once ('includes/employee_footer.php'); ?>
