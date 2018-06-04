<?php require_once ("dbconnect.php"); ?>
<?php require_once ('includes/employee_header.php'); ?>
              <!-- Main Menu -->
              <div class="side-menu-container">
                  <ul class="nav navbar-nav">
                      <li><a href="employee.php"><span class="glyphicon glyphicon-home"></span>Home</a></li>
                      <li class="active"><a href="empcheckorder.php"><span class="glyphicon glyphicon-save"></span>Check Order</a></li>
                      <?php if($_SESSION['job_type'] == "Manager") { ?>
                      <li><a href="addemp.php"><span class="glyphicon glyphicon-cloud-upload"></span>Add Employee</a></li>
                      <li><a href="addproduct.php"><span class="glyphicon glyphicon-paperclip"></span>Add Product</a></li>
                      <li><a href="shipmentreq.php"><span class="glyphicon glyphicon-road"></span>Shipment Request</a></li>
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
             <pre style="text-align:center;"> <b> Placed Order </b> </pre>
             <?php if($_SESSION['job_type'] == "Manager") {?>
             <div class="row">
                <label style="margin-top:6px;" class="col-md-2 control-label" for="rolename" style="float:left;">Order Type</label>
                <div class="col-md-10" style="float:left;">
                  <div style="text-align:center;">
                      <select id="order" class="form-control">
                        <option value="">Select Option</option>
                        <option value="allorder">Approved Orders</option>
                        <option value="assignedorder">Assigned Orders</option>
                        <option value="recievedorder">Received Orders</option>
                      </select>
                  </div>
                </div>
               </div>
               <?php }elseif ($_SESSION['job_type'] == "Supervisor") {?>
                   <div class="row">
                      <label style="margin-top:6px;" class="col-md-2 control-label" for="rolename" style="float:left;">Order Type</label>
                      <div class="col-md-10" style="float:left;">
                        <div style="text-align:center;">
                            <select id="order" class="form-control">
                              <option value="">Select Option</option>
                              <option value="assignedorder">Assigned Orders</option>
                            </select>
                        </div>
                      </div>
                     </div>
               <?php }else{ ?>
                   <p style="text-align:center"> <b>Approved Order List</b> </p>
                   <table class='table table-hover' style='width:100%;'>
                     <thead>
                         <tr>
                           <th>Order ID</th>
                           <th>Client</th>
                           <th>Details</th>
                           <th>Ordered date</th>
                           <th>Delivery date</th>
                           <th>Manager</th>
                         </tr>
                     </thead>
                     <tbody>
                   <?php
                   $sql = "SELECT * FROM orders WHERE approved = 'yes' ORDER BY id DESC";
                   $result = $connect->query($sql);
                   while ($row = $result->fetch_assoc()) {
                       $manager = $row['manager'];
                       $manresult = $connect->query("SELECT fullname FROM employee WHERE username='$manager'");
                       $manrow = $manresult->fetch_assoc();
                       $manfullname = $manrow['fullname'];
                       $client = $row['client_id'];
                       $clientresult = $connect->query("SELECT fullname FROM client WHERE id='$client'");
                       $clientrow = $clientresult->fetch_assoc();
                       $clientfullname = $clientrow['fullname'];
                       ?>
                       <tr>
                         <td> <?php echo $row['id']; ?> </td>
                         <td> <?php echo $clientfullname; ?> </td>
                         <td> <?php echo $row['details']; ?> </td>
                         <td> <?php echo $row['ordering_date']; ?> </td>
                         <td> <?php echo $row['delivery_date']; ?> </td>
                         <td> <?php echo $manfullname; ?> </td>
                       </tr>
                   <?php
                    } ?>
                    </tbody>
                </table>
        <?php } ?>
               <br>
               <div id="tableinfo">
               </div>
           </div>
          </div>
      </div>
  </div>

  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header" style="background-color:#003366; color:white;">
                 <h5 class="modal-title" id="exampleModalLabel" style="font-weight:bold; font-size:17px;">New message</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span style="color:white;" aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <form action="#" method="post">
                     <div class="form-group">
                         <label for="orderid" class="form-control-label">Order ID:</label>
                         <input type="text" value="" class="form-control" id="orderid" disabled>
                     </div>
                     <div class="form-group">
                         <label for="message-text" class="form-control-label">Assign Supervisor:</label>
                         <select id="supervisor" required class="form-control">
                           <option value="">Select Option</option>
                             <?php
                             $query = $connect->query("SELECT * FROM employee WHERE job_type='Supervisor'");
                             while($row = $query->fetch_assoc()){ ?>
                               <option value="<?php echo $row['username']; ?>"><?php echo $row['fullname']; ?></option>
                             <?php
                             }
                             ?>
                         </select>
                     </div>
                     <div class="form-group">
                         <label for="message-text" class="form-control-label">Message:</label>
                         <textarea class="form-control" id="msgbody" disabled required></textarea>
                     </div>
                 </form>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary" id="assignsupervisor">Send message</button>
             </div>
         </div>
     </div>
 </div>
  <script type="text/javascript">
  var dataType="";
      $(document).ready(function() {
          $("#order").change(function() {
              var data = $(this).val();
              var jobtype = "<?php echo $job_type; ?>";
              dataType = "type=" + data+"&job="+jobtype;
              $.ajax({
                  type: "post",
                  url: "get_order_emp.php",
                  data: dataType,
                  cache: false,
                  success: function(result) {
                      $("#tableinfo").html(result);
                  }
              });
          });

      });
      $('#exampleModal').on('show.bs.modal', function(event) {
              var button = $(event.relatedTarget) // Button that triggered the modal
              var recipient = button.data('whatever') // Extract info from data-* attributes
              // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
              // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
              var modal = $(this)
              modal.find('#orderid').val(recipient)
              modal.find('#msgbody').val("You have been assigned to "+recipient+" no order.")
      });
      $(document).ready(function (){
              $(document).on('click', '#approve', function (){
                      var data = $(this).attr("data-id");
                      dataType = "type=shipment&order=" + data;
                      $.ajax({
                          type: "post",
                          url: "get_client_order.php",
                          data: dataType,
                          cache: false,
                          success: function(result) {
                              alert(result);
                          }
                      });
              });
      });

      $(document).ready(function(){
          $(document).on('click', '#receiveraw', function (){
              var orderid = $(this).attr("data-whatever");
              var jobtype = "<?php echo $job_type; ?>";
              dataType = "type=rawreceive&job="+jobtype+"&orderid="+orderid;
              $.ajax({
                  type: "post",
                  url: "get_order_emp.php",
                  data: dataType,
                  cache: false,
                  success: function(result){
                      var data = $("#order").val();
                      var jobtype = "<?php echo $job_type; ?>";
                      dataType = "type=" + data+"&job="+jobtype;
                      $.ajax({
                          type: "post",
                          url: "get_order_emp.php",
                          data: dataType,
                          cache: false,
                          success: function(result) {
                              $("#tableinfo").html(result);
                          }
                      });
                  }
              });
          });
      });
      $(document).ready(function (){
              $(document).on('click', '#recieve', function (){
                      var data = $(this).attr("data-id");
                      dataType = "type=recieve&order=" + data;
                      $.ajax({
                          type: "post",
                          url: "get_client_order.php",
                          data: dataType,
                          cache: false,
                          success: function(result) {
                              alert(result);
                          }
                      });
              });
      });

      $(document).ready(function(){
          $(document).on('click', '#assignsupervisor', function(){
              var orderid = $("#orderid").val();
              var msg = $("#msgbody").val();
              var supervisor = $("#supervisor").val();
              dataType = "type=assignsup&job=Manager&orderid="+orderid+"&super="+supervisor+"&msg="+msg;
              $.ajax({
                  type: "post",
                  url: "get_order_emp.php",
                  data: dataType,
                  cache: false,
                  success: function(result){
                      alert(result);
                      var data = $("#order").val();
                      var jobtype = "<?php echo $job_type; ?>";
                      dataType = "type=" + data+"&job="+jobtype;
                      $.ajax({
                          type: "post",
                          url: "get_order_emp.php",
                          data: dataType,
                          cache: false,
                          success: function(result) {
                              $("#tableinfo").html(result);
                          }
                      });
                  }
              });
          });
      });
   </script>
<?php require_once ('includes/employee_footer.php'); ?>
