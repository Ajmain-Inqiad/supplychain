<?php require_once ("dbconnect.php"); ?>
<?php require_once ('includes/client_header.php'); ?>
              <!-- Main Menu -->
              <div class="side-menu-container">
                  <ul class="nav navbar-nav">
                      <li class="active"><a href="client.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                      <li><a href="makeorder.php"><span class="glyphicon glyphicon-shopping-cart"></span>Give Order</a></li>
                      <li><a href="checkorder.php"><span class="glyphicon glyphicon-saved"></span>Placed Order</a></li>
                      <li><a href="trackproduct.php"><span class="glyphicon glyphicon-map-marker"></span>Product Location </a></li>
                      <li><a href="clientsetting.php"><span class="glyphicon glyphicon-cog"></span>Profile Setting </a></li>
                      <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>

                  </ul>
              </div><!-- /.navbar-collapse -->
          </nav>

      </div>

      <!-- Main Content -->
      <div class="container-fluid">
          <div class="side-body">
             <h1 id="msg"> </h1>
             <pre> <b> Welcome <?php echo ucfirst($username); ?></b> </pre>
          </div>
      </div>
  </div>
<?php require_once ('includes/client_footer.php'); ?>
