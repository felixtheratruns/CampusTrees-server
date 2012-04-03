<?php
//Check if a user is logged into the admin section
$loggedIn = FALSE;
if (isset($_GET['login'])) {
    if ($_GET['login'] == 'ppp') {$loggedIn = true;}
}
//User is not logged in
if ($loggedIn !== TRUE) {
?>
This is the admin page!
<?php
}
//User is logged in
else {
?>
You are currently logged in.
<br>
<a href="modules/list_tree.php">List Trees</a><br>
<a href="modules/list_species.php">List Species</a><br>
<a href="modules/list_genus.php">List Genus</a><br>
<?php
}
?>
