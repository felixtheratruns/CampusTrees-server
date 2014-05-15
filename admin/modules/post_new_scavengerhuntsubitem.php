<!-- This file is part of server-side of the CampusTrees Project. It is subject to the license terms in the LICENSE file found in the top-level directory of this distribution. No part of CampusTrees Project, including this file, may be copied, modified, propagated, or distributed except according to the terms contained in the LICENSE file.-->
<?php
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/ScavengerHuntSubItemTable.inc.php');
require_once(ROOT_DIR . 'admin/modules/auth.inc.php');
$debug = 1;
if (isset($debug)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

$sTable = new ScavengerHuntSubItemTable();

$belong_id = $_POST['belong_id'];
$title = $_POST['title'];
$body = $_POST['body'];
$png_name = $_POST['png_name'];

if ($sTable->addScavengerHuntSubItem($uid, $title, $body, $belong_id, $png_name)) {
    echo "<HEAD><meta http-equiv=\"REFRESH\" content=\"0;url=" . HOME ."admin/modules/list_scavengerhuntsubitem.php\"></HEAD>";
}
else {echo "Error adding scavengerhuntsubitem!";}
?>
