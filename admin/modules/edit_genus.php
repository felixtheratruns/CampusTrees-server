<?php
$user = 1;
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/genus.inc.php');
?>

<?php
if (isset($_POST['gid'])) { //IF Handling an update:
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
    ?>
    <h1>Edit Genus</h1>
    <br />
    <h2>Basic Information</h2>

    Genus ID:<?php echo " {$genus['gid']}"; ?><br />
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

<?php
}
?>



