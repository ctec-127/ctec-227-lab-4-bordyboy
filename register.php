<?php 
session_start();
require_once('inc/db/mysqli_connect.inc.php');
require_once('inc/header/header.inc.php');

$error_bucket = [];
if($_SERVER['REQUEST_METHOD']=='POST') {
    if (empty($_POST['firstName'])) {
        array_push($error_bucket,"<p>A first name is required.</p>");
    } else {
        $firstName = $db->real_escape_string(strip_tags($_POST['firstName']));
    }
    if (empty($_POST['lastName'])) {
        array_push($error_bucket,"<p>A last name is required.</p>");
    } else {
        $lastName = $db->real_escape_string(strip_tags($_POST['lastName']));
    }
    if (empty($_POST['username'])) {
        array_push($error_bucket,"<p>A username is required.</p>");
    } else {
        $username = $db->real_escape_string(strip_tags($_POST['username']));
    }
    if (empty($_POST['email'])) {
        array_push($error_bucket,"<p>An email address is required.</p>");
    } else {
        $email = $db->real_escape_string(strip_tags($_POST['email']));
    }
    if (empty($_POST['password'])) {
        array_push($error_bucket,"<p>A password is required.</p>");
    } else {
        $password = hash('sha512', $db->real_escape_string(strip_tags($_POST['password'])));
    }

    if (count($error_bucket) == 0) {
        $usernameValidation = "SELECT username FROM user WHERE username='$username'";
        $usernameValidationResult = $db->query($usernameValidation);
        $emailValidation = "SELECT email FROM user WHERE email='$email'";
        $emailValidationResult = $db->query($emailValidation);
        if ($usernameValidationResult->num_rows == 0 && $emailValidationResult->num_rows == 0) {            
            $sql = "INSERT INTO user (first_name,last_name,username,email,password) ";
            $sql .= "VALUES ('$firstName','$lastName','$username','$email','$password')";
            $db->query($sql);
            // $result = $db->query($sql);
            // if (!$result) {
            //     echo '<div class="alert alert-danger" role="alert">
            //     I am sorry, but the Registration failed. ' .  
            //     $db->error . '.</div>';
            // } else {
                header('Location: login.php');
                unset($first);
                unset($last);
                unset($username);
                unset($email);
                unset($password);
                
            // }
        } else{
            if ($emailValidationResult->num_rows > 0) {
                echo '<div class="container"><div class="alert alert-danger" role="alert">I am sorry, but that email is already taken.</div></div>';               
            }
            if ($usernameValidationResult->num_rows > 0) {
                echo '<div class="container"><div class="alert alert-danger" role="alert">I am sorry, but that username is already taken.</div></div>';
            }
                       
        }
    } else {
        echo '<div class="container"><p>The following errors were deteced:</p>';
        echo '<div class="pt-4 alert alert-warning" role="alert">';
        echo '<ul>';
        foreach ($error_bucket as $text){
            echo '<li>' . $text . '</li>';
        }
        echo '</ul>';
        echo '</div>';
        echo '<p>All of these fields are required. Please fill them in.</p></div>';
    }

}



?>
<div class='container'>
    <h1>Image Gallery Register</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <div class="form-group">
        <label for="firstName">First Name</label>
        <input type="text" class="form-control" id="firstName" name="firstName">
    </div>
    <div class="form-group">
        <label for="lastName">Last Name</label>
        <input type="text" class="form-control" id="lastName" name="lastName">
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username">
    </div>
    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email" name="email">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<script>

$( "#email" ).change(function() {
    var email = $('#email').val();
    emailValidation(email);
});
$( "#username" ).change(function() {
    var username = $('#username').val();
    usernameValidation(username);
});


</script>
<?php require_once('inc/footer/footer.inc.php') ?>
