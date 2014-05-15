/** This file is part of server-side of the CampusTrees Project. It is subject to the license terms in the LICENSE file found in the top-level directory of this distribution. No part of CampusTrees Project, including this file, may be copied, modified, propagated, or distributed except according to the terms contained in the LICENSE file.*/
<?php
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/species.inc.php');
require_once(ROOT_DIR . 'classes/FlowerMonthsTable.inc.php');
require_once(ROOT_DIR . 'classes/SeedingMonthsTable.inc.php');
require_once(ROOT_DIR . 'admin/modules/auth.inc.php');

if (isset($debug)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}
?>

<?php
if (!isset($_GET['sid'])) {
    //No species selected, so list species
    echo "<HEAD><meta http-equiv=\"REFRESH\" content=\"0;url=" . HOME ."admin/modules/list_species.php\"></HEAD>";
}
else {
    //Species selected
    $type = null;
    $sid = $_GET['sid'];
    $s = new species($sid);
    $species = $s->getProperties(True);
    $cal = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

    if (isset($_GET['fruit'])) {
        $type = 'fruit';
        $smTable = new SeedingMonthsTable();
        $ms = $smTable->monthsBySpecies($species['sid']);
    }

    if (isset($_GET['flower'])) {
        $type = 'flower';
        $fmTable = new FlowerMonthsTable();
        $ms = $fmTable->monthsBySpecies($species['sid']);
    }

    ?>
    <h1>Edit Species</h1>
    <form name="edit_month" action="edit_species.php?sid=<?php echo "{$species['sid']}&{$type}"; ?>" method="POST">
    <input type="hidden" name="month" value="true">
    <h2>Basic Information</h2>
    Species ID:<?php echo " {$species['sid']}"; ?><br />
    Common Name: <?php echo " {$species['commonname']}"; ?><br />
    Species Name: <?php echo " {$species['species']}"; ?><br />
    
    <?php
    $months = array();
    foreach ($ms as $m) {
        array_push($months, $m['mid']);
    }
    echo "<h2>{$type} ";
    ?>
    months</h2>

    <?php
    foreach ($cal as $month) {
        echo "{$month}: <input type=\"checkbox\" name=\"{$month}\" value=\"true\"";
        if (in_array(array_search($month, $cal)+1, $months) || $ms[0]['mid'] == 13) {echo " checked=\"checked\"";}
        echo " ><br />";
    }
    ?>
    <br />
    <input type="submit" value="Submit">
    </form>
    <br>
    <?php
}   
?>
