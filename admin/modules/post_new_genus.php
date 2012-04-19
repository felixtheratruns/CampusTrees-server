<?php
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/GenusTable.inc.php');
require_once(ROOT_DIR . 'admin/modules/auth.inc.php');

if (isset($debug)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

$gTable = new GenusTable();
$gid =  $gTable->getNextId();

$genus = $_POST['genus'];
$nick = $_POST['nick'];
$agf = $_POST['agf'];

if ($gTable->addGenus($gid, $genus, $nick, $agf, $uid)) {
    echo "<HEAD><meta http-equiv=\"REFRESH\" content=\"0;url=" . HOME ."admin/modules/edit_genus.php?gid={$gid}\"></HEAD>";
}
else {echo "Error adding genus!";}
?>
