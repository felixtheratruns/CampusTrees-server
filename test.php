<!-- This file is part of server-side of the CampusTrees Project. It is subject to the license terms in the LICENSE file found in the top-level directory of this distribution. No part of CampusTrees Project, including this file, may be copied, modified, propagated, or distributed except according to the terms contained in the LICENSE file.-->
<html>
<head>
<title>UofL Trees</title>
</head>

<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once('config.inc.php');
require_once(ROOT_DIR . 'classes/AppRequestHandler.inc.php');
echo "Wee good<br>";
$handler = new ARHandler();

?>
<body>
This is a temporary placeholder page for the UofL trees website.
<br>
<?echo "Zone Info: {$handler->ZoneList_ToString()}";
$handler->SelectZone(1);
$handler->getTree(353);
echo "Here's treeses in Zone 1:<br>";
echo $handler->SelectedTrees_ToString();
?>
</body>

</html>
