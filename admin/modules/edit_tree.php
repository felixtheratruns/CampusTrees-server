<?php
//Require authenticaiton here
//Assuming we will know the user's id and set $uid to this.
$user = 1;
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/TreeTable.inc.php');
require_once(ROOT_DIR . 'classes/tree.inc.php');
require_once(ROOT_DIR . 'classes/SpeciesTable.inc.php');
require_once(ROOT_DIR . 'classes/EntityUpdateTable.inc.php');
if (isset($_POST['id'])) { //IF Handling an update:
    $id = $_POST['id'];
    $t = new tree($id);
    $tree = $t->getProperties(True);
    
    $lat = $_POST['lat'];
    $long = $_POST['long'];
    $sid = $_POST['sid'];
    $height = $_POST['height'];
    $removed = false;
    $comments = $_POST['comments'];
    $dbh = $_POST['dbh'];
    $cw1 = $_POST['cw1'];
    $cw2 = $_POST['cw2'];
    $area = $_POST['area'];
    $quad = $_POST['quad'];
    $dcrn = $_POST['dcrn'];
    $dtree = $_POST['dtree'];
    $crwnid = $_POST['crwnid'];
    
    if (isset($_POST['removed'])) {
        $removed = true;
    }
    
    $fields['id'] = $tree['id'];
    $fields['uid'] = $user;
    
    if ($tree['lat'] != $lat) {
        $fields['lat'] = $lat;
    }
    
    if ($tree['long'] != $long) {
        $fields['long'] = $long;
    }
    
    if ($tree['sid'] != $sid) {
        $fields['sid'] = $sid;
    }
    
    if ($tree['height'] != $height) {
        $fields['height'] = $height;
    }
    
    if ($tree['removed'] != $removed) {
        if ($removed) { $fields['removed'] = 1;}
        else { $fields['removed'] = 0; }
    }
    
    if ($tree['comments'] != $comments) {
        $fields['comments'] = $comments;
    }
    
    if ($tree['dbh'] != $dbh) {
        $fields['dbh'] = $dbh;
    }
    
    if ($tree['cw1'] != $cw1) {
        $fields['cw1'] = $cw1;
    }
    
    if ($tree['cw2'] != $cw2) {
        $fields['cw2'] = $cw2;
    }
    
    if ($tree['area'] != $area) {
        $fields['area'] = $area;
    }
    
    if ($tree['quad'] != $quad) {
        $fields['quad'] = $quad;
    }
    
    if ($tree['dcrn'] != $dcrn) {
        $fields['dcrn'] = $dcrn;
    }
    
    if ($tree['dtree'] != $dtree) {
        $fields['dtree'] = $dtree;
    }
    
    if ($tree['crwnid'] != $crwnid) {
        $fields['crwnid'] = $crwnid;
    }
    
    $t->update($fields);
    
}
if (!isset($_GET['t'])) {//No tree selected, so list trees
    echo "<HEAD><meta http-equiv=\"REFRESH\" content=\"0;url=" . HOME ."admin/modules/list_tree.php\"></HEAD>";
}
else {//Tree selected - Display Form:
    $id = $_GET['t'];
    $t = new tree($id);
    $sTable = new SpeciesTable();
    $tree = $t->getProperties(True);
    $species = $sTable->GetSpecies();
    $euTable = new EntityUpdateTable();
    ?>

    <h1>Edit Tree</h1>
    <form name="edit_tree" action="edit_tree.php?t=<?php echo $tree['id']; ?>" method="POST">
    <h2>Basic Information</h2>
    Tree ID:<?php echo " {$tree['id']}"; ?><br />
    <input type="hidden" name="id" value="<?php echo $tree['id'];?>">

    <a href="list_tree.php">Tree List</a><br><br>
    Tree Species: <select name="sid">
    <?php 
    foreach ($species as $s) {
        $string = "<option value=\"{$s['sid']}\"";
        if ($s['sid'] == $tree['sid']) {$string .= " selected";}
        $string .= ">{$s['commonname']}</option>";
        echo $string;
    }
    echo "</select> <a href=\"edit_species.php?sid={$tree['sid']}\">Edit Species</a>";
    ?>
    <br />

    <h2>Calculated Data:</h2>
    Age:<?php
        echo " {$tree['age']}";
        if ($tree['avged']) {echo "*";}
    ?><br />
    Volume:<?php echo " {$tree['vol']}"; ?><br />
    Green Weight:<?php echo " {$tree['greenwt']}"; ?><br />
    Dry Weight:<?php echo " {$tree['drywt']}"; ?><br />
    Weight of Carbon:<?php echo " {$tree['carbonwt']}"; ?><br />
    Weight of CO2(Lifetime):<?php echo " {$tree['co2seqwt']}"; ?><br />
    Weight of CO2 (per Year):<?php
        echo " {$tree['co2pyear']}";
        if ($tree['avged']) {echo "*";}
    ?><br />
    Area of Crown:<?php echo " {$tree['crownarea']}"; ?><br />
    <br>
    
    <h2>Location</h2>
 <input type="text" size="10" name="lat" value="<?php echo $tree['lat'];?>"> Lat, <input type="text" size="10" name="long" value="<?php echo $tree['long'];?>"> Long<br />
    Area: <input type="text" name="area" value="<?php echo $tree['area'];?>"><br />
    Quad: <input type="text" name="quad" value="<?php echo $tree['quad'];?>"><br />
    <br />

    <h2>Measurements</h2>
    Tree Height: <input type="text" name="height" value="<?php echo $tree['height'];?>"><br />
    Tree DBH: <input type="text" name="dbh" value="<?php echo $tree['dbh'];?>"><br />
    Tree Crown Width 1: <input type="text" name="cw1" value="<?php echo $tree['cw1'];?>"><br />
    Tree Crown Width 2: <input type="text" name="cw2" value="<?php echo $tree['cw2'];?>"><br />
    Dist Crown: <input type="text" name="dcrn" value="<?php echo $tree['dcrn'];?>"><br />
    Dist Tree: <input type="text" name="dtree" value="<?php echo $tree['dtree'];?>"><br />
    Crown Id: <input type="text" name="crwnid" value="<?php echo $tree['crwnid'];?>"><br />
    <br />
    
    <h2>Additional Information</h2>
    Tree Removed: <input type="checkbox" name="removed" value="true" <?php if ($tree['removed']) {echo " checked=\"checked\"";}?>><br />
    <br />
    
    <h2>Comments</h2>
    <textarea name="comments" rows="15" cols="120" ><?php echo $tree['comments'];?></textarea>
    <br>
    <input type="submit" value="Submit">
    </form>
    <br>
    <?php
    $hist = $euTable->getEditHistory(1, $tree['recid']);
    foreach ($hist as $row) {
        echo "Edited: {$row['date']} by 
              <a href=\"view_user.php?uid={$row['uid']}\">{$row['uname']}</a>";
        if ($row['rem'] == 1) {echo " Tree Removed"; }
        echo "<br>";
    }
}
?>
