<?php
//Require authenticaiton here
//Assuming we will know the user's id and set $uid to this.
$user = 1;
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/GenusTable.inc.php');

$gTable = new GenusTable();
$gid =  $gTable->getNextId();

$genus = $_POST['genus'];
$nick = $_POST['nick'];
$agf = $_POST['agf'];
$uid = $user;

if ($gTable->addGenus($gid, $genus, $nick, $agf, $uid)) {
    echo "<HEAD><meta http-equiv=\"REFRESH\" content=\"0;url=" . HOME ."admin/modules/edit_genus.php?gid={$gid}\"></HEAD>";
}
else {echo "Error adding genus!";}
?>
