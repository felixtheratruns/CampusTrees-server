<?php
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'admin/modules/auth.inc.php');

if (isset($debug)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}
?>

<h1>Add ScavengerHunt</h1>
<form name="add_scavengerhunt" action="post_new_scavengerhunt.php" method="POST">
<a href="list_scavengerhunt.php">ScavengerHunt List</a><br><br>
Title: <input type="text" name="title" value="Title"><br />
Body: <textarea name="scavid" rows="8" cols="120">ScavengerHunt</textarea>
<br />
<br />

<input type="submit" value="Submit">
</form>
