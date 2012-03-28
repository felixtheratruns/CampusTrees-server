This is an admin page!
<?php
//Check if a user is logged into the admin section
$loggedIn = FALSE;

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
<?php
}
?>
