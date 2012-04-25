<? 
require_once('../../config.inc.php');
session_start();
if(!isset($_SESSION['uid'])){
    header("location:" . HOME . "admin/main_login.php");
}
else {$uid = $_SESSION['uid'];}
?>
<nav>
<?php
echo "<a href=\"" . HOME ."admin/index.php\">Admin Home</a><br>";
echo "<a href=\"" . HOME ."admin/modules/list_tree.php\">Tree List</a><br>";
echo "<a href=\"" . HOME ."admin/logout.php\">Logout</a><br>";
?>
</nav>
