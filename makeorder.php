<?php require_once ("dbconnect.php"); ?>
<?php require_once ('includes/client_header.php'); ?>
<?php
$query="SELECT * FROM client WHERE username='$username' LIMIT 1";
$result = $connect->query($query);
$row = $result->fetch_assoc();
$id = $row['id'];
$name = $row['fullname'];
$email = $row['email'];
$address = $row['address'];
$phone = $row['phone'];
$today=date('Y-m-d');
?>
<script src="https://js.braintreegateway.com/js/braintree-2.31.0.min.js"></script>
<script>
    $.ajax({
        url: "token.php",
        type: "get",
        dataType: "json",
        success: function(data) {
            braintree.setup(data, 'dropin', {container: 'dropin-container'});
        }
    });
</script>
              <div class="side-menu-container">
                  <ul class="nav navbar-nav">
                      <li><a href="client.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                      <li class="active"><a href="makeorder.php"><span class="glyphicon glyphicon-shopping-cart"></span>Give Order</a></li>
                      <li><a href="checkorder.php"><span class="glyphicon glyphicon-saved"></span>Placed Order</a></li>
                      <li><a href="trackproduct.php"><span class="glyphicon glyphicon-map-marker"></span>Product Location </a></li>
                      <li><a href="clientsetting.php"><span class="glyphicon glyphicon-cog"></span>Profile Setting </a></li>
                      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>

                  </ul>
              </div><!-- /.navbar-collapse -->
              </nav>

        </div>
        <div class="container-fluid">
          <br>
            <div class="side-body">
              <form method="post" action="placeorder.php">
                  <div class="form-row">
                      <div class="form-group col-md-4">
                        <label for="inputname">Company Name</label>
                        <input type="name" class="form-control" id="inputname" name="name" disabled required value="<?php echo $name; ?>">
                      </div>
                      <div class="form-group col-md-4">
                        <label for="inputemail">Email</label>
                        <input type="email" class="form-control" id="inputemail" name="email" disabled required value="<?php echo $email; ?>">
                      </div>
                      <div class="form-group col-md-4">
                        <label for="inputphone">Phone</label>
                        <input type="text" class="form-control" id="inputphone" name="phone" disabled required value="<?php echo $phone; ?>">
                      </div>
                    </div>
                    <div class="form-group col-md-12">
                      <label for="inputAddress">Address</label>
                      <input type="text" class="form-control" id="inputAddress" name="address" disabled required value="<?php echo $address; ?>">
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="inputproduct">Product Name</label>
                        <input type="text" class="form-control" id="inputproduct" name="product" placeholder="Product Name"  required>
                      </div>
                      <div class="form-group col-md-4">
                        <label for="inputprority">Priority</label>
                        <select id="inputprority" name="prority" class="form-control"  required>
                          <option value="">Choose...</option>
                          <option value="5">Normal</option>
                          <option value="1">Highest</option>
                        </select>
                      </div>
                      <div class="form-group col-md-2">
                        <label for="inputamount">Amount</label>
                        <input type="text" class="form-control" name="amount" id="inputamount" onkeyup="validateamount(this);"  required>
                      </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                          <label for="inputprice">Total Price</label>
                          <input type="text" class="form-control" disabled id="inputprice" name="price" required> USD
                          <input type="hidden" class="form-control" id="inputpriced" name="priced" required>
                          <input type="text" class="form-control" disabled id="inputpricebd" name="pricing" required> BDT
                        </div>
                        <div class="form-group col-md-4">
                          <label for="inputodate">Ordering Date (yyyy-mm-dd)</label>
                          <input type="text" class="form-control" id="inputodate" disabled name="orderdate" value="<?php echo $today; ?>" required>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="inputddate">Delivery Date (yyyy-mm-dd)</label>
                          <input type="text" class="form-control" disabled id="inputddate" name="deliverydate" required>
                        </div>
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-12">
                              <div id="dropin-container">
                    		  </div>
                          </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-2">
                          <button type="submit" id="submit" name="submit" class="btn btn-primary">Place Order</button>
                        </div>
                        <div class="form-group col-md-2">
                          <a href="showproduct.php" class="buttonproduct">Product List</a>
                        </div>
                    </div>
                  </form>
               </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function(){
      $('#inputprority').change(function(){
        var priority= $('#inputprority').val();
        var today = new Date();
        if(priority==5){
          today.setDate( today.getDate() + 10 );
          var month= today.getMonth()+1;
          if(month < 10){
            month = "0"+month;
          }
          var delivery = today.getFullYear() + "-" + month + "-" + today.getDate();
          $('#inputddate').val(delivery);
        }else if (priority==1) {
          today.setDate( today.getDate() + 7 );
          var month= today.getMonth()+1;
          if(month < 10){
            month = "0"+month;
          }
          var delivery = today.getFullYear() + "-" + month + "-" + today.getDate();
          $('#inputddate').val(delivery);
      }else{
          $('#inputddate').val("");
      }
      });
      $('#inputamount').keyup(function(){
          var product_price = $('#inputproduct').val();
          var product_amount = $('#inputamount').val();
          if((product_price != "") && (product_amount != "")){
              dataType = "type=price&product="+product_price+"&amount="+product_amount;
              $.ajax({
                  type: "post",
                  url: "check_validity.php",
                  data: dataType,
                  cache: false,
                  success: function(result){
                      $('#inputprice').val(result/80);
                      $('#inputpriced').val(result/80);
                      $('#inputpricebd').val(result);
                  }
              });
          }else{
              $('#inputprice').val("");
              $('#inputpriced').val("");
              $('#inputpricebd').val("");
          }
      });
      });
    function validateamount(amount)
    {
        var maintainplus = '';
        var numval = amount.value;
        if ( numval.charAt(0)=='+' )
        {
            var maintainplus = '';
        }
        curphonevar = numval.replace(/[\\A-Za-z!"£$%^&\,*+_={};:'@#~,.Š\/<>?|`¬\]\[]/g,'');
        amount.value = maintainplus + curphonevar;
        var maintainplus = '';
        amount.focus;
    }



    </script>
<?php require_once ('includes/client_footer.php'); ?>
