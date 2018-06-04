<?php require_once("function.php"); ?>
<?php
$json = file_get_contents('https://api.thingspeak.com/channels/409679/feeds.json?results=2');
$obj = json_decode($json);
$lati = end($obj->feeds)->field1;
$longti = end($obj->feeds)->field2;
$latitude = "23.7801569";
$longtitude = "90.4071984";
?>


<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
        <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYRKN2Ws4VtVfD6V5HYiddvlcxsv8CODM">
        </script>
    </head>

    <body>
			<div id="googleMap" style="width:70%;height:500px; margin:1em 0em 1em 0em; padding-left:15%; text-align:center"></div>
            <div class="mypanel"></div>

    <script>
    var address = "66, mohakhali; dhaka;";
    $.getJSON("https://maps.googleapis.com/maps/api/geocode/json?address="+address+"&key=AIzaSyAYRKN2Ws4VtVfD6V5HYiddvlcxsv8CODM", function(data) {



        var text = data.results[0].geometry.location.lat + "<br>";
        var text2 = data.results[0].geometry.location.lng;
        var res = text + " " + text2;
        $(".mypanel").html(res);
    });
    </script>
        <script>
        var lati = "<?php echo $latitude; ?>";
        var longval = "<?php echo $longtitude; ?>";
        var truck = "truck10";
            var myCenter=new google.maps.LatLng(lati,longval);

			function initialize() {
			  var mapProp = {
				center:myCenter,
				zoom:15,
				mapTypeId:google.maps.MapTypeId.RoadMap
			  };
			var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

			var marker_build_1=new google.maps.Marker({
			  position:new google.maps.LatLng(lati,longval)
			});

			marker_build_1.setMap(map);
			var infowindow1 = new google.maps.InfoWindow({
			  content: truck
			});
			google.maps.event.addListener(marker_build_1, 'click', function() {
			  infowindow1.open(map,marker_build_1);
			});
			}
			google.maps.event.addDomListener(window, 'load', initialize);
		</script>

    </body>
</html>
