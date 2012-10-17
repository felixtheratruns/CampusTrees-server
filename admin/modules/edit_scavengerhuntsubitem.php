<?php
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/ScavengerHuntSubItemTableBu.inc.php');
require_once(ROOT_DIR . 'admin/modules/auth.inc.php');
$debug = 1;
if (isset($debug)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

$sTable = new ScavengerHuntSubItemTable();
$sid = $_GET['sid'];

$sTable->removeScavengerHuntSubItem($sid);
echo "<HEAD><meta http-equiv=\"REFRESH\" content=\"0;url=" . HOME ."admin/modules/list_scavengerhuntsubitem.php\"></HEAD>";
?>
