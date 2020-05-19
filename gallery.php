<?php 
session_start();
require_once('inc/header/header.inc.php'); 

if (isset($_SESSION['loggedIn'])){
    require_once('inc/content/content.inc.php');
} else {
    require_once('inc/content/guestContent.inc.php');
}
?>
<?php require_once('inc/footer/footer.inc.php') ?>