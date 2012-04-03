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
    ?>
    </select><br />
    
    Tree Location: <input type="text" size="10" name="lat" value="<?php echo $tree['lat'];?>"> Lat, <input type="text" size="10" name="long" value="<?php echo $tree['long'];?>"> Long<br />
    <br />

    <h2>Measurements</h2>
    Tree Height: <input type="text" name="height" value="<?php echo $tree['height'];?>"><br />
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
    $hist = $euTable->getEditHistory(1, $tree['id']);
    foreach ($hist as $row) {
        echo "Edited: {$row['date']} by 
              <a href=\"view_user.php?uid={$row['uid']}\">{$row['uname']}</a>";
        if ($row['rem'] == 1) {echo " Tree Removed"; }
        echo "<br>";
    }
}
?>
