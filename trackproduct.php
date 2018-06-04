<meta http-equiv="refresh" content="46">
<?php require_once ("dbconnect.php"); ?>
<?php require_once ('includes/client_header.php'); ?>
<?php require_once("function.php"); ?>
<?php
$latitude = "";
$longtitude = "";
$jsonsave = "";
$checkaddress = 0;
$truck = 0;
$client = $connect->query("SELECT id,address FROM client WHERE username='$username'");
$row = $client->fetch_assoc();
$clientid = $row['id'];
$address = $row['address'];
$sql = "SELECT * FROM shipment WHERE client_id='$clientid' AND recieved='no'";
$result = $connect->query($sql);
if($result->num_rows > 0){
    $sql = $connect->query("SELECT truck FROM shipment WHERE client_id='$clientid' AND recieved='no'");
    $row = $sql->fetch_assoc();
    $truck = $row['truck'];
    if($truck == 10){
        $json = file_get_contents('https://api.thingspeak.com/channels/409679/feeds.json?results=2');
        $obj = json_decode($json);
        $lati = end($obj->feeds)->field1;
        $longti = end($obj->feeds)->field2;
        $latitude = $lati;
        $longtitude = $longti;
        $clientarray = array();
        $i=0;
        $trucksql = $connect->query("SELECT client_id FROM shipment WHERE recieved='no' AND truck='$truck'");
        while($row = $trucksql->fetch_assoc()){
            $clientarray[$i] = $row['client_id'];
            $i++;
        }
        $result = arrayreturns($latitude, $longtitude, $clientarray, $connect);
        $addressarray = array();
        $clientkey = "client".$clientid;
        foreach ($result as $key => $value) {
            $sql = $connect->query("SELECT address FROM client WHERE id='$key'");
            $row = $sql->fetch_assoc();
            $addressarray["client". $key] = $row['address'];
        }
        $checkaddress = 0;
        foreach ($addressarray as $key => $value) {
            if($key == $clientkey){
                break;
            }
            $checkaddress++;
        }
        $jsonsave = json_encode($addressarray,  JSON_PRETTY_PRINT);
    }
}else{
    $latitude = "";
    $longtitude = "";
}

?>
            <div class="side-menu-container">
                <ul class="nav navbar-nav">
                    <li><a href="client.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                    <li><a href="makeorder.php"><span class="glyphicon glyphicon-shopping-cart"></span>Give Order</a></li>
                    <li><a href="checkorder.php"><span class="glyphicon glyphicon-saved"></span>Placed Order</a></li>
                    <li class="active"><a href="trackproduct.php"><span class="glyphicon glyphicon-map-marker"></span>Product Location </a></li>
                    <li><a href="clientsetting.php"><span class="glyphicon glyphicon-cog"></span>Profile Setting </a></li>
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>

                </ul>
            </div><!-- /.navbar-collapse -->
            </nav>

            </div>
            <div class="container-fluid">
                <div class="side-body">
                    <br>

                   <pre> <b> Track Product</b> </pre>
                       <br>
                       <input type="hidden" name="ed" id="hello">
                       <p>Page will auto reload after each 46 sec</p>
                       <?php
                       if($longtitude != "" && $latitude !=""){?>
                    <div id="googleMap" style="width:100%;height:500px; margin:1em 0em 1em 0em; padding-left:15%; float:right"></div>
                    <div id="directions-panel"></div>
                       <?php
                   }else{?>
                        <p>You have no poduct to track</p>
                   <?php
                    }
                       ?>

                </div>
            </div>
        </div>
    </div>
        <script>
	
        var lati = parseFloat("<?php echo $latitude; ?>");
        var longval = parseFloat("<?php echo $longtitude; ?>");
        var truck = "<?php echo $truck; ?>";
        var address = [];
        var checkpoint = "<?php echo $checkaddress; ?>";
        if(lati != 0.0 && longval != 0.0){
            var jsondata = <?php echo $jsonsave; ?>;
            $.each(jsondata, function(key, value) {
                address.push(value);
            });
            var myCenter=new google.maps.LatLng(lati,longval);
            var geocoder = new google.maps.Geocoder;
            var directionsService = new google.maps.DirectionsService;
            var directionsDisplay = new google.maps.DirectionsRenderer;
            var end = "<?php echo $address; ?>";
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
             for (var i = 0; i < checkpoint ; i++) {
                 waypts.push({
                   location: address[i],
                   stopover: true
                 });
             }
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
                 summaryPanel.innerHTML = '';
                 var time = 0;
                 for (var i = 0; i < route.legs.length; i++) {
                     time += parseInt(route.legs[i].duration.text);
                 }
                 summaryPanel.innerHTML += 'Estimated Time: '+time +' mins<br>';
                 summaryPanel.innerHTML += 'It will be delivered after ' + checkpoint + ' order<br><br><br>';
               } else {
                 window.alert('Directions request failed due to ' + status);
               }
             });
           }
        }else{

        }

		</script>
<?php require_once ('includes/client_footer.php'); ?>
