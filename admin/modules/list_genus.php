<!-- This file is part of server-side of the CampusTrees Project. It is subject to the license terms in the LICENSE file found in the top-level directory of this distribution. No part of CampusTrees Project, including this file, may be copied, modified, propagated, or distributed except according to the terms contained in the LICENSE file.-->
<?php
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/AppRequestHandler.inc.php');
require_once(ROOT_DIR . 'classes/GenusTable.inc.php');
require_once(ROOT_DIR . 'admin/modules/auth.inc.php');

if (isset($debug)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}
$handler = new ARHandler();
$gTable = new GenusTable();
$html = "<html>
<a href=\"add_genus.php\">Add a Genus</a></br>";


    $i = 0;
    $gList = $gTable->getAll();
    $html .= "<table border=\"1\">";
    $html .= "<tr><th>GenusId</th><th>Genus</th><th>Nickname</th><th>Count</th><th>Average Growth Factor</th></tr>";
    foreach ($gList as $row) {
        $html .= "<tr><td><a href=\"" . HOME;
        $html .= "admin/modules/edit_genus.php?gid={$row['gid']}\">{$row['gid']}</a></td>";
        $html .= "<td>{$row['genus']}</td>";
        $html .= "<td>{$row['nick']}</td>";
        $html .= "<td>{$row['count']}</td>";
        $html .= "<td>{$row['agf']}</td>";
        $html .= "</tr>";
    }
    $html .= "</table>";

$html .= "</html>";
echo $html;
?>
