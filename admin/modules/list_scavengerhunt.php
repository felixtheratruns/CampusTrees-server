<!-- This file is part of server-side of the CampusTrees Project. It is subject to the license terms in the LICENSE file found in the top-level directory of this distribution. No part of CampusTrees Project, including this file, may be copied, modified, propagated, or distributed except according to the terms contained in the LICENSE file.-->
<?php
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/ScavengerHuntTable.inc.php');
require_once(ROOT_DIR . 'admin/modules/auth.inc.php');

if (isset($debug)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}
$sTable = new ScavengerHuntTable();
$html = "<html>
<a href=\"add_scavengerhunt.php\">Add a ScavengerHunt Item</a></br>";


    $i = 0;
    $sList = $sTable->GetScavengerHunt();
    $html .= "<table border=\"1\">";
    $html .= "<tr><th>Title</th><th>ScavId</th><th>User</th><th>Remove</th></tr>";
    foreach ($sList as $row) {
        $html .= "<tr>";
        $html .= "<td>{$row['title']}</td>";
        $html .= "<td>{$row['scavid']}</td>";
        $html .= "<td><a href=\"" . HOME;
        $html .= "admin/modules/edit_user.php?uid={$row['uid']}\">{$row['uname']}</a></td>";
        $html .= "<td><a href=\"" . HOME;
        $html .= "admin/modules/edit_scavengerhunt.php?sid={$row['sid']}\">Delete</a></td>";
        $html .= "</tr>";
    }
    $html .= "</table>";

$html .= "</html>";
echo $html;
?>
