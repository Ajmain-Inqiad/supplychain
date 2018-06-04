<?php
#$json = file_get_contents('https://api.thingspeak.com/channels/366902/feeds.json?results=2');
$json = file_get_contents('https://api.thingspeak.com/channels/409679/feeds.json?results=2');
$obj = json_decode($json);
//print_r($obj);
print_r(end($obj->feeds)->field1);
print_r(end($obj->feeds)->field2);


?>
