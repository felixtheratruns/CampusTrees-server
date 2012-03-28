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
