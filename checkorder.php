<?php require_once ("dbconnect.php"); ?>
<?php require_once ('includes/client_header.php'); ?>
              <!-- Main Menu -->
              <div class="side-menu-container">
                  <ul class="nav navbar-nav">
                      <li><a href="client.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                      <li><a href="makeorder.php"><span class="glyphicon glyphicon-shopping-cart"></span>Give Order</a></li>
                      <li class="active"><a href="checkorder.php"><span class="glyphicon glyphicon-saved"></span>Placed Order</a></li>
                      <li><a href="trackproduct.php"><span class="glyphicon glyphicon-map-marker"></span>Product Location </a></li>
                      <li><a href="clientsetting.php"><span class="glyphicon glyphicon-cog"></span>Profile Setting </a></li>
                      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>

                  </ul>
              </div><!-- /.navbar-collapse -->
              </nav>

        </div>

      <!-- Main Content -->
      <div class="container-fluid">
        <br>
          <div class="side-body">
             <pre style="text-align:center"> <b>Placed Order List</b> </pre>
             <div class="row">
                <label style="margin-top:6px;" class="col-md-2 control-label" for="rolename" style="float:left;">Order Type</label>
                <div class="col-md-10" style="float:left;">
                  <div style="text-align:center;">
                      <select id="order" class="form-control">
                        <option value="">Select Option</option>
                        <option value="neworder">New Order</option>
                        <option value="approvedorder">Approved Order</option>
                        <option value="recievedorder">Recieved Order</option>
                      </select>
                  </div>
                </div>
               </div>
               <br>
               <div id="tableinfo">
               </div>
               
             </div>
          </div>
      </div>
  </div>
  <script type="text/javascript">
      var dataType = "";
      var type="";
      var demo="";
      if(type==""){
        type="currentclient";
      }
      $(document).ready(function() {
          $("#order").change(function() {
              var data = $(this).val();
              dataType = "type=" + data;
              $.ajax({
                  type: "post",
                  url: "get_client_order.php",
                  data: dataType,
                  cache: false,
                  success: function(result) {
                      $("#tableinfo").html(result);
                  }
              });
          });

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

   </script>
<?php require_once ('includes/client_footer.php'); ?>
