<?php
//Require authenticaiton here
//Assuming we will know the user's id and set $uid to this.
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/TreeTable.inc.php');
require_once(ROOT_DIR . 'classes/tree.inc.php');
require_once(ROOT_DIR . 'classes/SpeciesTable.inc.php');
?>

<h1>Edit Tree</h1>
<?php
if (!isset($_GET['t'])) {
//No tree selected, so list trees
echo "<HEAD><meta http-equiv=\"REFRESH\" content=\"0;url=" . HOME ."admin/modules/list_tree.php\"></HEAD>";
}
else {
//Tree selected
$id = $_GET['t'];
$t = new tree($id);
$sTable = new SpeciesTable();
$tree = $t->getProperties(True);
$species = $sTable->GetSpecies();
?>
<form name="edit_tree" action="update_tree.php" method="POST">
<h2>Basic Information</h2>
Tree ID:<?php echo " {$tree['id']}"; ?><br />
<input type="hidden" name="id" value="<?php echo $tree['id'];?>"><br />

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
<?php
}
?>
