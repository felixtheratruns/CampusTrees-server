<?php
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/UserTable.inc.php');
require_once(ROOT_DIR . 'admin/modules/auth.inc.php');

if (isset($debug)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}
?>


<h1>Add User</h1>
<form name="add_user" action="post_new_user.php" method="POST">
Username: <input type="text" name="user" value=""><br />
First Name: <input type="text" name="first" value=""><br />
Last Name: <input type="text" name="last" value=""><br />
Email: <input type="text" name="email" value=""><br />
Group Id: <input type="text" name="groupid" value=""><br />
Password: <input type="password" name="password" value=""><br />

Active: <input type="checkbox" name="active" value="true"><br />

<input type="submit" value="Submit">
</form>
