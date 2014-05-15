/** This file is part of server-side of the CampusTrees Project. It is subject to the license terms in the LICENSE file found in the top-level directory of this distribution. No part of CampusTrees Project, including this file, may be copied, modified, propagated, or distributed except according to the terms contained in the LICENSE file.*/
<?php
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/genus.inc.php');
require_once(ROOT_DIR . 'admin/modules/auth.inc.php');

if (isset($debug)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}
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
