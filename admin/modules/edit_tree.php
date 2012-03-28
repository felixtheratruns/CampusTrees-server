<?php
//Require authenticaiton here

?>

<h1>Edit Tree</h1>
<?php
if (!isset($_GET['id'])) {
//No tree selected, so list trees
}
else {
//Tree selected
$id = $_GET['id'];
?>
<form name="edit_tree" method="POST">
<h2>Basic Information</h2>
Tree ID:<br />

Tree Species: <select name="TTreeSpecies">
<option value="NULL" selected>Please select a species</option>
</select><br />

Tree Location: <input type="text" size="10" name="TTreeLat"> Lat, <input type="text" size="10" name="TTreeLong"> Long<br />
<br />

<h2>Measurements</h2>
Tree Height: <input type="text" name="TTreeHeight"><br />
<br />

<h2>Additional Information</h2>
Tree Removed: <input type="checkbox" name="TTreeRemoved"><br />
<br />

<h2>Comments</h2>
<textarea name="TTreeComments" rows="15" cols="120"></textarea>
</form>
<?php
}
?>
