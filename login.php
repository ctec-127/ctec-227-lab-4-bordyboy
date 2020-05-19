<?php 
session_start();
require_once('inc/db/mysqli_connect.inc.php');
require_once('inc/header/header.inc.php');

$error_bucket = [];
if($_SERVER['REQUEST_METHOD']=='POST') {
    if (empty($_POST['email'])) {
        array_push($error_bucket,"<p>Please enter your email</p>");
    } else {
        $email = $db->real_escape_string(strip_tags($_POST['email']));
    }
    if (empty($_POST['password'])) {
        array_push($error_bucket,"<p>Please enter your password</p>");
    } else {
        $password = hash('sha512', $db->real_escape_string(strip_tags($_POST['password'])));
    }

    if (count($error_bucket) == 0) {
        $sql = "SELECT email,password,username FROM user WHERE email='$email' AND password='$password'";
        $result = $db->query($sql);        
        if ($result->num_rows == 0) {
            echo '<div class="alert alert-danger" role="alert">
            Wrong email or password</div>';
        } else {
            header('Location: gallery.php');
            unset($email);
            unset($password);
            while ($row = $result->fetch_assoc()){
                $username = $row['username'];
            } 
            $_SESSION['loggedIn'] = True;
            $_SESSION['username'] = $username;
            // echo $_SESSION['username'];
            if (!is_dir($username)){
                mkdir('uploads/' . $username, 0777);
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
    <h1>Image Gallery Log In</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
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

<?php require_once('inc/footer/footer.inc.php') ?>
