<?php
require_once('../config.inc.php');
require_once(ROOT_DIR . 'classes/UserTable.inc.php');

error_reporting(E_ALL);
ini_set('display_errors', '1');

$uTable = new UserTable();
ob_start();
$username="";
$password="";

$username=$_POST['username']; 
$password=$_POST['password'];

if($id = $uTable->checkLogin($username, $password)){
    session_start();
    $_SESSION['uid'] = $id;
    header("location:index.php");
}
else {
    echo "Wrong Username or Password<br><a href=\"main_login.php\">Back</a>";
}

ob_end_flush();
?>
