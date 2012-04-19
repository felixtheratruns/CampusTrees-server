<? 
require_once('../../config.inc.php');
session_start();
if(!isset($_SESSION['uid'])){
    header("location:" . HOME . "admin/main_login.php");
}
else {$uid = $_SESSION['uid'];}
echo "<a href=\"" . HOME ."admin/logout.php\">logout</a><br>";
?>
