<?php require_once ("dbconnect.php"); ?>
<?php require_once ('includes/employee_header.php'); ?>
<?php require_once ("class.phpmailer.php"); ?>
<?php require_once ("class.smtp.php"); ?>
<?php require_once ("PHPMailerAutoload.php"); ?>
<?php require_once('function.php'); ?>
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
$msg="";
if(isset($_POST["submit"])){
    $target_file = "img/emp/" . basename($_FILES['image']['name']);
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	if (file_exists($target_file)) {
		$msg = "Rename Your file ";
	}
	 elseif($_FILES["image"]["size"] > 500000) {
		$msg = "File is too large.";
	}
	elseif($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
		$msg = "Only JPG, JPEG, PNG files are allowed.";
	}else{
        $fullname = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $newusername = $_POST['username'];
        $job_type = $_POST['job_type'];
        $password = $_POST['password'];
        $birth = $_POST['birth'];
        $image = $_FILES['image']['name'];
        $clientsql = "SELECT username FROM client WHERE username='$newusername'";
        $adminsql = "SELECT username FROM admin WHERE username='$newusername'";
        $employeesql = "SELECT username FROM employee WHERE username='$newusername'";
        $client_result = $connect->query($clientsql);
        $admin_result = $connect->query($adminsql);
        $emp_result = $connect->query($employeesql);
        if(($client_result->num_rows == 0) && ($admin_result->num_rows == 0) && ($emp_result->num_rows == 0)){
            if(move_uploaded_file($_FILES['image']['tmp_name'], $target_file)){
                $hashed_pass = password_encrypt($password);
                $sql = "INSERT INTO employee (fullname, username, password, job_type, birth, email, address, phone, image, logged_in) VALUES ('$fullname', '$newusername', '$hashed_pass', '$job_type', '$birth', '$email', '$address', '$phone', '$target_file', 'no')";
                $result = $connect->query($sql);
                if($result){
                    $msg="Employee added successfully";
                    $mail = new PHPMailer(); // create a new object
                    $mail->IsSMTP(); // enable SMTP
                    $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
                    $mail->SMTPAuth = true; // authentication enabled
                    #$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
                    $mail->Host = "smtp.ourdeal.bid";
                    $mail->Port = 587; // or for ssl port=465 or 25=non-ssl
                    $mail->IsHTML(true);
                    $mail->Username = "customerservice@ourdeal.bid";
                    $mail->Password = "12345678";
                    $mail->SetFrom("customerservice@ourdeal.bid");
                    $mail->AddAddress($email);
                    try {
                        $msg1 = " Your employee account has been created. <br>============================= <br> Your employee username: $newusername <br> Password:  $password <br> ==========================";
                        $mail->Body = $msg1;
                        $mail->Subject = "Mail from Our Deal";
                        if(!$mail->Send()) {
                            echo "Mailer Error: " . $mail->ErrorInfo;
                        }else{
                            echo "<script> alert('Please check your email for validation.'); </script>'";
                        }
                    }catch (Exception $e) {
                        #print_r($e->getMessage());
                        file_put_contents($logfile, "Error: \n", FILE_APPEND);
                        file_put_contents($logfile, $e->getMessage() . "\n", FILE_APPEND);
                        file_put_contents($logfile, $e->getTraceAsString() . "\n\n", FILE_APPEND);
                    }
                }else{
                    $msg = $result->error;
                }
            }else{
                $msg = "File saving error. Please try again.";
            }
        }else{
            $msg = "Username is in use";
        }
    }
}
?>
              <!-- Main Menu -->
              <div class="side-menu-container">
                  <ul class="nav navbar-nav">
                      <li><a href="employee.php"><span class="glyphicon glyphicon-home"></span>Home</a></li>
                      <li><a href="empcheckorder.php"><span class="glyphicon glyphicon-save"></span>Check Order</a></li>
                      <?php if($_SESSION['job_type'] == "Manager") { ?>
                      <li class="active"><a href="addemp.php"><span class="glyphicon glyphicon-cloud-upload"></span>Add Employee</a></li>
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
             <pre> <b>Add Employee</b></pre>
             <?php if($msg != "") { ?>
                 <p style="color:red"><?php echo $msg; ?></p>
                 <?php } ?>
             <form method="post" action="#" enctype="multipart/form-data">
                 <div class="form-row">
                     <div class="form-group col-md-4">
                       <label for="inputname">Full Name</label>
                       <input type="text" class="form-control" id="inputname" name="name" required placeholder="Full name">
                     </div>
                     <div class="form-group col-md-4">
                       <label for="inputemail">Email</label>
                       <input type="email" class="form-control" id="inputemail" name="email" required placeholder="Email">
                       <div id="emailmsg">
                       </div>
                     </div>
                     <div class="form-group col-md-4">
                       <label for="inputphone">Phone</label>
                       <input type="text" class="form-control" id="inputphone" name="phone" required placeholder="Phone Number" onkeyup="validatephone(this);">
                     </div>
                   </div>
                   <div class="form-group col-md-12">
                     <label for="inputAddress">Address</label>
                     <input type="text" class="form-control" id="inputAddress" name="address" required placeholder="Address">
                   </div>
                   <div class="form-row">
                     <div class="form-group col-md-4">
                       <label for="inputuser">Username</label>
                       <input type="text" class="form-control" id="inputuser" name="username" placeholder="Username" required>
                       <div id="usermsg">
                       </div>
                     </div>
                     <div class="form-group col-md-4">
                       <label for="inputjob">Job Type</label>
                       <input type="text" class="form-control" id="inputjob" name="job_type" placeholder="Job Type" required>
                     </div>
                     <div class="form-group col-md-4">
                       <label for="inputpass">Password</label>
                       <input type="password" class="form-control" id="inputpass" name="password" required placeholder="Password">
                     </div>
                   </div>
                   <div class="form-row">
                       <div class="form-group col-md-4">
                         <label for="inputbirth">Birth Date</label>
                         <input type="date" class="form-control" id="inputbirth" name="birth" required placeholder="Birth date">
                       </div>
                       <div class="form-group col-md-8">
                         <label for="inputpic">Image</label>
                         <input type="file" class="form-control" id="inputpic" name="image" required accept="image/jpeg,image/jpg, image/x-png">
                         <div id="imgmsg">
                         </div>
                       </div>
                     </div>
                   <div class="form-group col-md-2">
                     <button type="submit" id="submit" name="submit" class="btn btn-primary">Add Employee</button>
                   </div>
                 </form>
          </div>
      </div>
  </div>
  </div>
  <script type="text/javascript">
  $(document).ready(function(){
    $("#inputemail").keyup(function(){
      var email = $(this).val();
      var regMail = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
      if(regMail.test(email) == false){
        $("#emailmsg").html("<p style='color:red'>Email address is not valid yet</p>");
      }else{
        $("#emailmsg").html("<p style='color:green'>Thanks, valid Email address!</p>");
      }
    });
    $('#inputuser').keyup(function(){
      var user = $(this).val();
      dataType = "type=addemp&user="+user ;
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
    $("#inputpic").change(function () {
        var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            $("#imgmsg").html("Only formats are allowed : "+fileExtension.join(', '));
        }
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
