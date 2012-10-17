<?php
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'admin/modules/auth.inc.php');

if (isset($debug)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}
?>

<h1>Add ScavengerHuntSubItem</h1>
<form name="add_scavengerhuntsubitem" action="post_new_scavengerhuntsubitem.php" method="POST">
<a href="list_scavengerhuntsubitem.php">ScavengerHuntSubItem List</a><br><br>
SScavId of the ScavengerHunt it belongs to: <input type="text" name="belong_id" value="0"><br />
Title: <input type="text" name="title" value="Title"><br />
Body: <textarea name="body" rows="8" cols="120">ScavengerHuntSubItem</textarea>
Png Path: <input type="text" name="png_name" value="Png name">
<br />
<br />

<input type="submit" value="Submit">
</form>
