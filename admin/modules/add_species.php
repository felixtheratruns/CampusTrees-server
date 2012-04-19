<?php
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/species.inc.php');
require_once(ROOT_DIR . 'classes/GenusTable.inc.php');
require_once(ROOT_DIR . 'admin/modules/auth.inc.php');

if (isset($debug)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}
?>

<?php
    $cal = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

$gTable = new GenusTable();
$genus = $gTable->getAll();

?>
<h1>Add Species</h1>
<form name="add_species" action="post_new_species.php" method="POST">
<h2>Basic Information</h2>
<a href="list_species.php">Species List</a><br><br>
Common Name: <input type="text" name="commonname" value=""><br />
Species Name: <input type="text" name="species" value=""><br />
Growth Factor: <input type="text" name="gf" value="">
<br />
Genus: <select name="gid">
<?php
foreach ($genus as $g) {
    $string = "<option value=\"{$g['gid']}\"";
    $string .= ">{$g['genus']}</option>";
    echo $string;
}
echo "</select> <a href=\"add_genus.php\">Add New Genus</a>";
?>
<br />

<h2>Regional Information</h2>
Tree native to America: <input type="checkbox" name="american" value="true"><br />
Tree native to KY: <input type="checkbox" name="ky" value="true"><br />
<br />

<h2>Fruit Information</h2>
Fruit Type: <input type="text" name="fruittype" value="none"><br />
Edible Fruit: <input type="checkbox" name="edible" value="true"><br />

<h2>Flower Information</h2>
Flower Relative to Leaves: <input type="text" name="flowrelleaf" value=""><br />
<h2>Comments</h2>
<textarea name="comments" rows="8" cols="120">NA</textarea>

<input type="submit" value="Submit">
</form>
