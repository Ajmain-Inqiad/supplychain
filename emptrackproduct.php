<?php require_once ("dbconnect.php"); ?>
<?php require_once ('includes/employee_header.php'); ?>
<?php require_once("function.php"); ?>
<?php
$latitude = "";
$longtitude = "";
$jsonsave = "";
$truck = 0;
$endpoint = "";
if(isset($_GET['submit'])){
    $truck = $_GET['truck'];
    $trucksql = $connect->query("SELECT client_id FROM shipment WHERE truck='$truck' AND recieved='no'");
    if($trucksql->num_rows > 0){
        if($truck == 10){
            $json = file_get_contents('https://api.thingspeak.com/channels/409679/feeds.json?results=2');
            $obj = json_decode($json);
            $lati = end($obj->feeds)->field1;
            $longti = end($obj->feeds)->field2;
            //$lati="2346.88481";
            //$longti = "09040.41653";
            $latitude = $lati;
            $longtitude = $longti;
            $clientarray = array();
            $i=0;
            while($row = $trucksql->fetch_assoc()){
                $clientarray[$i] = $row['client_id'];
                $i++;
            }
            $result = arrayreturns($latitude, $longtitude, $clientarray, $connect);
            $addressarray = array();
            foreach ($result as $key => $value) {
                $sql = $connect->query("SELECT address FROM client WHERE id='$key'");
                $row = $sql->fetch_assoc();
                $addressarray["client". $key] = $row['address'];
            }
            $endpoint = end($addressarray);
            $jsonsave = json_encode($addressarray,  JSON_PRETTY_PRINT);
        }
    }
}

?>
              <!-- Main Menu -->
              <meta http-equiv="refresh" content="46">
              <div class="side-menu-container">
                  <ul class="nav navbar-nav">
                      <li><a href="employee.php"><span class="glyphicon glyphicon-home"></span>Home</a></li>
                      <li><a href="empcheckorder.php"><span class="glyphicon glyphicon-save"></span>Check Order</a></li>
                      <?php if($_SESSION['job_type'] == "Manager") { ?>
                      <li><a href="addemp.php"><span class="glyphicon glyphicon-cloud-upload"></span>Add Employee</a></li>
                      <li><a href="addproduct.php"><span class="glyphicon glyphicon-paperclip"></span>Add Product</a></li>
                      <li><a href="shipmentreq.php"><span class="glyphicon glyphicon-road"></span>Shipment Request</a></li>
                      <li class="active"><a href="emptrackproduct.php"><span class="glyphicon glyphicon-map-marker"></span>Vehicle Location</a></li>
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
             <pre> <b> Track Product </b> </pre>
             <br>
             <p>Page will auto reload after each 46sec</p>
             <input type="hidden" name="ed" id="hello">
             <form action="#" method="get">
                 <label for="truck">Truck Number: </label>
                 <input type="text" name="truck" placeholder="Truck number" id="truck"> &nbsp;
                 <input type="submit" name="submit" value="Submit">
             </form>
             <br>
             <div id="googleMap" style="width:100%;height:500px; margin:1em 0em 1em 0em; padding-left:15%; float:right"></div>
             <div id="directions-panel"></div>
          </div>
      </div>
  </div>
  </div>
  <script>
  var lati = parseFloat("<?php echo $latitude; ?>");
  var longval = parseFloat("<?php echo $longtitude; ?>");
  var truck = "<?php echo $truck; ?>";
  var end = "<?php echo $endpoint; ?>";
  var address = [];
  if(lati != 0.0 && longval != 0.0){
      var jsondata = <?php echo $jsonsave; ?>;
      $.each(jsondata, function(key, value) {
          address.push(value);
      });
      var myCenter=new google.maps.LatLng(lati,longval);
      var geocoder = new google.maps.Geocoder;
      var directionsService = new google.maps.DirectionsService;
      var directionsDisplay = new google.maps.DirectionsRenderer;
      function initialize() {
        var mapProp = {
          center:myCenter,
          zoom:6,
          mapTypeId:google.maps.MapTypeId.RoadMap
        };
        var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
        directionsDisplay.setMap(map);
        geocodeLatLng(geocoder, map);
        setTimeout(function(){
            var start = document.getElementById('hello').value;
            calculateAndDisplayRoute(start, end, directionsService, directionsDisplay);
        }, 1000);

      }
      google.maps.event.addDomListener(window, 'load', initialize);

      function geocodeLatLng(geocoder, map) {
       var latlng = {lat: lati, lng: longval};
       var add = "";
       geocoder.geocode({'location': latlng}, function(results, status) {
         if (status === 'OK') {
           if (results[0]) {
             add = results[0].formatted_address;
             var summaryPanel = document.getElementById('hello');
             summaryPanel.value = add;
             //return add;
           } else {
             window.alert('No results found');
           }

         } else {
           window.alert('Geocoder failed due to: ' + status);
         }
       });
     }

     function calculateAndDisplayRoute(start, end, directionsService, directionsDisplay) {
       var waypts = [];
       for (var i = 0; i < address.length-1; i++) {
           waypts.push({
             location: address[i],
             stopover: true
           });
       }
       //console.log(waypts);
       directionsService.route({
         origin: start,
         destination: end,
         waypoints: waypts,
         optimizeWaypoints: true,
         travelMode: 'DRIVING'
       }, function(response, status) {
         if (status === 'OK') {
           directionsDisplay.setDirections(response);
           var route = response.routes[0];
           var summaryPanel = document.getElementById('directions-panel');
           summaryPanel.innerHTML = '<b>Truck Number: </b>' + truck + '<br>';
           // For each route, display summary information.
           for (var i = 0; i < route.legs.length; i++) {
             var routeSegment = i + 1;
             summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +
                 '</b><br> Estimated Time: ' + route.legs[i].duration.text+'<br>';
             summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
             summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
             summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
           }
         } else {
           window.alert('Directions request failed due to ' + status);
         }
       });
     }
  }else{

  }

  </script>
<?php require_once ('includes/employee_footer.php'); ?>
