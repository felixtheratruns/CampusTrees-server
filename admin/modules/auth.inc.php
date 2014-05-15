/** This file is part of server-side of the CampusTrees Project. It is subject to the license terms in the LICENSE file found in the top-level directory of this distribution. No part of CampusTrees Project, including this file, may be copied, modified, propagated, or distributed except according to the terms contained in the LICENSE file.*/
<? 
require_once('../../config.inc.php');
session_start();
if(!isset($_SESSION['uid'])){
    header("location:" . HOME . "admin/main_login.php");
}
else {$uid = $_SESSION['uid'];}
?>
<nav>
<?php
echo "<a href=\"" . HOME ."admin/index.php\">Admin Home</a><br>";
echo "<a href=\"" . HOME ."admin/modules/list_tree.php\">Tree List</a><br>";
echo "<a href=\"" . HOME ."admin/logout.php\">Logout</a><br>";
?>
</nav>
