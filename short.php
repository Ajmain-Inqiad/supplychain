<?php require_once "dbconnect.php"; ?>
<?php

function arrayreturns($lat, $long, $client, $connect)
{
    $result = array();
    for ($i=0; $i < count($client) ; $i++) {    # code...
        $id = $client[$i];
        $query = $connect->query("SELECT lat, longti FROM client WHERE id='$id'");
        $row = $query->fetch_assoc();
        $clientlat = ($lat - $row['lat']) * ($lat - $row['lat']);
        $clientlong = ($long - $row['longti']) * ($long - $row['longti']);
        $clientdistance = $clientlong + $clientlat;
        $result[$id] = $clientdistance;
        //echo $id . " distance from savar: " . $clientdistance . "<br>";
    }
    asort($result);
    return $result;
}

$start_lat = 23.844766;
$start_long = 90.253290;
$client = array(1,3,4,7,8);
$result = arrayreturns($start_lat, $start_long, $client, $connect);
$addressarray = array();
foreach ($result as $key => $value) {
    $sql = $connect->query("SELECT address FROM client WHERE id='$key'");
    $row = $sql->fetch_assoc();
    $addressarray["client". $key] = $row['address'];
}
$jsonsave = json_encode($addressarray,  JSON_PRETTY_PRINT);
 ?>
 <!DOCTYPE html>
 <html>
     <head>
         <meta charset="utf-8">
         <title></title>
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
     </head>
     <body>
         <select class="" name="">
             <option value="">Choose</option>
             <?php foreach ($result as $key => $value) { ?>
                 <option value="<?php echo $key; ?>"><?php echo $addressarray["client".$key]; ?></option>
             <?php } ?>
         </select>
         <br>
         Start point: <div id="start">N5, Savar Union 1340</div>
         End point: <div id="end"><?php echo end($addressarray); ?></div>
         <div id="googleMap" style="width:70%;height:500px; margin:1em 0em 1em 0em; padding-left:15%; text-align:center"></div>
         <div id="map">
         </div>
         <div id="directions-panel"></div>
         <script>
             var start = document.getElementById("start").innerHTML;
             var end = document.getElementById("end").innerHTML;
             var jsondata = <?php echo json_encode($addressarray) ?>;
             var address = [];
             $.each(jsondata, function(key, value) {
                 address.push(value);
             });
             //console.log(address);
             function initMap() {
                var myCenter = new google.maps.LatLng(23.844766,90.253290);
                var directionsService = new google.maps.DirectionsService;
                var directionsDisplay = new google.maps.DirectionsRenderer;
                var map = new google.maps.Map(document.getElementById('googleMap'), {
                  zoom: 6,
                  center: myCenter
                });
                directionsDisplay.setMap(map);
                calculateAndDisplayRoute(directionsService, directionsDisplay);
              }
              function calculateAndDisplayRoute(directionsService, directionsDisplay) {
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
                    console.log(route);
                    var summaryPanel = document.getElementById('directions-panel');
                    summaryPanel.innerHTML = '';
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
         </script>
         <script async defer src="https://maps.googleapis.com/maps/api/js?key=Key&callback=initMap"></script>
     </body>
 </html>
