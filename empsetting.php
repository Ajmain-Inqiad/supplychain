<?php require_once ("dbconnect.php"); ?>
<?php require_once ('includes/employee_header.php'); ?>
<?php require_once ("function.php"); ;?>
<?php
$query="SELECT * FROM employee WHERE username='$username' LIMIT 1";
$result = $connect->query($query);
$row = $result->fetch_assoc();
$id = $row['id'];
$name = $row['fullname'];
$username = $row['username'];
$job_type = $row['job_type'];
$email = $row['email'];
$address = $row['address'];
$phone = $row['phone'];
$img = $row['image'];
$birth = $row['birth'];
$msg="";
if(isset($_POST['submit'])){
  $newemail = $_POST['email'];
  $newphone = $_POST['phone'];
  $newaddress = $_POST['address'];
  $newusername = $_POST['username'];
  $newpassword = $_POST['password'];
  $check="okay";
  if($username != $newusername){
      $clientsql = "SELECT username FROM client WHERE username='$newusername'";
      $adminsql = "SELECT username FROM admin WHERE username='$newusername'";
      $employeesql = "SELECT username FROM employee WHERE username='$newusername'";
      $client_result = $connect->query($clientsql);
      $admin_result = $connect->query($adminsql);
      $emp_result = $connect->query($employeesql);
      if(($client_result->num_rows == 0) && ($admin_result->num_rows == 0) && ($emp_result->num_rows == 0)){
          $check = "okay";
      }else{
          $check = "error";
      }
  }
  if($check == "okay"){
      if($newpassword == ""){
        $sql = "UPDATE employee SET email='$newemail', address='$newaddress', username='$newusername', phone='$newphone' WHERE id='$id'";
        $result = $connect->query($sql);
        if($result){
          if($username != $newusername){
            $_SESSION['username'] = $newusername;
          }
          $msg="success";
        }else{
          $msg="error";
        }
      }else{
        $hashed_pass = password_encrypt($newpassword);
        $sql = "UPDATE employee SET email='$newemail', address='$newaddress', username='$newusername', password='$hashed_pass', phone='$newphone' WHERE id='$id'";
        $result = $connect->query($sql);
        if($result){
          if($username != $newusername){
            $_SESSION['username'] = $newusername;
          }
          $msg="success";
        }else{
            $msg="error";
        }
      }
  }else{
      $msg = "error";
  }
}
?>

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
                      <li><a href="warehouseinfo.php"><span class="glyphicon glyphicon-tent"></span>Warehouse Info</a></li>
                      <?php }elseif($_SESSION['job_type'] == "Supervisor") { ?>
                          <li><a href="shipmentaccept.php"><span class="glyphicon glyphicon-tent"></span>Accepted Shipment</a></li>
                      <?php }?>
                      <li class="active"><a href="empsetting.php"><span class="glyphicon glyphicon-cog"></span>Profile Setting</a></li>
                      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>

                  </ul>
              </div><!-- /.navbar-collapse -->
          </nav>

      </div>

      <!-- Main Content -->
      <div class="container-fluid">
          <div class="side-body">
              <br>
             <pre style="text-align:center"> <b>Profile Setting</b> </pre>
             <div style="text-align: center">
                 <img src="<?php echo $img; ?>" alt="<?php echo $username; ?>" style="width:25%; height:8%;">
             </div>
             <div class="row">
               <div class="col-md-12">
                 <?php
                 if($msg == "success"){?>
                   <br>
                   <div class="alert alert-success" style="text-align:center">
                     <strong>Successful!</strong> record updated. Please reload to see changes.
                   </div>
                 <?php
               }elseif($msg=="error"){?>
                 <br>
                 <div class="alert alert-danger" style="text-align:center">
                   <strong>Error!</strong> record update failed.
                 </div>
               <?php
             }
                  ?>
               </div>
             </div>
             <form method="post" action="">
                 <div class="form-row">
                     <div class="form-group col-md-4">
                       <label for="inputname">Full Name</label>
                       <input type="name" class="form-control" id="inputname" name="name" disabled required value="<?php echo $name; ?>">
                     </div>
                     <div class="form-group col-md-4">
                       <label for="inputemail">Email</label>
                       <input type="email" class="form-control" id="inputemail" name="email" required value="<?php echo $email; ?>">
                       <div id="emailerror">
                       </div>
                     </div>
                     <div class="form-group col-md-4">
                       <label for="inputphone">Phone</label>
                       <input type="text" class="form-control" id="inputphone" name="phone" onkeyup="validatephone(this);" required value="<?php echo $phone; ?>">
                       <div id="phnerror">
                       </div>
                     </div>
                   </div>
                   <div class="form-group col-md-12">
                     <label for="inputaddress">Address</label>
                     <input type="text" class="form-control" id="inputaddress" name="address" required value="<?php echo $address; ?>">
                   </div>
                   <div class="form-row">
                       <div class="form-group col-md-6">
                         <label for="inputuser">Username</label>
                         <input type="text" class="form-control" id="inputuser" name="username" value="<?php echo $username; ?>" required>
                         <div id="usermsg">
                         </div>
                       </div>
                       <div class="form-group col-md-6">
                         <label for="inputpass">Password</label>
                         <input type="password" class="form-control" id="inputpass" name="password">
                       </div>
                     </div>
                     <div class="form-row">
                         <div class="form-group col-md-6">
                           <label for="inputbirth">Birth Date</label>
                           <?php $today = date("l jS \of F Y", strtotime($birth)); ?>
                           <input type="text" class="form-control" id="inputbirth" name="birth" disabled value="<?php echo $today; ?>" required>
                           <div id="usermsg">
                           </div>
                         </div>
                         <div class="form-group col-md-6">
                           <label for="inputjobtype">Job Type</label>
                           <input type="text" class="form-control" id="inputjobtype" name="jobType" disabled required value="<?php echo $job_type; ?>">
                         </div>
                       </div>
                     <div class="form-row">
                       <div class="form-group col-md-2">
                         <button type="submit" id="submit" name="submit" class="btn btn-primary" name="submit">Update</button>
                       </div>
                       <div class="form-group col-md-10">
                         <?php
                         if($msg == "success"){?>
                           <br>
                           <div class="alert alert-success">
                             <strong>Successful!</strong> record updated. Please reload to see changes.
                           </div>
                         <?php
                       }elseif($msg=="error"){?>
                         <br>
                         <div class="alert alert-danger">
                           <strong>Error!</strong> record update failed.
                         </div>
                       <?php
                     }
                          ?>
                       </div>
                     </div>

                 </form>
             </div>
          </div>
      </div>
  </div>
  <script>
  $(document).ready(function(){
    $("#inputemail").keyup(function(){
      var email = $(this).val();
      var regMail = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
      if(regMail.test(email) == false){
        $("#emailerror").html("<p style='color:red'>Email address is not valid yet</p>");
      }else{
        $("#emailerror").html("<p style='color:green'>Thanks, valid Email address!</p>");
      }
    });
    $('#inputuser').keyup(function(){
      var user = $(this).val();
      dataType = "type=updateclientname&user="+user ;
      $.ajax({
        type: "post",
        url: "check_validity.php",
        data: dataType,
        cache: false,
        success: function(result) {
            $("#usermsg").html(result);
        }
      });
    });
  });
  function validatephone(phone)
  {
      var maintainplus = '';
      var numval = phone.value;
      if ( numval.charAt(0)=='+' )
      {
          var maintainplus = '';
      }
      curphonevar = numval.replace(/[\\A-Za-z!"£$%^&\,*+_={};:'@#~,.Š\/<>?|`¬\]\[]/g,'');
      phone.value = maintainplus + curphonevar;
      var maintainplus = '';
      phone.focus;
  }
  </script>
<?php require_once ('includes/employee_footer.php'); ?>
