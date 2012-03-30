<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/AppRequestHandler.inc.php');
require_once(ROOT_DIR . 'classes/TreeTable.inc.php');
$handler = new ARHandler();
$tTable = new TreeTable();
$html = "<html>";


if (isset($_GET["zone"])) {
    $zone = $_GET["zone"]; //Probably should sanitize this shit
    $i = 0;
    $forest = $handler->RequestTreesByZone($zone);
    $html .= "<table border=\"1\">";
    $html .= "<tr><th>Id</th><th>Sid</th><th>lat</th><th>long</th><th>dbh</th><th>height</th><th>cw1</th><th>cw2</th><th>vol</th></tr>";
    foreach ($forest as $row) {
        $html .= "<tr><td><a href=\"" . HOME;
        $html .= "admin/modules/edit_tree.php?t={$row['id']}\">{$row['id']}</a></td>";
        $html .= "<td>{$row['sid']}</td>";
        $html .= "<td>{$row['lat']}</td>";
        $html .= "<td>{$row['long']}</td>";
        $html .= "<td>{$row['dbh']}</td>";
        $html .= "<td>{$row['height']}</td>";
        $html .= "<td>{$row['cw1']}</td>";
        $html .= "<td>{$row['cw2']}</td>";
        $html .= "<td>{$row['vol']}</td>";
        $html .= "</tr>";
    }
    $html .= "</table>";
}
else {
    $i = 0;
    $forest = $tTable->getAll();
    $html .= "<table border=\"1\">";
    $html .= "<tr><th>Id</th><th>Sid</th><th>lat</th><th>long</th><th>dbh</th><th>height</th><th>cw1</th><th>cw2</th><th>vol</th></tr>";
    foreach ($forest as $row) {
        $html .= "<tr><td><a href=\"" . HOME;
        $html .= "admin/modules/edit_tree.php?t={$row['id']}\">{$row['id']}</a></td>";
        $html .= "<td>{$row['sid']}</td>";
        $html .= "<td>{$row['lat']}</td>";
        $html .= "<td>{$row['long']}</td>";
        $html .= "<td>{$row['dbh']}</td>";
        $html .= "<td>{$row['height']}</td>";
        $html .= "<td>{$row['cw1']}</td>";
        $html .= "<td>{$row['cw2']}</td>";
        $html .= "<td>{$row['vol']}</td>";
        $html .= "</tr>";
    }
    $html .= "</table>";
}

$html .= "</html>";
echo $html;
?>
