<?php
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

  function password_check($password, $existing_hash){
  		$hash = crypt($password, $existing_hash);
  		if($hash === $existing_hash){
  			return true;
  		}
  		else{
  			return false;
  		}
  	}


    function find_admin($username, $password, $connect){
  		$sql = "SELECT * FROM admin WHERE username='$username' LIMIT 1";
      $result = $connect->query($sql);
      $admin = $result->fetch_assoc();
  		if(password_check($password, $admin["password"])){
  			return true;
  		}
  		else{
  			return false;
  		}
	}

	function find_client($username, $password, $connect){
		$sql = "SELECT * FROM client WHERE username='$username' LIMIT 1";
		$result = $connect->query($sql);
		$employee = $result->fetch_assoc();
		if(password_check($password, $employee["password"])){
			return true;
		}
		else{
			return false;
		}
	}

	function find_employee($username, $password, $connect){
  	  $sql = "SELECT * FROM employee WHERE username='$username' LIMIT 1";
      $result = $connect->query($sql);
      $admin = $result->fetch_assoc();
  		if(password_check($password, $admin["password"])){
  			return true;
  		}
  		else{
  			return false;
  		}
	}
	function get_latitude_value($lati){
		$p = str_split($lati);
		$deg = "" . $p[0] . $p[1];
		$redeg = intval($deg);
		$sec = "";
		$i=1;
		for($i=2; $i < strlen($lati); $i++) {
		    $sec .= $p[$i];
		}
		$resec = floatval($sec);
		$secval = $resec/60;
		$latival = $redeg+$secval;
		return $latival;
	}

	function get_longtitude_value($longti){
		$p = str_split($longti);
		$deg = "" . $p[1].$p[2];
		$redeg = intval($deg);
		$sec = "";
		for($i=3; $i < strlen($longti); $i++) {
		    $sec .= $p[$i];
		}
		$resec = floatval($sec);
		$secval = $resec/60;
		$longtival = $redeg+$secval;
		return $longtival;
	}
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
?>
