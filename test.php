<!-- <?php
ob_start();
function password_encrypt($password){
		$hash_format = "$2y$10$";
		$salt_length = 22;
		$salt = generate_salt($salt_length);
		$format_and_salt = $hash_format . $salt;
		$hash = crypt($password, $format_and_salt);
		return $hash;

	}

	function generate_salt($length){
		$unique_random_string = md5(uniqid(mt_rand(), true));
		$base64_string = base64_encode($unique_random_string);
		$modified_base64_string = str_replace('+', '-', $base64_string);
		$salt = substr($modified_base64_string, 0, $length);
		return $salt;
	}

  $val = password_encrypt("supertest");
  //echo $val;
?> -->
<!-- Button trigger modal -->
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
  </head>
  <body>
      <div id="latlng">
          23.778483,90.416884
      </div>
      <input type="hidden" name="ed" id="hello">
      <div id="googleMap" style="width:70%;height:500px; margin:1em 0em 1em 0em; padding-left:15%; text-align:center"></div>
      <script>
      var longval = 90.405686;
      var lati = 23.780786;
      function initMap() {
          var geocoder = new google.maps.Geocoder;
         var myCenter = new google.maps.LatLng(23.844766,90.253290);
         var directionsService = new google.maps.DirectionsService;
         var directionsDisplay = new google.maps.DirectionsRenderer;
         var map = new google.maps.Map(document.getElementById('googleMap'), {
           zoom: 6,
           center: myCenter
         });
         directionsDisplay.setMap(map);
       }
       
      </script>

      <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYRKN2Ws4VtVfD6V5HYiddvlcxsv8CODM&callback=initMap">
    </script>
  </body>
</html>
