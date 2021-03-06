<!-- This file is part of server-side of the CampusTrees Project. It is subject to the license terms in the LICENSE file found in the top-level directory of this distribution. No part of CampusTrees Project, including this file, may be copied, modified, propagated, or distributed except according to the terms contained in the LICENSE file.-->
<?php
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/AppRequestHandler.inc.php');
require_once(ROOT_DIR . 'classes/TreeTable.inc.php');
require_once(ROOT_DIR . 'admin/modules/auth.inc.php');

if (isset($debug)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}
$handler = new ARHandler();
$tTable = new TreeTable();
$html = "<html>
<a href=\"add_tree.php\">Add a Tree</a></br>";


if (isset($_GET["zone"])) {
    $zone = $_GET["zone"]; //Probably should sanitize this shit
    $i = 0;
    $forest = $handler->RequestTreesByZone($zone);
    $html .= "<table border=\"1\">";
    $html .= "<tr><th>Maintenance</th><th>Id</th><th>Sid</th><th>lat</th><th>long</th><th>dbh</th><th>height</th><th>cw1</th><th>cw2</th><th>vol</th><th>GreenWt</th><th>DryWt</th><th>CarbonWeight</th><th>CO2Life</th><th>Age</th><th>CO2Year</th><th>Crown Area</th><th>avged</th></tr>";
    foreach ($forest as $row) {
        $html .= "<tr><td><a href=\"" . HOME;
        $html .= "admin/modules/maintenance.php?t={$row['id']}\">Maint.</a></td>";
        $html .= "<td><a href=\"" . HOME;
        $html .= "admin/modules/edit_tree.php?t={$row['id']}\">{$row['id']}</a></td>";
        $html .= "<td>{$row['sid']}</td>";
        $html .= "<td>{$row['lat']}</td>";
        $html .= "<td>{$row['long']}</td>";
        $html .= "<td>{$row['dbh']}</td>";
        $html .= "<td>{$row['height']}</td>";
        $html .= "<td>{$row['cw1']}</td>";
        $html .= "<td>{$row['cw2']}</td>";
        $html .= "<td>{$row['vol']}</td>";
        $html .= "<td>{$row['greenwt']}</td>";
        $html .= "<td>{$row['drywt']}</td>";
        $html .= "<td>{$row['carbonwt']}</td>";
        $html .= "<td>{$row['co2seqwt']}</td>";
        $html .= "<td>{$row['age']}</td>";
        $html .= "<td>{$row['co2pyear']}</td>";
        $html .= "<td>{$row['crownarea']}</td>";
        $html .= "<td>{$row['avged']}</td>";
        $html .= "</tr>";
    }
    $html .= "</table>";
}
else {
    $i = 0;
    $forest = $tTable->getAll();
    if(isset($_GET["gid"])) {$forest = $tTable->filterGenus($forest, json_decode($_GET["gid"]));}
    if(isset($_GET["sid"])) {$forest = $tTable->filterSpecies($forest, json_decode($_GET["sid"]));}
    $html .= "<table border=\"1\">";
    $html .= "<tr><th>Maintenance</th><th>Id</th><th>Sid</th><th>lat</th><th>long</th><th>dbh</th><th>height</th><th>cw1</th><th>cw2</th><th>vol</th><th>GreenWt</th><th>DryWt</th><th>CarbonWeight</th><th>CO2Life</th><th>Age</th><th>CO2Year</th><th>Crown Area</th><th>avged</th></tr>";
    foreach ($forest as $row) {
        $html .= "<tr><td><a href=\"" . HOME;
        $html .= "admin/modules/maintenance.php?t={$row['id']}\">Maint.</a></td>";
        $html .= "<td><a href=\"" . HOME;
        $html .= "admin/modules/edit_tree.php?t={$row['id']}\">{$row['id']}</a></td>";
        $html .= "<td>{$row['sid']}</td>";
        $html .= "<td>{$row['lat']}</td>";
        $html .= "<td>{$row['long']}</td>";
        $html .= "<td>{$row['dbh']}</td>";
        $html .= "<td>{$row['height']}</td>";
        $html .= "<td>{$row['cw1']}</td>";
        $html .= "<td>{$row['cw2']}</td>";
        $html .= "<td>{$row['vol']}</td>";
        $html .= "<td>{$row['greenwt']}</td>";
        $html .= "<td>{$row['drywt']}</td>";
        $html .= "<td>{$row['carbonwt']}</td>";
        $html .= "<td>{$row['co2seqwt']}</td>";
        $html .= "<td>{$row['age']}</td>";
        $html .= "<td>{$row['co2pyear']}</td>";
        $html .= "<td>{$row['crownarea']}</td>";
        if ($row['avged']) {$html .= "<td>Yep</td>";}
        else {$html .= "<td>Nope</td>";}
        $html .= "</tr>";
    }
    $html .= "</table>";
}

$html .= "</html>";
echo $html;
?>
