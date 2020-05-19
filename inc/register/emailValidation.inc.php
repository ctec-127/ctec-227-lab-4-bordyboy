<?php 

require_once("../db/mysqli_connect.inc.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(!empty($_POST['email'])){
        $email= $_POST['email'];
        $sql = "SELECT email FROM user WHERE email='$email'";
        $result = $db->query($sql);
        if ($result->num_rows == 0){
            echo "<span id='emailValidationMessage' class='text-dark-green'>Email Available </span>";
        }else{
            echo "<span id='emailValidationMessage' class='text-warning'>Email Not Available </span>";
        }
    }
}

?>