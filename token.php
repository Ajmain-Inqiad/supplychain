<?php
require "boot.php";
echo json_encode(Braintree_ClientToken::generate());
 ?>
