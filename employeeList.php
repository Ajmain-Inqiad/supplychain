<?php require_once ("dbconnect.php"); ?>
<?php require_once ('includes/admin_header.php'); ?>
              <!-- Main Menu -->
              <div class="side-menu-container">
                  <ul class="nav navbar-nav">
                      <li><a href="admin.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                      <li class="active"><a href="employeeList.php"><span class="glyphicon glyphicon-user"></span>Employee List</a></li>
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
        <br>
          <div class="side-body">
             <pre style="text-align:center"> <b>Employee List</b> </pre>
             <div class="row">
                <label class="col-md-2 control-label" for="rolename" style="float:left;">Job Type</label>
                <div class="col-md-4" style="float:left;">
                  <div style="text-align:center;">
                      <select id="employee" class="form-control">
                        <option value="">Select Option</option>
                        <?php
                        $query = $connect->query("SELECT DISTINCT job_type FROM employee ORDER BY job_type ASC");
                        while($row = $query->fetch_assoc()){?>
                          <option value="<?php echo $row['job_type']; ?>"><?php echo $row['job_type']; ?></option>
                        <?php
                          }
                        ?>
                      </select>
                  </div>
                </div>
                <div class="col-md-4" style="float:right;">
                  <form class="navbar-form" role="search">
                     <div class="input-group">
                         <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">
                         <div class="input-group-btn">
                             <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                         </div>
                     </div>
                 </form>
                </div>
               </div>
               <br>
               <div id="tableinfo">
                 <table class="table table-hover" style="width:100%;">
                   <thead>
                       <tr>
                         <th>ID</th>
                         <th>Full Name</th>
                         <th>Job Type</th>
                         <th>Email</th>
                         <th>Image</th>
                         <th>Action</th>
                       </tr>
                   </thead>

                   <tbody>
                     <?php
                     $query = $connect->query("SELECT * FROM employee");
                     while($row = $query->fetch_assoc()){?>
                       <tr>
                         <td><?php echo $row['id']; ?></td>
                         <td><?php echo $row['fullname']; ?></td>
                         <td><?php echo $row['job_type']; ?></td>
                         <td><?php echo $row['email']; ?></td>
                         <td width="70px"><img src="<?php echo $row['image']; ?>" alt="image" style="width:100%; height:10%"></td>
                         <td><button type="button" class="btn btn-danger" id="submit" value="<?php echo $row['id']; ?>"> Delete</button></td>
                       </tr>
                     <?php
                   }
                     ?>
                   </tbody>
                 </table>
               </div>
             </div>
          </div>
      </div>
  </div>
  <script type="text/javascript">
       $(document).ready(function(){
         $('#srch-term').keyup(function(){
           var name= $(this).val();
           $.post('get_employee.php', { name:name }, function(data){
             $('#tableinfo').html(data);
           });
         });
       });

      var dataType = "";
      $(document).ready(function() {
          $("#employee").change(function() {
              var data = $(this).val();
              dataType = "type=" + data;
              $.ajax({
                  type: "post",
                  url: "get_select_job.php",
                  data: dataType,
                  cache: false,
                  success: function(result) {
                      $("#tableinfo").html(result);
                  }
              });
          });

      });

      $(document).ready(function (){
          $(document).on('click', '#submit', function (){
              var id=$(this).val();
              if(dataType == ""){
                dataType="type=all";
              }
              if(confirm("Are you sure?")){
                $.ajax({
                    type: "post",
                    url: "delete_employee.php",
                    data: "id="+id,
                    cache: false,
                    success: function(result) {
                      $.ajax({
                          type: "post",
                          url: "get_select_job.php",
                          data: dataType,
                          cache: false,
                          success: function(result) {
                              $("#tableinfo").html(result);
                          }
                      });
                    }
                });
              }
          });
      });
   </script>
<?php require_once ('includes/admin_footer.php'); ?>
