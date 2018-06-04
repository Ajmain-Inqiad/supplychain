<?php require_once "dbconnect.php"; ?>
<?php
if(isset($_POST['type'])){
    $type = $_POST['type'];
    if($type == "deletedriver"){
        $id = $_POST['id'];
        $result = $connect->query("DELETE FROM driver WHERE id='$id'");
        if($result){
            echo "Successful";
        }else{
            echo "Error: " . $result->errors;
        }
    }elseif($type == "editdriver"){
        $id = $_POST['id'];
        $name = $_POST['name'];
        $nid = $_POST['nid'];
        $phone = $_POST['phone'];
        $truck = $_POST['truck'];
        $address = $_POST['address'];
        $sql = $connect->query("UPDATE driver SET fullname='$name', nid='$nid', phone='$phone', address='$address', truck='$truck' WHERE id='$id'");
        if($sql){
            echo "Edit was successful";
        }else{
            echo "Error: ". $sql->errors;
        }
    }
}

 ?>
