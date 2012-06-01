<?php
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/NewsTable.inc.php');
require_once(ROOT_DIR . 'admin/modules/auth.inc.php');

if (isset($debug)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

$nTable = new NewsTable();

$title = $_POST['title'];
$body = $_POST['body'];

if ($nTable->addNews($uid, $title, $body)) {
    echo "<HEAD><meta http-equiv=\"REFRESH\" content=\"0;url=" . HOME ."admin/modules/list_news.php\"></HEAD>";
}
else {echo "Error adding news!";}
?>
