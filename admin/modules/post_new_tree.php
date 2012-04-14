<?php
//Require authenticaiton here
//Assuming we will know the user's id and set $uid to this.
$user = 1;
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/TreeTable.inc.php');
require_once(ROOT_DIR . 'classes/SpeciesTable.inc.php');
require_once(ROOT_DIR . 'classes/EntityUpdateTable.inc.php');

$tTable = new TreeTable();
$err = false;
echo $tTable->getNextId();

    $id = $tTable->getNextId();

    if (isset($_POST['lat'])) {
        $lat = $_POST['lat'];
    }
    else {
        echo "No Latitude Entered<br>";
        $err = true;
    }
  
    if (isset($_POST['long'])) {
        $long = $_POST['long'];
    }
    else {
        echo "No Longitude Entered<br>";
        $err = true;
    }
  
    if (isset($_POST['sid'])) {
        $sid = $_POST['sid'];
    }
    else {
        echo "No Species Entered<br>";
        $err = true;
    }
  
    if (isset($_POST['height'])) {
        $height = $_POST['height'];
    }
    else {
        echo "No Height Entered<br>";
        $err = true;
    }
  
    if (isset($_POST['comments'])) {
        $comments = $_POST['comments'];
    }
    else {
        echo "No Comments Entered<br>";
        $err = true;
    }
  
    if (isset($_POST['dbh'])) {
        $dbh = $_POST['dbh'];
    }
    else {
        echo "No dbh Entered<br>";
        $err = true;
    }
  
    if (isset($_POST['cw1'])) {
        $cw1 = $_POST['cw1'];
    }
    else {
        echo "No Crown Width 1 Entered<br>";
        $err = true;
    }
  
    if (isset($_POST['cw2'])) {
        $cw2 = $_POST['cw2'];
    }
    else {
        echo "No Crown Width 2 Entered<br>";
        $err = true;
    }
  
    if (isset($_POST['area'])) {
        $area = $_POST['area'];
    }
    else {
        echo "No Area Entered<br>";
        $err = true;
    }
  
    if (isset($_POST['quad'])) {
        $quad = $_POST['quad'];
    }
    else {
        echo "No Quad Entered<br>";
        $err = true;
    }
  
    if (isset($_POST['dcrn'])) {
        $dcrn = $_POST['dcrn'];
    }
    else {
        echo "No Distance to Crown Entered<br>";
        $err = true;
    }
  
    if (isset($_POST['dtree'])) {
        $dtree = $_POST['dtree'];
    }
    else {
        echo "No Distance to Tree Entered<br>";
        $err = true;
    }
  
    if (isset($_POST['crwnid'])) {
        $crwnid = $_POST['crwnid'];
    }
    else {
        echo "No Crown Id Entered<br>";
        $err = true;
    }

    if (!$err) {
        $fields = array();
        $fields['id'] = $id;
        $fields['uid'] = $user;
        
        $fields['lat'] = $lat;
        $fields['long'] = $long;
        $fields['sid'] = $sid;
        $fields['height'] = $height;
        $fields['comments'] = $comments;
        $fields['dbh'] = $dbh;
        $fields['cw1'] = $cw1;
        $fields['cw2'] = $cw2;
        $fields['area'] = $area;
        $fields['quad'] = $quad;
        $fields['dcrn'] = $dcrn;
        $fields['dtree'] = $dtree;
        $fields['crwnid'] = $crwnid;
    
        if ($tTable->addTree($fields)) {
            echo "<HEAD><meta http-equiv=\"REFRESH\" content=\"0;url=" . HOME ."admin/modules/edit_tree.php?t={$id}\"></HEAD>";
        }
        else {echo "Error adding tree!";}
    }
    else {"Error: Missing Data";}
?>
