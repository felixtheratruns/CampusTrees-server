<!-- This file is part of server-side of the CampusTrees Project. It is subject to the license terms in the LICENSE file found in the top-level directory of this distribution. No part of CampusTrees Project, including this file, may be copied, modified, propagated, or distributed except according to the terms contained in the LICENSE file.-->
<?php
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/SpeciesTable.inc.php');
require_once(ROOT_DIR . 'admin/modules/auth.inc.php');

if (isset($debug)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

$sTable = new SpeciesTable();
$sid =  $sTable->getNextId();

$commonname = $_POST['commonname'];
$species = $_POST['species'];
$gf = $_POST['gf'];
$gid = $_POST['gid'];
$comments = $_POST['comments'];
$fruittype = $_POST['fruittype'];
$flowrelleaf = $_POST['flowrelleaf'];
$american = 0;
$ky = 0;
$edible = 0;
if (isset($_POST['american'])) {
    $american = 1;
}

if (isset($_POST['ky'])) {
    $ky = 1;
}

if (isset($_POST['edible'])) {
    $edible = 1;
}

if ($sTable->addSpecies($sid, $commonname, $species, $gf, $gid, $american, $ky,
                        $fruittype, $edible, $flowrelleaf, $comments, $uid)) {
    echo "<HEAD><meta http-equiv=\"REFRESH\" content=\"0;url=" . HOME ."admin/modules/edit_species.php?sid={$sid}\"></HEAD>";
}
else {echo "Error adding species!";}
?>
