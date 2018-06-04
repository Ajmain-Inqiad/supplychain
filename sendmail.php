<?php
require_once 'dbconnect.php';
?>
<?php require_once ("class.phpmailer.php"); ?>
<?php require_once ("class.smtp.php"); ?>
<?php require_once ("PHPMailerAutoload.php"); ?>
<?php
$mail = new PHPMailer(); // create a new object
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    #$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
    $mail->Host = "smtp.ourdeal.bid";
    $mail->Port = 587; // or for ssl port=465 or 25=non-ssl
    $mail->IsHTML(true);
    $mail->Username = "customerservice@ourdeal.bid";
    $mail->Password = "12345678";
    $mail->SetFrom("customerservice@ourdeal.bid");
    $mail->AddAddress($_POST["client"]);
    try {
        $mail->Body = $_POST['body'];
        $mail->Subject = "Mail from Our Deal";
        if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            $type = $_POST['type'];
            $order = $_POST["order"];
            $msg = "Email has been sent.";
            if($type=="delete"){
              $connect->query("DELETE FROM orders WHERE id='$order'");
              $msg .= " Database also updated";
            }elseif ($type=="approve") {
              $manager = $_POST['manager'];
              $connect->query("UPDATE orders SET approved='yes', manager='$manager' WHERE id='$order'");
              $msg .= " Database also updated";
            }elseif ($type=="approvereqclient") {
              $req_email = $_POST["client"];
              $query = $connect->query("SELECT * FROM req_client WHERE email='$req_email'");
              $result = $query->fetch_assoc();
              $client_name = $result['fullname'];
              $client_username = $result['username'];
              $client_email = $result['email'];
              $client_password = $result['password'];
              $client_address = $result['address'];
              $client_phone = $result['phone'];
              $client_division = $result['division'];
              $client_lat = $result['lat'];
              $client_long = $result['longti'];
              $connect->query("INSERT INTO client (fullname, username, email, password, address, phone, logged_in, division, lat, longti) VALUES ('$client_name', '$client_username', '$client_email', '$client_password', '$client_address', '$client_phone', 'no', '$client_division', '$client_lat', '$client_long')");
              $connect->query("DELETE FROM req_client WHERE email='$req_email'");
              $msg .= " Database also updated";
            }elseif ($type=="deletereqclient") {
              $req_email = $_POST["client"];
              $connect->query("DELETE FROM req_client WHERE email='$req_email'");
              $msg .= " Database also updated";
            }elseif ($type=="deletecurrentclient") {
              $client_email = $_POST["client"];
              $connect->query("DELETE FROM client WHERE email='$client_email'");
              $msg .= " Database also updated";
            }
            echo $msg;
        }
    } catch (Exception $e) {
        #print_r($e->getMessage());
        file_put_contents($logfile, "Error: \n", FILE_APPEND);
        file_put_contents($logfile, $e->getMessage() . "\n", FILE_APPEND);
        file_put_contents($logfile, $e->getTraceAsString() . "\n\n", FILE_APPEND);
    }
?>
