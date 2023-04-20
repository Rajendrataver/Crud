<?php
session_start();
?>

<h1>this is Logout page</h1>
<?php
if ($_SESSION['ID']) {
    session_destroy();
}
header('Location: login.php');
?>