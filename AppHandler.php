<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once('config.inc.php');
require_once(ROOT_DIR . 'classes/AppRequestHandler.inc.php');
require_once(ROOT_DIR . 'classes/FlowerMonthsTable.inc.php');
require_once(ROOT_DIR . 'classes/SeedingMonthsTable.inc.php');
require_once(ROOT_DIR . 'classes/TreeTable.inc.php');
require_once(ROOT_DIR . 'classes/NewsTable.inc.php');
require_once(ROOT_DIR . 'classes/WildlifeFactsTable.inc.php');
$handler = new ARHandler();
$fmTable = new FlowerMonthsTable();
$smTable = new SeedingMonthsTable();
$tTable = new TreeTable();
$nTable = new NewsTable();
$wfTable = new WildlifeFactsTable();

if (isset($_GET["zoneRequest"])) {
    echo $handler->JSON_RequestZoneList();
}

if (isset($_GET["speciesRequest"])) {
    echo $handler->JSON_RequestSpeciesList();
}

if (isset($_GET["zone"])) {
    $zone = $_GET["zone"]; //Probably should sanitize this shit
    echo $handler->JSON_RequestTreesByZone($zone);
}

if (isset($_GET["pFacts"])) {
    echo $tTable->JSON_getStats();
}

if (isset($_GET["wFacts"])) {
    echo $wfTable->JSON_getFacts();
}

if (isset($_GET["news"])) {
    echo $nTable->JSON_getNews();
}

if (isset($_GET["t"])) {
    $trees = json_decode($_GET["t"]);
    if (isset($trees[0])) {
        $i = 0;
        $treeList = array();
        while (isset($trees[$i])) {
            $treeList[$i] = $handler->RequestTById($trees[$i]);
            $i++;
        }
        echo json_encode($treeList);
    }
    else {
        echo json_encode($handler->RequestTById($trees));
    }
}

if (isset($_GET["flowerMonth"])) {
    $months = json_decode($_GET["flowerMonth"]);
    if (isset($months[0])) {
        $i = 0;
        $json = "[";
        while (isset($months[$i])) {
            $json .= $fmTable->JSON_speciesByMonth($months[$i]);
            $json .= ",";
            $i++;
        }
        $res = substr($json, 0, -1) . "]";
    }
    else {
        $res = $fmTable->JSON_speciesByMonth($months);
    }
    echo $res;
}

if (isset($_GET["fruitMonth"])) {
    $months = json_decode($_GET["fruitMonth"]);
    if (isset($months[0])) {
        $i = 0;
        $json = "[";
        while (isset($months[$i])) {
            $json .= $smTable->JSON_speciesByMonth($months[$i]);
            $json .= ",";
            $i++;
        }
        $res = substr($json, 0, -1) . "]";
    }
    else {
        $res = $smTable->JSON_speciesByMonth($months);
    }
    echo $res;
}
?>
