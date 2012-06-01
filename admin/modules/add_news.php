<?php
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'admin/modules/auth.inc.php');

if (isset($debug)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}
?>

<h1>Add News</h1>
<form name="add_news" action="post_new_news.php" method="POST">
<a href="list_news.php">News List</a><br><br>
Title: <input type="text" name="title" value="Title"><br />
Species Name: <textarea name="body" rows="8" cols="120">News</textarea>
<br />
<br />

<input type="submit" value="Submit">
</form>
