<?php
//Auth stuff
$user = 1;
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once('../../config.inc.php');

require_once(ROOT_DIR . 'classes/tree.inc.php');

$id = $_POST['id'];
$t = new tree($id);
$tree = $t->getProperties(True);

$lat = $_POST['lat'];
$long = $_POST['long'];
$sid = $_POST['sid'];
$height = $_POST['height'];
$removed = false;
$comments = $_POST['comments'];

if (isset($_POST['removed'])) {
    $removed = true;
}

$fields['TTreeId'] = $tree['id'];
$fields['UserId'] = $user;

if ($tree['lat'] != $lat) {
    $fields['TLat'] = $lat;
}

if ($tree['long'] != $long) {
    $fields['TLong'] = $long;
}

if ($tree['sid'] != $sid) {
    $fields['TSpeciesId'] = $sid;
}

if ($tree['height'] != $height) {
    $fields['THeight'] = $height;
}

if ($tree['removed'] != $removed) {
    if ($removed) { $fields['TRemoved'] = 1;}
    else { $fields['TRemoved'] = 0; }
}

if ($tree['comments'] != $comments) {
    $fields['TComments'] = $comments;
}

$t->update($fields);

?>
