<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/AppRequestHandler.inc.php');
require_once(ROOT_DIR . 'classes/GenusTable.inc.php');
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
