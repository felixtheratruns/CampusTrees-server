<?php
//Require authenticaiton here

?>

<h1>Edit Species</h1>
<?php
if (!isset($_GET['id'])) {
//No species selected, so list species
}
else {
//Species selected
$id = $_GET['id'];
?>
<form name="edit_species" method="POST">
<h2>Basic Information</h2>
Species ID:<br />
Species Name: <input type="text" name="SCommonName"><br />
Genus: <select name="SGenusID">
<option value="NULL" selected>Select a Genus</option>
</select><br />
<br />

<h2>Regional Information</h2>
Tree native to America: <input type="checkbox" name="SNAmerica"><br />
Tree native to KY: <input type="checkbox" name="SNKy"><br />
<br />

<h2>Comments</h2>
<textarea name="SComments" rows="8" cols="120"></textarea>

</form>
<?php
}
?>
