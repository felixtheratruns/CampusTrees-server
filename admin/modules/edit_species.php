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
    ?>
    <h1>Edit Species</h1>
    <form name="edit_species" method="POST">
    <h2>Basic Information</h2>
    Species ID:<?php echo " {$species['sid']}"; ?><br />
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
    Tree native to America: <input type="checkbox" name="nativity" value="american" <?php if ($species['american']) {echo "checked=\"checked\"";}?>><br />
    Tree native to KY: <input type="checkbox" name="nativity" value="ky" <?php if ($species['ky']) {echo "checked=\"checked\"";}?>><br />
    <br />
    
    <?php
    if ($species['fruittype'] != 'none') {
        ?>
        <h2>Fruit Information</h2>
        Fruit Type: <input type="text" name="fruittype" value="<?php echo $species['fruittype']; ?>"><br />
        Edible Fruit: <input type="checkbox" name="fruit" value="edible" <?php if ($species['edible']) {echo "checked=\"checked\"";}?>><br />
        Fruiting Months:<br />
        <?php
        foreach ($sms as $sm) {
            echo "{$sm['mid']}<br>";
        }
        ?>
        
        <br />
    <?php
    }
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
    ?>
    <h2>Comments</h2>
    <textarea name="SComments" rows="8" cols="120"><?php echo $species['comments'];?></textarea>
    
    </form>
    <?php
}
?>
