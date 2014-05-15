/** This file is part of server-side of the CampusTrees Project. It is subject to the license terms in the LICENSE file found in the top-level directory of this distribution. No part of CampusTrees Project, including this file, may be copied, modified, propagated, or distributed except according to the terms contained in the LICENSE file.*/
<?php
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/ZonePointTable.inc.php');
require_once(ROOT_DIR . 'admin/modules/auth.inc.php');
$debug=1;
if (isset($debug)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}
$zpTable = new ZonePointTable();
$html = "<html>";


    $i = 0;
    $zpid = 0;
    $zpList = $zpTable->GetZones();
    $html .= "<table border=\"1\">";
    $html .= "<tr><th>ZoneId</th><th>Number of Points</th><th>Edit</th></tr>";
    foreach ($zpList as $row) {
        $zpid = $row['zpid'];
        $count = 0;
        foreach ($row['points'] as $p) {
            $count++;
        }
        $html .= "<tr>";
        $html .= "<td>{$zpid}</td>";
        $html .= "<td>{$count}</td>";
        $html .= "<td><a href=\"" . HOME;
        $html .= "admin/modules/edit_zone.php?zpid={$zpid}\">edit</a></td>";
        $html .= "</tr>";
    }
    $zpid++;
    $html .= "</table><br><a href=\"edit_zone.php?zpid={$zpid}&new=1\">Add a Zone</a>";

$html .= "</html>";
echo $html;
?>
