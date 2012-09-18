<?php
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/ScavengerHuntTable.inc.php');
require_once(ROOT_DIR . 'admin/modules/auth.inc.php');

if (isset($debug)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}
$nTable = new ScavengerHuntTable();
$html = "<html>
<a href=\"add_scavengerhunt.php\">Add a ScavengerHunt Item</a></br>";


    $i = 0;
    $nList = $nTable->GetScavengerHunt();
    $html .= "<table border=\"1\">";
    $html .= "<tr><th>Title</th><th>Body</th><th>Date</th><th>User</th><th>Remove</th></tr>";
    foreach ($nList as $row) {
        $html .= "<tr>";
        $html .= "<td>{$row['title']}</td>";
        $html .= "<td>{$row['body']}</td>";
        $html .= "<td>{$row['date']}</td>";
        $html .= "<td><a href=\"" . HOME;
        $html .= "admin/modules/edit_user.php?uid={$row['uid']}\">{$row['uname']}</a></td>";
        $html .= "<td><a href=\"" . HOME;
        $html .= "admin/modules/edit_scavengerhunt.php?nid={$row['nid']}\">Delete</a></td>";
        $html .= "</tr>";
    }
    $html .= "</table>";

$html .= "</html>";
echo $html;
?>
