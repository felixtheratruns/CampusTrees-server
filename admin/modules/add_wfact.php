<!-- This file is part of server-side of the CampusTrees Project. It is subject to the license terms in the LICENSE file found in the top-level directory of this distribution. No part of CampusTrees Project, including this file, may be copied, modified, propagated, or distributed except according to the terms contained in the LICENSE file.-->
<?php
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'admin/modules/auth.inc.php');

if (isset($debug)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}
?>

<h1>Add News</h1>
<form name="add_wfact" action="post_new_wfact.php" method="POST">
<a href="list_wfact.php">Wildlife Fact List</a><br><br>
Title: <input type="text" name="title" value="Title"><br />
Body: <textarea name="body" rows="8" cols="120">Wildlife Fact</textarea>
<br />
<br />

<input type="submit" value="Submit">
</form>
