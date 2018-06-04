<?php require_once ("dbconnect.php"); ?>
<?php require_once ('includes/employee_header.php'); ?>
<?php
if($_SESSION['job_type'] != "Manager"){
    if($_SESSION['type'] != "employee"){
        header("Location: logout.php");
    }else{
        header("Location: employee.php");
    }
}
?>
<?php
$query = $connect->query("SELECT * FROM orders WHERE completed='yes'");
?>
              <!-- Main Menu -->
              <div class="side-menu-container">
                  <ul class="nav navbar-nav">
                      <li><a href="employee.php"><span class="glyphicon glyphicon-home"></span>Home</a></li>
                      <li><a href="empcheckorder.php"><span class="glyphicon glyphicon-save"></span>Check Order</a></li>
                      <?php if($_SESSION['job_type'] == "Manager") { ?>
                      <li><a href="addemp.php"><span class="glyphicon glyphicon-cloud-upload"></span>Add Employee</a></li>
                      <li><a href="addproduct.php"><span class="glyphicon glyphicon-paperclip"></span>Add Product</a></li>
                      <li class="active"><a href="shipmentreq.php"><span class="glyphicon glyphicon-road"></span>Shipment Request</a></li>
                      <li><a href="emptrackproduct.php"><span class="glyphicon glyphicon-map-marker"></span>Vehicle Location</a></li>
                      <li><a href="showclient.php"><span class="glyphicon glyphicon-equalizer"></span>Client Graph</a></li>
                      <li><a href="driverlist.php"><span class="glyphicon glyphicon-user"></span>Driver List</a></li>
                      <li><a href="warehouseinfo.php"><span class="glyphicon glyphicon-tent"></span>Warehouse Info</a></li>
                      <?php }elseif($_SESSION['job_type'] == "Supervisor") { ?>
                          <li><a href="shipmentaccept.php"><span class="glyphicon glyphicon-tent"></span>Accepted Shipment</a></li>
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
             <pre style="text-align:center"> <b> Shipment Request </b> </pre>
             <table class='table table-hover' style='width:100%;'>
               <thead>
                   <tr>
                     <th>Order ID</th>
                     <th>Client</th>
                     <th>Details</th>
                     <th>Done Amount</th>
                     <th>Ordered date</th>
                     <th>Delivery date</th>
                     <th>Manager</th>
                     <th>Action</th>
                   </tr>
               </thead>
               <tbody>
                   <?php while($row=$query->fetch_assoc()){
                       $orderid = $row['id'];
                       $doneAmount = $row['doneAmount'];
                       $orderamount = $row['orderAmount'];
                       $client_id=$row['client_id'];
                       $clientquery = $connect->query("SELECT fullname FROM client WHERE id='$client_id'");
                       $clientres = $clientquery->fetch_assoc();
                       $client_name = $clientres['fullname'];
                       $details = $row['details'];
                       $orderdate = $row['ordering_date'];
                       $deliverydate = $row['delivery_date'];
                       $manager = $row['manager'];
                       $manresult = $connect->query("SELECT fullname FROM employee WHERE username='$manager'");
                       $manrow = $manresult->fetch_assoc();
                       $manfullname = $manrow['fullname']; ?>
                       <tr>
                           <td><?php echo $orderid; ?></td>
                           <td><?php echo $client_name; ?></td>
                           <td><?php echo $details; ?></td>
                           <td><?php echo $doneAmount; ?></td>
                           <td><?php echo $orderdate; ?></td>
                           <td><?php echo $deliverydate; ?></td>
                           <td><?php echo $manfullname; ?></td>
                       <?php
                       if($doneAmount == $orderamount){
                           $shipreqsql = $connect->query("SELECT * FROM shipment_req WHERE order_id='$orderid' AND client_id='$client_id' AND accepted='no'");
                        //    $count = $shipreqsql->num_rows ;
                        //    $shipresulting = $shipreqsql->fetch_assoc();
                           if($shipreqsql->num_rows > 0){
                               $shipresulting = $shipreqsql->fetch_assoc();
                                ?>
                               <td><button type='button' class='btn btn-success' id='shipaccept' data-id="<?php echo $client_id; ?>" data-whatever="<?php echo $orderid; ?> <?php echo $shipresulting['id']; ?>"> Accept </button></td>
                           <?php
                       }else{
                           echo "<td>Shipment is not requested</td>";
                       }
                   }else{
                       echo "<td>Not completed</td>";
                   }
                    ?>
                </tr>
                   <?php } ?>
               </tbody
          </div>
      </div>
  </div>
  <script type="text/javascript">
      $(document).ready(function(){
          $("#shipaccept").click(function(){
              var client_id = $(this).attr("data-id");
              var ordercheck = $(this).attr("data-whatever");
              var client = ordercheck.split(" ");
              var orderid = client[0];
              var reqid = client[1];
              var dataType = "type=shipaccepting&order="+orderid+"&client="+client_id+"&shipreq="+reqid;
                  $.ajax({
                      type: "post",
                      url: "check_validity.php",
                      data: dataType,
                      cache: false,
                      success: function(result){
                          alert(result);
                          location.reload();
                      }
                  });

          });
      });
  </script>
<?php require_once ('includes/employee_footer.php'); ?>
