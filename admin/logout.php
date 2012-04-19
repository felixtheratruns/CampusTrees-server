<?php
require_once('../config.inc.php');
session_start();
session_destroy();
header("location:" . HOME . "admin/main_login.php");

?>
