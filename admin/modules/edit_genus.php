<?php
$user = 1;
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/genus.inc.php');
?>

<?php
if (isset($_POST['gid'])) { //IF Handling an update:
    $gid = $_POST['gid'];
    $g = new genus($gid);
    $genus = $g->getProperties();
    $genusn = $_POST['genus'];
    $nick = $_POST['nick'];

    $fields['gid'] = $genus['gid'];
    $fields['uid'] = $user;

    if ($genus['genus'] != $genusn) {
        $fields['genus'] = $genusn;
    }
    
    if ($genus['nick'] != $nick) {
        $fields['nick'] = $nick;
    }
    
    $g->update($fields);
}
if (!isset($_GET['gid'])) {
    //No species selected, so list species
    echo "<HEAD><meta http-equiv=\"REFRESH\" content=\"0;url=" . HOME ."admin/modules/list_genus.php\"></HEAD>";
}
else {
    //Species selected
    $gid = $_GET['gid'];
    $g = new Genus($gid);
    $genus = $g->getProperties();
    $species = $g->getSpecies();
    $euTable = new EntityUpdateTable();
    ?>
    <h1>Edit Genus</h1>
    <form name="edit_genus" action="edit_genus.php?gid=<?php echo $genus['gid']; ?>" method="POST">
    <h2>Basic Information</h2>

    Genus ID:<?php echo " {$genus['gid']}"; ?><br />
    <input type="hidden" name="gid" value="<?php echo $genus['gid'];?>">
    <a href="list_genus.php">Genus List</a><br><br>
    Genus Name: <input type="text" name="genus" value="<?php echo $genus['genus']; ?>"><br />
    Nickname: <input type="text" name="nick" value="<?php echo $genus['nick']; ?>"><br />
    Count: <?php echo $genus['count']; ?><br />

    <h2>Species:</h2>
    <?php
    foreach ($species as $s) {
        echo "<a href=\"edit_species.php?sid={$s['sid']}\">{$s['commonname']}</a><br />";
    }
    ?>
    <input type="submit" value="Submit">
    </form>
    <?php
    $hist = $euTable->getEditHistory(3, $genus['gid']);
    foreach ($hist as $row) {
        echo "Edited: {$row['date']} by 
              <a href=\"view_user.php?uid={$row['uid']}\">{$row['uname']}</a>";
        if ($row['rem'] == 1) {echo " Genus Removed"; }
        echo "<br>";
    }
}
?>
