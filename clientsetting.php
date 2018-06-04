<?php require_once ("dbconnect.php"); ?>
<?php require_once ('includes/client_header.php'); ?>
<?php require_once('function.php'); ?>
<?php
$query="SELECT * FROM client WHERE username='$username' LIMIT 1";
$result = $connect->query($query);
$row = $result->fetch_assoc();
$id = $row['id'];
$name = $row['fullname'];
$email = $row['email'];
$address = $row['address'];
$phone = $row['phone'];
$division = $row['division'];
$msg="";
if(isset($_POST['submit'])){
  $newfullname = $_POST['name'];
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
        $sql = "UPDATE client SET fullname='$newfullname', email='$newemail', address='$newaddress', username='$newusername', phone='$newphone' WHERE id='$id'";
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
        $sql = "UPDATE client SET fullname='$newfullname', email='$newemail', address='$newaddress', username='$newusername', password='$hashed_pass', phone='$newphone' WHERE id='$id'";
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
                      <li><a href="client.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                      <li><a href="makeorder.php"><span class="glyphicon glyphicon-shopping-cart"></span>Give Order</a></li>
                      <li><a href="checkorder.php"><span class="glyphicon glyphicon-saved"></span>Placed Order</a></li>
                      <li><a href="trackproduct.php"><span class="glyphicon glyphicon-map-marker"></span>Product Location </a></li>
                      <li class="active"><a href="clientsetting.php"><span class="glyphicon glyphicon-cog"></span>Profile Setting </a></li>
                      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>

                  </ul>
              </div><!-- /.navbar-collapse -->
              </nav>

        </div>

      <!-- Main Content -->
      <div class="container-fluid">
        <br>
          <div class="side-body">
             <pre style="text-align:center"> <b>Profile Setting</b> </pre>

               <br>
               <form method="post" action="">
                   <div class="form-row">
                       <div class="form-group col-md-4">
                         <label for="inputname">Company Name</label>
                         <input type="name" class="form-control" id="inputname" name="name" required value="<?php echo $name; ?>">
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
                         <div class="form-group col-md-2">
                           <button type="submit" id="submit" class="btn btn-primary" name="submit">Update</button>
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

<?php require_once ('includes/client_footer.php'); ?>
