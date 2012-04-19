<?php
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/UserTable.inc.php');
require_once(ROOT_DIR . 'admin/modules/auth.inc.php');

if (isset($debug)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

$uTable = new UserTable();
$userid =  $uTable->getNextId();


$user = $_POST['user'];
$first = $_POST['first'];
$last = $_POST['last'];
$email = $_POST['email'];
$groupid = $_POST['groupid'];
$hash = md5($_POST['password']);

$active = 0;
if (isset($_POST['active'])) {
    $active = 1;
}


if ($uTable->addUser($userid, $user, $first, $last, $email, $groupid, $hash, $uid)) {
    echo "<HEAD><meta http-equiv=\"REFRESH\" content=\"0;url=" . HOME ."admin/modules/edit_user.php?uid={$userid}\"></HEAD>";
}
else {echo "Error adding user!";}
?>
