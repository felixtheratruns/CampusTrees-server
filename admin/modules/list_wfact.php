/** This file is part of server-side of the CampusTrees Project. It is subject to the license terms in the LICENSE file found in the top-level directory of this distribution. No part of CampusTrees Project, including this file, may be copied, modified, propagated, or distributed except according to the terms contained in the LICENSE file.*/
<?php
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/WildlifeFactsTable.inc.php');
require_once(ROOT_DIR . 'admin/modules/auth.inc.php');

if (isset($debug)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}
$wTable = new WildlifeFactsTable();
$html = "<html>
<a href=\"add_wfact.php\">Add a WildlifeFacts Item</a></br>";


    $i = 0;
    $wList = $wTable->GetFacts();
    $html .= "<table border=\"1\">";
    $html .= "<tr><th>Title</th><th>Body</th><th>Date</th><th>User</th><th>Remove</th></tr>";
    foreach ($wList as $row) {
        $html .= "<tr>";
        $html .= "<td>{$row['title']}</td>";
        $html .= "<td>{$row['body']}</td>";
        $html .= "<td>{$row['date']}</td>";
        $html .= "<td><a href=\"" . HOME;
        $html .= "admin/modules/edit_user.php?uid={$row['uid']}\">{$row['uname']}</a></td>";
        $html .= "<td><a href=\"" . HOME;
        $html .= "admin/modules/edit_wfact.php?wid={$row['wid']}\">Delete</a></td>";
        $html .= "</tr>";
    }
    $html .= "</table>";

$html .= "</html>";
echo $html;
?>
