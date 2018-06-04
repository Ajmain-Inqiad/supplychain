<?php require_once ("dbconnect.php"); ?>
<?php require_once ('includes/admin_header.php'); ?>
              <!-- Main Menu -->
              <div class="side-menu-container">
                  <ul class="nav navbar-nav">
                      <li><a href="admin.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                      <li><a href="employeeList.php"><span class="glyphicon glyphicon-user"></span>Employee List</a></li>
                      <li><a href="orderlist.php"><span class="glyphicon glyphicon-th-list"></span> Order List </a></li>
                      <li class="active"><a href="clientlist.php"><span class="glyphicon glyphicon-briefcase"></span> Client List </a></li>
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
             <pre style="text-align:center"> <b>Client List</b> </pre>
             <div class="row">
                <label class="col-md-2 control-label" for="rolename" style="float:left;">Client Type</label>
                <div class="col-md-4" style="float:left;">
                  <div style="text-align:center;">
                      <select id="client" class="form-control">
                        <option value="">Select Option</option>
                        <option value="reqclient">Requested Client</option>
                        <option value="currentclient">Current Client</option>
                      </select>
                  </div>
                </div>
                <div class="col-md-4" style="float:right;">
                  <form class="navbar-form" role="search">
                     <div class="input-group">
                         <input type="text" class="form-control" placeholder="Search current client" name="srch-term" id="srch-term">
                         <div class="input-group-btn">
                             <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                         </div>
                     </div>
                 </form>
                </div>
               </div>
               <br>
               <div id="tableinfo">
                 <p style="text-align: center"> <b> Current Client list </b></p>
                 <table class="table table-hover" style="width:100%;">
                   <thead>
                       <tr>
                         <th>ID</th>
                         <th>Full Name</th>
                         <th>Email</th>
                         <th>Phone</th>
                         <th>Address</th>
                         <th>Action</th>
                       </tr>
                   </thead>

                   <tbody>
                     <?php
                     $query = $connect->query("SELECT * FROM client");
                     while($row = $query->fetch_assoc()){?>
                       <tr>
                         <td><?php echo $row['id']; ?></td>
                         <td><?php echo $row['fullname']; ?></td>
                         <td><?php
                         $email = $row['email'];
                         echo $row['email']; ?></td>
                         <td><?php echo $row['phone']; ?></td>
                         <td><?php echo $row['address']; ?></td>
                         <td><button type='button' class='btn btn-danger' id='delete' data-toggle='modal' data-target='#exampleModal' data-whatever="<?php echo $email; ?> deletecurrentclient"> Delete </button></td>
                       </tr>
                     <?php
                   }
                     ?>
                   </tbody>
                 </table>
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
      </div>
  </div>
  <script type="text/javascript">
       $(document).ready(function(){
         $('#srch-term').keyup(function(){
           var name= $(this).val();
           $.post('get_client.php', { name:name }, function(data){
             $('#tableinfo').html(data);
           });
         });
       });

      var dataType = "";
      var type="";
      var demo="";
      if(type==""){
        type="currentclient";
      }
      $(document).ready(function() {
          $("#client").change(function() {
              var data = $(this).val();
              dataType = "type=" + data;
              $.ajax({
                  type: "post",
                  url: "get_select_client.php",
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
              demo=type
              modal.find('.modal-title').text('New message to ' + client[0])
              modal.find('.modal-body input').val(client[0])
              if(demo=="approvereqclient"){
                modal.find('.modal-body textarea').val("Your account has been approved. Please login with your username and password.")
                demo = ""
              }
      });

      $(document).ready(function (){
              $(document).on('click', '#submit', function (){
                      var client = $('#recipient-name').val();
                      var body = $('#message-text').val();
                      $.ajax({
                      type: "post",
                      url: "sendmail.php",
                      data: "client="+client+"&body="+body+"&type="+type+"&order="+1,
                      cache: false,
                      success: function(result){
                          alert(result);
                          if(type=="deletecurrentclient"){
                            type="currentclient";
                          }else if(type=="approvereqclient"){
                            type="reqclient";
                          }else if (type=="deletereqclient") {
                            type="reqclient";
                          }
                          $.ajax({
                            type: "post",
                            url: "get_select_client.php",
                            data: "type="+type,
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
