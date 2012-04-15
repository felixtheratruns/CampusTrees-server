<?php
$user = 1;
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/genus.inc.php');
?>

<h1>Add Genus</h1>
<form name="edit_genus" action="post_new_genus.php" method="POST">
<h2>Basic Information</h2>

<a href="list_genus.php">Genus List</a><br><br>
Genus Name: <input type="text" name="genus" value=""><br />
Nickname: <input type="text" name="nick" value=""><br />
Average Growth Factor: <input type="text" name="agf" value=""><br />

<input type="submit" value="Submit">
</form>
