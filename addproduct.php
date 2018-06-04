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
$msg="";
if(isset($_POST["submit"])){
    $target_file = "img/product/" . basename($_FILES['image']['name']);
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
        $description = $_POST['description'];
        $category = $_POST['category'];
        $cost = $_POST['cost'];
        $image = $_FILES['image']['name'];
        $productsql = "SELECT name FROM product WHERE name='$fullname'";
        $product_result = $connect->query($productsql);
        if($product_result->num_rows == 0){
            if(move_uploaded_file($_FILES['image']['tmp_name'], $target_file)){
                $sql = "INSERT INTO product (name, description, category, price, image) VALUES ('$fullname', '$description', '$category', '$cost', '$target_file')";
                $result = $connect->query($sql);
                if($result){
                    $msg="Product added successfully";
                }else{
                    $msg = "Add error";
                }
            }else{
                $msg = "File saving error. Please try again.";
            }
        }else{
            $msg = "Name is in use";
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
                      <li class="active"><a href="addproduct.php"><span class="glyphicon glyphicon-paperclip"></span>Add Product</a></li>
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
             <pre> <b>Add Product</b></pre>
             <?php if($msg != "") { ?>
                 <p style="color:red"><?php echo $msg; ?></p>
                 <?php } ?>
             <form method="post" action="#" enctype="multipart/form-data">
                 <div class="form-row">
                     <div class="form-group col-md-6">
                       <label for="inputname">Model Name</label>
                       <input type="text" class="form-control" id="inputname" name="name" required placeholder="Model name">
                       <div id="modelmsg">
                       </div>
                     </div>
                     <div class="form-group col-md-6">
                       <label for="inputcat">Category</label>
                       <input type="text" class="form-control" id="inputcat" name="category" required placeholder="Category">
                     </div>
                   </div>
                   <div class="form-group col-md-12">
                     <label for="inputdes">Address</label>
                     <input type="text" class="form-control" id="inputdes" name="description" required placeholder="Description">
                   </div>
                   <div class="form-row">
                       <div class="form-group col-md-4">
                         <label for="inputcost">Price per unit in BDT</label>
                         <input type="text" class="form-control" id="inputcost" name="cost" required placeholder="Price" onkeyup="validatephone(this);">
                       </div>
                       <div class="form-group col-md-8">
                         <label for="inputpic">Image</label>
                         <input type="file" class="form-control" id="inputpic" name="image" required accept="image/jpeg,image/jpg, image/x-png">
                         <div id="imgmsg">
                         </div>
                       </div>
                     </div>
                   <div class="form-group col-md-2">
                     <button type="submit" id="submit" name="submit" class="btn btn-primary">Add Product</button>
                   </div>
                 </form>
          </div>
      </div>
  </div>
  </div>
  <script type="text/javascript">
  $(document).ready(function(){
    $('#inputname').keyup(function(){
      var user = $(this).val();
      dataType = "type=searchpro&product="+user ;
      $.ajax({
        type: "post",
        url: "check_validity.php",
        data: dataType,
        cache: false,
        success: function(result) {
            $("#modelmsg").html(result);
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
