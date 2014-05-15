/** This file is part of server-side of the CampusTrees Project. It is subject to the license terms in the LICENSE file found in the top-level directory of this distribution. No part of CampusTrees Project, including this file, may be copied, modified, propagated, or distributed except according to the terms contained in the LICENSE file.*/
<?php
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/AppRequestHandler.inc.php');
require_once(ROOT_DIR . 'classes/SpeciesTable.inc.php');
require_once(ROOT_DIR . 'admin/modules/auth.inc.php');

if (isset($debug)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}
$handler = new ARHandler();
$sTable = new SpeciesTable();
$html = "<html>
<a href=\"add_species.php\">Add a Species</a></br>";


    $i = 0;
    $sList = $sTable->GetSpecies();
    $html .= "<table border=\"1\">";
    $html .= "<tr><th>SpeciesId</th><th>CommonName</th><th>Species</th><th>NAmerican</th><th>Ky</th><th>Fruit Type</th><th>Edible</th><th>FlowerRelLeaves</th><th>Count</th><th>Growth Factor</th></tr>";
    foreach ($sList as $row) {
        $html .= "<tr><td><a href=\"" . HOME;
        $html .= "admin/modules/edit_species.php?sid={$row['sid']}\">{$row['sid']}</a></td>";
        $html .= "<td>{$row['commonname']}</td>";
        $html .= "<td>{$row['species']}</td>";
        $html .= "<td>{$row['american']}</td>";
        $html .= "<td>{$row['ky']}</td>";
        $html .= "<td>{$row['fruittype']}</td>";
        $html .= "<td>{$row['edible']}</td>";
        $html .= "<td>{$row['flowrelleaf']}</td>";
        $html .= "<td>{$row['count']}</td>";
        $html .= "<td>{$row['gf']}</td>";
        $html .= "</tr>";
    }
    $html .= "</table>";

$html .= "</html>";
echo $html;
?>
