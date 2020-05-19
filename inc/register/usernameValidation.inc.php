<?php 

require_once("../db/mysqli_connect.inc.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(!empty($_POST['username'])){
        $username= $_POST['username'];
        $sql = "SELECT username FROM user WHERE username='$username'";
        $result = $db->query($sql);
        if ($result->num_rows == 0){
            echo "<span id='usernameValidationMessage' class='text-dark-green'>Username Available </span>";
        }else{
            echo "<span id='usernameValidationMessage' class='text-warning'>Username Not Available </span>";
        }
    }
}

?>