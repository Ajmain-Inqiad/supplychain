<?php require_once ("dbconnect.php"); ?>
<?php require_once ('includes/admin_header.php'); ?>
              <!-- Main Menu -->
              <div class="side-menu-container">
                  <ul class="nav navbar-nav">
                      <li><a href="admin.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                      <li><a href="employeeList.php"><span class="glyphicon glyphicon-user"></span>Employee List</a></li>
                      <li class="active"><a href="orderlist.php"><span class="glyphicon glyphicon-th-list"></span> Order List </a></li>
                      <li><a href="clientlist.php"><span class="glyphicon glyphicon-briefcase"></span> Client List </a></li>
                      <li><a href="adminsetting.php"><span class="glyphicon glyphicon-cog"></span> Profile Setting </a></li>
                      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>

                  </ul>
              </div><!-- /.navbar-collapse -->
          </nav>

      </div>
      <div class="container-fluid">
          <div class="side-body">
            <br>
             <pre style="text-align:center"> <b>Order List based on Priority</b> </pre>
             <br>
             <select id="order" class="form-control">
               <option value="">Select Option</option>
                 <option value="neworder">New Order</option>
                 <option value="approved">Approved</option>
             </select>
             <br>
             <br>
             <div id="tableinfo">
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
                             <label for="recipient-name" class="form-control-label">Recipient:</label>
                             <input type="text" value="" class="form-control" id="recipient-name" disabled>
                         </div>
                         <div class="form-group">
                             <label for="message-text" class="form-control-label">Message:</label>
                             <textarea class="form-control" id="message-text" required></textarea>
                         </div>
                     </form>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     <button type="button" class="btn btn-primary" id="submit">Send message</button>
                 </div>
             </div>
         </div>
     </div>
     <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <label for="recipient-name" class="form-control-label">Recipient:</label>
                            <input type="text" value="" class="form-control" id="recipient-name2" disabled>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="form-control-label">Assign Manager:</label>
                            <select id="manager" class="form-control">
                              <option value="">Select Option</option>
                                <?php
                                $query = $connect->query("SELECT * FROM employee WHERE job_type='manager'");
                                while($row = $query->fetch_assoc()){ ?>
                                  <option value="<?php echo $row['username']; ?>"><?php echo $row['fullname']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="form-control-label">Message:</label>
                            <textarea class="form-control" id="message-text2" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="approvesubmit">Send message</button>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
var dataType = "";
var type = "";
var orderid = "";
$(document).ready(function() {
    $("#order").change(function() {
        var order = $(this).val();
        dataType = "type=" + order;
        $.ajax({
            type: "post",
            url: "get_select_order.php",
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
        var client = recipient.split(" ")
        type = client[1]
        orderid = client[2]
        modal.find('.modal-title').text('New message to ' + client[0])
        modal.find('.modal-body input').val(client[0])
});
$('#exampleModal2').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        var client = recipient.split(" ")
        type = client[1]
        orderid = client[2]
        modal.find('.modal-title').text('New message to ' + client[0])
        modal.find('.modal-body input').val(client[0])
});
$(document).ready(function (){
        $(document).on('click', '#submit', function (){
                var client = $('#recipient-name').val();
                var body = $('#message-text').val();
                $.ajax({
                type: "post",
                url: "sendmail.php",
                data: "client="+client+"&body="+body+"&type="+type+"&order="+orderid,
                cache: false,
                success: function(result){
                    alert(result);
                    $.ajax({
                      type: "post",
                      url: "get_select_order.php",
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
        $(document).on('click', '#approvesubmit', function (){
                var client = $('#recipient-name2').val();
                var body = $('#message-text2').val();
                var manager = $('#manager').val();
                $.ajax({
                type: "post",
                url: "sendmail.php",
                data: "client="+client+"&body="+body+"&type="+type+"&order="+orderid+"&manager="+manager,
                cache: false,
                success: function(result){
                    alert(result);
                    $.ajax({
                      type: "post",
                      url: "get_select_order.php",
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


<?php require_once ('includes/admin_footer.php'); ?>
