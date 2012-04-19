<?php
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/species.inc.php');
require_once(ROOT_DIR . 'classes/GenusTable.inc.php');
require_once(ROOT_DIR . 'classes/genus.inc.php');
require_once(ROOT_DIR . 'classes/FlowerMonthsTable.inc.php');
require_once(ROOT_DIR . 'classes/SeedingMonthsTable.inc.php');
require_once(ROOT_DIR . 'admin/modules/auth.inc.php');

if (isset($debug)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}
?>

<?php
    $cal = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
if (isset($_POST['sid'])) { //IF Handling an update:
    $sid = $_POST['sid'];
    $s = new species($sid);
    $species = $s->getProperties(True);
    $commonname = $_POST['commonname'];
    $speciesn = $_POST['species'];
    $gf = $_POST['gf'];
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
    $fields['uid'] = $uid;

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
//      echo "edible = {$fields['edible']}";
    }
    
    if ($species['commonname'] != $commonname) {
        $fields['commonname'] = $commonname;
    }
    
    if ($species['species'] != $speciesn) {
        $fields['species'] = $speciesn;
    }
    
    if ($species['gf'] != $gf) {
        $fields['gf'] = $gf;
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
    $smTable = new SeedingMonthsTable();
    $euTable = new EntityUpdateTable();

    if (isset($_POST['month'])) {
    
        $type = null;
        if (isset($_GET['fruit'])) {
            $type = 'fruit';
            $mTable = new SeedingMonthsTable();
        }

        if (isset($_GET['flower'])) {
            $type = 'flower';
            $mTable = new FlowerMonthsTable();
        }

        if (isset($type)) {
            $ms = $mTable->monthsBySpecies($species['sid']);
            $months = array();
            foreach ($ms as $m) {
                array_push($months, $m['mid']);
//              echo "{$m['mid']}<br>";
            }
            foreach($cal as $month) {
                $cmonth = array_search($month, $cal)+1;
                if (isset($_POST[$month])) {
                    if (!in_array(array_search($month, $cal)+1, $months)) {
                        $mTable->addMonth($species['sid'], $cmonth);
                    }
                }
                else {
                    if (in_array(array_search($month, $cal)+1, $months)) {
                        $mTable->removeMonth($species['sid'], $cmonth);
                    }
                }
            }
        }
    }
    $fms = $fmTable->monthsBySpecies($species['sid']);
    $sms = $smTable->monthsBySpecies($species['sid']);
    ?>
    <h1>Edit Species</h1>
    <form name="edit_species" action="edit_species.php?sid=<?php echo $species['sid']; ?>" method="POST">
    <h2>Basic Information</h2>
    Species ID:<?php echo " {$species['sid']}"; ?><br />
    <input type="hidden" name="sid" value="<?php echo $species['sid'];?>">
    <a href="list_species.php">Species List</a><br><br>
    Common Name: <input type="text" name="commonname" value="<?php echo $species['commonname']; ?>"><br />
    Species Name: <input type="text" name="species" value="<?php echo $species['species']; ?>"><br />
    Growth Factor: <input type="text" name="gf" value="<?php echo $species['gf']; ?>">
    <?php 
        $g = new genus($species['gid']);
        echo " Genus Avg: {$g->getagf()}";
    ?>
    <br />
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
    Number of Trees:<?php echo " <a href=\"list_tree.php?sid={$species['sid']}\">{$species['count']}</a>"; ?><br>
    <br />
    
    <h2>Regional Information</h2>
    Tree native to America: <input type="checkbox" name="american" value="true" <?php if ($species['american']) {echo "checked=\"checked\"";}?>><br />
    Tree native to KY: <input type="checkbox" name="ky" value="true" <?php if ($species['ky']) {echo "checked=\"checked\"";}?>><br />
    <br />
    
    <h2>Fruit Information</h2>
    Fruit Type: <input type="text" name="fruittype" value="<?php echo $species['fruittype']; ?>"><br />
    Edible Fruit: <input type="checkbox" name="edible" value="true" <?php if ($species['edible']) {echo "checked=\"checked\"";}?>><br />

    <?php
    if ($sms[0]['mid'] != $species['sid']) {
        ?>
        <h4>Fruiting Months:</h4>
        <?php
        foreach ($sms as $sm) {
            echo "{$cal[$sm['mid']-1]}<br>";
        }
    }
        ?>
        
    <?php
    echo "<br><a href=\"edit_month.php?sid={$species['sid']}&fruit\">Edit Fruiting Months</a>";

    ?>
    <h2>Flower Information</h2>
    Flower Relative to Leaves: <input type="text" name="flowrelleaf" value="<?php echo $species['flowrelleaf']; ?>"><br />
    <?php
    if ($fms[0]['mid'] != $species['sid']) {
    ?>
        <h4>Flowering Months:</h4>
        <?php
        foreach ($fms as $fm) {
            echo "{$cal[$fm['mid']-1]}<br>";
        }
    }
    echo "<br><a href=\"edit_month.php?sid={$species['sid']}&flower\">Edit Flowering Months</a><br>";
    ?>
    <h2>Comments</h2>
    <textarea name="comments" rows="8" cols="120"><?php echo $species['comments'];?></textarea>
    
    <input type="submit" value="Submit">
    </form>
    <?php
    $hist = $euTable->getEditHistory(2, $species['recid']);
    foreach ($hist as $row) {
        echo "Edited: {$row['date']} by 
              <a href=\"view_user.php?uid={$row['uid']}\">{$row['uname']}</a>";
        if ($row['rem'] == 1) {echo " Species Removed"; }
        echo "<br>";
    }
}
?>
