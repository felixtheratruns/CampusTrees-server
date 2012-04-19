<?php
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/TreeTable.inc.php');
require_once(ROOT_DIR . 'classes/SpeciesTable.inc.php');
require_once(ROOT_DIR . 'admin/modules/auth.inc.php');

if (isset($debug)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

    $sTable = new SpeciesTable();
    $species = $sTable->GetSpecies();
    ?>

    <h1>Add Tree</h1>
    <form name="edit_tree" action="post_new_tree.php" method="POST">
    <h2>Basic Information</h2>
    Tree ID: New Tree<br />

    <a href="list_tree.php">Tree List</a><br><br>
    Tree Species: <select name="sid">
    <?php 
    foreach ($species as $s) {
        $string = "<option value=\"{$s['sid']}\"";
        $string .= ">{$s['commonname']}</option>";
        echo $string;
    }
    echo "</select> <a href=\"add_species.php\">Add New Species</a>";
    ?>
    <br />
    <br />
    <h2>Location</h2>
 <input type="text" size="10" name="lat" value="0"> Lat, <input type="text" size="10" name="long" value="0"> Long<br />
    Area: <input type="text" name="area" value="0"><br />
    Quad: <input type="text" name="quad" value="1"><br />
    <br />

    <h2>Measurements</h2>
    Tree Height: <input type="text" name="height" value="0"><br />
    Tree DBH: <input type="text" name="dbh" value="0"><br />
    Tree Crown Width 1: <input type="text" name="cw1" value="0"><br />
    Tree Crown Width 2: <input type="text" name="cw2" value="0"><br />
    Dist Crown: <input type="text" name="dcrn" value="0"><br />
    Dist Tree: <input type="text" name="dtree" value="0"><br />
    Crown Id: <input type="text" name="crwnid" value="0"><br />
    <br />
    
    
    <h2>Comments</h2>
    <textarea name="comments" rows="15" cols="120" >NA</textarea>
    <br>
    <input type="submit" value="Submit">
    </form>
    <br>
    <?php

?>
