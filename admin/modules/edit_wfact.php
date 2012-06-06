<?php
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/WildlifeFactsTable.inc.php');
require_once(ROOT_DIR . 'admin/modules/auth.inc.php');

if (isset($debug)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

$wTable = new WildlifeFactsTable();
$wid = $_GET['wid'];

$wTable->removeFact($wid);
echo "<HEAD><meta http-equiv=\"REFRESH\" content=\"0;url=" . HOME ."admin/modules/list_wfact.php\"></HEAD>";
?>
