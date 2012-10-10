<?php
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/ScavengerHuntSubItemTable.inc.php');
require_once(ROOT_DIR . 'admin/modules/auth.inc.php');

$debug = 1;
if (isset($debug)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}
$nTable = new ScavengerHuntSubItemTable();
$html = "<html>
<a href=\"add_scavengerhuntsubitem.php\">Add a ScavengerHuntSubItem Item</a></br>";

    $i = 0;
    $sList = $nTable->GetScavengerHuntSubItem();
    $html .= "<table border=\"1\">";
    $html .= "<tr><th>The SScavId of the ScavengerHunt this item belongs to</th><th>Title</th><th>Body</th><th>User</th><th>Remove</th></tr>";
    foreach ($sList as $row) {
        
        $html .= "<tr>";
        $html .= "<td>{$row['belong_id']}</td>";
        $html .= "<td>{$row['title']}</td>";
        $html .= "<td>{$row['body']}</td>";
        $html .= "<td><a href=\"" . HOME;
        $html .= "admin/modules/edit_user.php?uid={$row['uid']}\">{$row['uname']}</a></td>";
        $html .= "<td><a href=\"" . HOME;
        $html .= "admin/modules/edit_scavengerhuntsubitem.php?sid={$row['sid']}\">Delete</a></td>";
        $html .= "</tr>";
    }
    $html .= "</table>";

$html .= "</html>";
echo $html;
?>
