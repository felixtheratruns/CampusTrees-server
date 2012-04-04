<?php
//Require authenticaiton here

$user = 1;
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/species.inc.php');
require_once(ROOT_DIR . 'classes/GenusTable.inc.php');
require_once(ROOT_DIR . 'classes/FlowerMonthsTable.inc.php');
require_once(ROOT_DIR . 'classes/SeedingMonthsTable.inc.php');
?>

<?php
if (isset($_POST['sid'])) { //IF Handling an update:
    $sid = $_POST['sid'];
    $s = new species($sid);
    $species = $s->getProperties(True);
    $commonname = $_POST['commonname'];
    $speciesn = $_POST['species'];
    $gid = $_POST['gid'];
    $comments = $_POST['comments'];

    if (isset($_POST['fruittype'])) {
        $fruittype = $_POST['fruittype'];
    }
    else {$fruittype = 'none';}
    if (isset($_POST['flowrelleaf'])) {
        $flowrelleaf = $_POST['flowrelleaf'];
    }
    else {$flowrelleaf = 0;}
    $american = 0;
    $ky = 0;
    $edible = 0;

    $fields['sid'] = $species['sid'];
    $fields['uid'] = $user;

    if (isset($_POST['american'])) {
        $american = 1;
    }
    
    if (isset($_POST['ky'])) {
        $ky = 1;
    }
    
    if (isset($_POST['edible'])) {
        $edible = 1;
    }
    
    if ($species['american'] != $american) {
        if ($american) { $fields['american'] = 1;}
        else { $fields['american'] = 0; }
    }
    
    if ($species['ky'] != $ky) {
        if ($ky) { $fields['ky'] = 1;}
        else { $fields['ky'] = 0; }
    }
    
    if ($species['edible'] != $edible) {
        if ($edible) { $fields['edible'] = 1;}
        else { $fields['edible'] = 0; }
        echo "edible = {$fields['edible']}";
    }
    
    if ($species['commonname'] != $commonname) {
        $fields['commonname'] = $commonname;
    }
    
    if ($species['species'] != $speciesn) {
        $fields['species'] = $speciesn;
    }
    
    if ($species['gid'] != $gid) {
        $fields['gid'] = $gid;
    }
    
    if ($species['fruittype'] != $fruittype) {
        $fields['fruittype'] = $fruittype;
    }
    
    if ($species['flowrelleaf'] != $flowrelleaf) {
        $fields['flowrelleaf'] = $flowrelleaf;
    }
    
    if ($species['comments'] != $comments) {
        $fields['comments'] = $comments;
    }
    
    $s->update($fields);
}
if (!isset($_GET['sid'])) {
    //No species selected, so list species
    echo "<HEAD><meta http-equiv=\"REFRESH\" content=\"0;url=" . HOME ."admin/modules/list_species.php\"></HEAD>";
}
else {
    //Species selected
    $sid = $_GET['sid'];
    $s = new species($sid);
    $species = $s->getProperties(True);
    $gTable = new GenusTable();
    $genus = $gTable->getAll();
    $fmTable = new FlowerMonthsTable();
    $fms = $fmTable->monthsBySpecies($species['sid']);
    $smTable = new SeedingMonthsTable();
    $sms = $smTable->monthsBySpecies($species['sid']);
    $euTable = new EntityUpdateTable();
    ?>
    <h1>Edit Species</h1>
    <form name="edit_species" action="edit_species.php?sid=<?php echo $species['sid']; ?>" method="POST">
    <h2>Basic Information</h2>
    Species ID:<?php echo " {$species['sid']}"; ?><br />
    <input type="hidden" name="sid" value="<?php echo $species['sid'];?>">
    <a href="list_species.php">Species List</a><br><br>
    Common Name: <input type="text" name="commonname" value="<?php echo $species['commonname']; ?>"><br />
    Species Name: <input type="text" name="species" value="<?php echo $species['species']; ?>"><br />
    Genus: <select name="gid">
    <?php
    foreach ($genus as $g) {
        $string = "<option value=\"{$g['gid']}\"";
        if ($g['gid'] == $species['gid']) {$string .= "selected";}
        $string .= ">{$g['genus']}</option>";
        echo $string;
    }
    echo "</select> <a href=\"edit_genus.php?gid={$species['gid']}\">Edit Genus</a>";
    ?>
    <br />
    Number of Trees:<?php echo " {$species['count']}"; ?><br>
    <br />
    
    <h2>Regional Information</h2>
    Tree native to America: <input type="checkbox" name="american" value="true" <?php if ($species['american']) {echo "checked=\"checked\"";}?>><br />
    Tree native to KY: <input type="checkbox" name="ky" value="true" <?php if ($species['ky']) {echo "checked=\"checked\"";}?>><br />
    <br />
    
    <?php
    if ($species['fruittype'] != 'none') {
        ?>
        <h2>Fruit Information</h2>
        Fruit Type: <input type="text" name="fruittype" value="<?php echo $species['fruittype']; ?>"><br />
        Edible Fruit: <input type="checkbox" name="edible" value="true" <?php if ($species['edible']) {echo "checked=\"checked\"";}?>><br />
        Fruiting Months:<br />
        <?php
        foreach ($sms as $sm) {
            echo "{$sm['mid']}<br>";
        }
        ?>
        
        <br />
    <?php
    }
    else {echo "<a href=\"ToDo\">Add Fruit</a><br />";}//TODO:This
    if ($species['flowrelleaf'] != 0) {
        ?>
        <h2>Flower Information</h2>
        Flower Relative to Leaves: <input type="text" name="flowrelleaf" value="<?php echo $species['flowrelleaf']; ?>"><br />
        Flowering Months:<br />
        <?php
        foreach ($fms as $fm) {
            echo "{$fm['mid']}<br>";
        }
        ?>
        <br />
        <?php
    }
    else {echo "<a href=\"ToDo\">Add Flower</a><br />";}//TODO:This too!!
    ?>
    <h2>Comments</h2>
    <textarea name="comments" rows="8" cols="120"><?php echo $species['comments'];?></textarea>
    
    <input type="submit" value="Submit">
    </form>
    <?php
    $hist = $euTable->getEditHistory(2, $species['sid']);
    foreach ($hist as $row) {
        echo "Edited: {$row['date']} by 
              <a href=\"view_user.php?uid={$row['uid']}\">{$row['uname']}</a>";
        if ($row['rem'] == 1) {echo " Species Removed"; }
        echo "<br>";
    }
}
?>
