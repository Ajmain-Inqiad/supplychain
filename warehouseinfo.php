<?php require_once ("dbconnect.php"); ?>
<?php require_once ('includes/employee_header.php'); ?>
              <!-- Main Menu -->
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
                       <li class="active"><a href="warehouseinfo.php"><span class="glyphicon glyphicon-tent"></span>Warehouse Info</a></li>
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
             <pre> <b> Warehouse Info</b> </pre>
             <br>
             <div class="row">
                <label style="margin-top:6px;" class="col-md-2 control-label" for="rolename" style="float:left;">Warehouse</label>
                <div class="col-md-10" style="float:left;">
                  <div style="text-align:center;">
                      <select id="warehouse" class="form-control">
                        <option value="">Select Option</option>
                        <option value="savar">Savar</option>
                        <option value="mohammadpur">Mohammadpur</option>
                        <option value="mohakhali">Mohakhali</option>
                      </select>
                  </div>
                </div>
               </div>
               <div id="tableinfo">

               </div>
          </div>
      </div>
  </div>
  <div>
  <script type="text/javascript">
  $(document).ready(function() {
      $("#warehouse").change(function() {
          var data = $(this).val();
          var jobtype = "<?php echo $job_type; ?>";
          dataType = "type=" + data+"&job="+jobtype;
          $.ajax({
              type: "post",
              url: "get_ware_info.php",
              data: dataType,
              cache: false,
              success: function(result) {
                  $("#tableinfo").html(result);
              }
          });
      });

  });
  </script>
<?php require_once ('includes/employee_footer.php'); ?>
