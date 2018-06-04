<?php require_once ("dbconnect.php"); ?>
<?php require_once ('includes/employee_header.php'); ?>
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
$driversql = $connect->query("SELECT * FROM driver");
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
        $nid = $_POST['nid'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $truck = $_POST['truck'];
        $birth = $_POST['birth'];
        $image = $_FILES['image']['name'];
        if(move_uploaded_file($_FILES['image']['tmp_name'], $target_file)){
            $hashed_pass = password_encrypt($password);
            $sql = "INSERT INTO driver (fullname, nid, phone, address, truck, birthdate, image) VALUES ('$fullname', '$nid', '$phone', '$address', '$truck', '$birth', '$target_file')";
            $result = $connect->query($sql);
            if($result){
                $msg="Driver added successfully";
            }else{
                $msg = $result->error;
            }
        }else{
            $msg = "File saving error. Please try again.";
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
                      <li><a href="addemp.php"><span class="glyphicon glyphicon-cloud-upload"></span>Add Employee</a></li>
                      <li><a href="addproduct.php"><span class="glyphicon glyphicon-paperclip"></span>Add Product</a></li>
                      <li><a href="shipmentreq.php"><span class="glyphicon glyphicon-road"></span>Shipment Request</a></li>
                      <li><a href="emptrackproduct.php"><span class="glyphicon glyphicon-map-marker"></span>Vehicle Location</a></li>
                      <li><a href="showclient.php"><span class="glyphicon glyphicon-equalizer"></span>Client Graph</a></li>
                      <li class="active"><a href="driverlist.php"><span class="glyphicon glyphicon-user"></span>Driver List</a></li>
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
      <style>
      .formslide {
      display: none;
      }
      </style>
      <!-- Main Content -->
      <div class="container-fluid">
          <div class="side-body">
              <br>
             <pre> <b>Driver List</b></pre>
             <a href="#" class="dropdownmenu" data-id="1">Add New</a><br>
             <br><br>
             <br>
             <?php if($msg != "") { ?>
                 <p style="color:red"><?php echo $msg; ?> . Please reload to see</p>
                 <?php } ?>
             <form method="post" action="#" enctype="multipart/form-data" class="formslide">
                 <div class="form-row">
                     <div class="form-group col-md-4">
                       <label for="inputname">Full Name</label>
                       <input type="text" class="form-control" id="inputname" name="name" required placeholder="Full name">
                     </div>
                     <div class="form-group col-md-4">
                       <label for="inputnid">National ID</label>
                       <input type="text" class="form-control" id="inputnid" name="nid" required placeholder="NID" onkeyup="validatephone(this);">
                     </div>
                     <div class="form-group col-md-4">
                       <label for="inputphone">Phone</label>
                       <input type="text" class="form-control" id="inputphone" name="phone" required placeholder="Phone Number" onkeyup="validatephone(this);">
                     </div>
                   </div>
                   <div class="form-row">
                   <div class="form-group col-md-12">
                     <label for="inputAddress">Address</label>
                     <input type="text" class="form-control" id="inputAddress" name="address" required placeholder="Address">
                   </div>

               </div>
                   <div class="form-row">
                       <div class="form-group col-md-4">
                         <label for="inputtruck">Truck</label>
                         <input type="text" class="form-control" id="inputtruck" name="truck" required placeholder="Truck">
                       </div>
                     <div class="form-group col-md-4">
                       <label for="inputbirth">Birth Date</label>
                       <input type="date" class="form-control" id="inputbirth" name="birth" required placeholder="Birth date">
                     </div>
                     <div class="form-group col-md-4">
                       <label for="inputpic">Image</label>
                       <input type="file" class="form-control" id="inputpic" name="image" required accept="image/jpeg,image/jpg, image/x-png">
                       <div id="imgmsg">
                       </div>
                     </div>
                   </div>
                   <div class="form-group col-md-2">
                     <button type="submit" id="submit" name="submit" class="btn btn-primary">Add Driver</button>
                   </div>
                 </form>
                 <?php if($driversql->num_rows > 0) { ?>
                     <p style="text-align:center"> <b>Driver List</b> </p>
                     <table class='table table-hover' style='width:100%;'>
                       <thead>
                           <tr>
                             <th>ID</th>
                             <th>Fullname</th>
                             <th>NID</th>
                             <th>Phone</th>
                             <th>Address</th>
                             <th>Truck</th>
                             <th>Birth Date</th>
                             <th>Image</th>
                             <th>Action</th>
                           </tr>
                       </thead>
                       <tbody>
                           <?php while($row = $driversql->fetch_assoc()) { ?>
                               <tr>
                                   <td><?php echo $row['id']; ?></td>
                                   <td><?php echo $row['fullname']; ?></td>
                                   <td><?php echo $row['nid']; ?></td>
                                   <td><?php echo $row['phone']; ?></td>
                                   <td><?php echo $row['address']; ?></td>
                                   <td><?php echo $row['truck']; ?></td>
                                   <td><?php echo $row['birthdate']; ?></td>
                                   <td width="70px" height="70px"><img src="<?php echo $row['image']; ?>" alt="" style="width:100%; height:100%"></td>
                                   <td>
                                       <button type='button' class='btn btn-success' id='editdriver' data-toggle='modal' data-target='#exampleModal'
                                       data-id="<?php echo $row['id']; ?>;<?php echo $row['fullname']; ?>;<?php echo $row['nid']; ?>;<?php echo $row['phone']; ?>;<?php echo $row['address']; ?>;<?php echo $row['truck']; ?>;"
                                       data-whatever="<?php echo $row['image']; ?>"
                                       > Edit
                                   </button> &nbsp;
                                   <button type='button' class='btn btn-danger' id='deletedriver' data-id="<?php echo $row['id']; ?>"> Delete </button></td>
                               </tr>
                               <?php } ?>
                           </tbody>
                       </table>
                       <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                  <div class="modal-header" style="background-color:#003366; color:white;">
                                      <h5 class="modal-title" id="exampleModalLabel" style="font-weight:bold; font-size:17px;">Edit Profile</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span style="color:white;" aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                      <img src="" alt="" width="10%" height="10%" id="editimage">
                                      <form action="#" method="post">
                                          <div class="form-group">
                                              <label for="recipient-name" class="form-control-label">Driver ID:</label>
                                              <input type="text" value="" class="form-control" id="editid" disabled name="editid" required>
                                          </div>
                                          <div class="form-group">
                                              <label for="recipient-name" class="form-control-label">Full Name:</label>
                                              <input type="text" value="" class="form-control" id="editfullname" disabled name="editfullname" required>
                                          </div>
                                          <div class="form-group">
                                              <label for="message-text" class="form-control-label">National ID:</label>
                                              <input type="text" value="" class="form-control" id="editnid" name="editnid" disabled required onkeyup="validatephone(this);">
                                          </div>
                                          <div class="form-group">
                                              <label for="message-text" class="form-control-label">Phone:</label>
                                              <input type="text" value="" class="form-control" id="editphone" name="editphone" required onkeyup="validatephone(this);">
                                          </div>
                                          <div class="form-group">
                                              <label for="message-text" class="form-control-label">Address:</label>
                                              <input type="text" value="" class="form-control" id="editadd" name="editadd" required>
                                          </div>
                                          <div class="form-group">
                                              <label for="message-text" class="form-control-label">Truck:</label>
                                              <input type="text" value="" class="form-control" id="edittruck" name="edittruck" required>
                                          </div>
                                      </form>
                                  </div>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                      <button type="button" class="btn btn-primary" id="editsubmit">Edit Profile</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                     <?php }else{
                         echo "<p style='text-align:center'> <b><i>No Driver Found</i></b></p>";
                     } ?>
          </div>
      </div>
  </div>
  </div>
  <script type="text/javascript">
  $(document).ready(function(){
      $('.dropdownmenu').click(function() {
          var value = $(this).attr("data-id");
          if(value==1){
              $(".dropdownmenu").html('Open form');
              $(".dropdownmenu").attr('data-id', '2');
              $('.formslide').css("display", "block");
          }else{
              $('.formslide').css("display", "none");
              $(".dropdownmenu").html('Hide form');
              $(".dropdownmenu").attr('data-id', '1');
          }
          $('.formslide').toggle();
       });
    $("#inputpic").change(function () {
        var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            $("#imgmsg").html("Only formats are allowed : "+fileExtension.join(', '));
        }
    });
    $(document).on('click', '#deletedriver', function (){
        var id = $(this).attr('data-id');
        var dataType = "type=deletedriver&id="+id;
        $.ajax({
            type: "post",
            url: "editdriver.php",
            data: dataType,
            cache: false,
            success: function(result) {
                alert(result);
                location.reload();
            }
        });
    });
    $(document).on('click', '#editsubmit', function(){
        var id = $("#editid").val();
        var fullname = $("#editfullname").val();
        var nid = $("#editnid").val();
        var phone = $("#editphone").val();
        var address = $("#editadd").val();
        var truck = $("#edittruck").val();
        var dataType = "type=editdriver&id="+id+"&name="+fullname+"&nid="+nid+"&phone="+phone+"&address="+address+"&truck="+truck;
        $.ajax({
            type: "post",
            url: "editdriver.php",
            data: dataType,
            cache: false,
            success: function(result) {
                alert(result);
                location.reload();
            }
        });
    });
  });
  $('#exampleModal').on('show.bs.modal', function(event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var recipient = button.data('id') // Extract info from data-* attributes
          // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
          // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
          var image = button.data('whatever')
          var modal = $(this)

          var client = recipient.split(";")
          modal.find('#editid').val(client[0])
          modal.find('#editfullname').val(client[1])
          modal.find('#editnid').val(client[2])
          modal.find('#editphone').val(client[3])
          modal.find('#editadd').val(client[4])
          modal.find('#edittruck').val(client[5])
          modal.find('#editimage').attr('src', image)

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
