<?php
$lat = [23.780527, 23.780330, 23.780341, 23.780346];
$long = [90.417385, 90.416284, 90.416025, 90.414847];
for($i = 0; $i<sizeof($lat); $i++){
    $url = "https://api.thingspeak.com/update?api_key=DYHXEIQHNADFA68L&field1="+$lat[$i]+"&field2="+$long[$i];
}

 ?>
