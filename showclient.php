<?php require_once ("dbconnect.php"); ?>
<?php require_once ('includes/employee_header.php'); ?>
<?php
$dhakasql = $connect->query("SELECT * FROM client WHERE division='dhaka'");
$dhakarow = $dhakasql->num_rows ;
$dhakasql = $connect->query("SELECT * FROM client WHERE division='chittagong'");
$chittagong = $dhakasql->num_rows ;
$dhakasql = $connect->query("SELECT * FROM client WHERE division='mymensingh'");
$mymensingh = $dhakasql->num_rows ;
$dhakasql = $connect->query("SELECT * FROM client WHERE division='khulna'");
$khulna = $dhakasql->num_rows ;
$dhakasql = $connect->query("SELECT * FROM client WHERE division='barisal'");
$barisal = $dhakasql->num_rows ;
$dhakasql = $connect->query("SELECT * FROM client WHERE division='sylhet'");
$sylhet = $dhakasql->num_rows ;
$rajshahisql = $connect->query("SELECT * FROM client WHERE division='rajshahi'");
$rajshahirow = $rajshahisql->num_rows ;
$rangpursql = $connect->query("SELECT * FROM client WHERE division='rangpur'");
$rangpurrow = $rangpursql->num_rows ;
?>
            <div class="side-menu-container">
                <ul class="nav navbar-nav">
                    <li><a href="employee.php"><span class="glyphicon glyphicon-home"></span>Home</a></li>
                    <li><a href="empcheckorder.php"><span class="glyphicon glyphicon-save"></span>Check Order</a></li>
                    <?php if($_SESSION['job_type'] == "Manager") { ?>
                    <li><a href="addemp.php"><span class="glyphicon glyphicon-cloud-upload"></span>Add Employee</a></li>
                    <li><a href="addproduct.php"><span class="glyphicon glyphicon-paperclip"></span>Add Product</a></li>
                    <li><a href="shipmentreq.php"><span class="glyphicon glyphicon-road"></span>Shipment Request</a></li>
                    <li><a href="emptrackproduct.php"><span class="glyphicon glyphicon-map-marker"></span>Vehicle Location</a></li>
                    <li class="active"><a href="showclient.php"><span class="glyphicon glyphicon-equalizer"></span>Client Graph</a></li>
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
            <div class="container-fluid">
                <div class="side-body">
                    <br>
                   <pre> <b>Client list</b> </pre>
                   <br>
                   <canvas id="myChart" width="100px" height="45px"></canvas>
                </div>
            </div>
        </div>

        <script>
        var ctx = document.getElementById("myChart").getContext('2d');
        var rangpur = "<?php echo $rangpurrow; ?>";
        var dhaka = "<?php echo $dhakarow; ?>";
        var ctg = "<?php echo $chittagong; ?>";
        var mymen = "<?php echo $mymensingh; ?>";
        var khul = "<?php echo $khulna; ?>";
        var bari = "<?php echo $barisal; ?>";
        var syl = "<?php echo $sylhet; ?>";
        var raj =  "<?php echo $rajshahirow; ?>";
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Dhaka", "Chittagong", "Mymensingh", "Khulna", "Barisal", "Sylhet", "Rajshahi", "Rangpur"],
                datasets: [{
                    label: 'Number of client in each division',
                    data: [dhaka, ctg, mymen, khul, bari, syl, raj, rangpur],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(42, 152, 51, 0.2)',
                        'rgba(124, 61, 29, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(42, 152, 51, 1)',
                        'rgba(124, 61, 29, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
        </script>
<?php require_once ('includes/employee_footer.php'); ?>
