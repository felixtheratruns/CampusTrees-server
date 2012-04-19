<?php
require_once('../../config.inc.php');
require_once(ROOT_DIR . 'classes/UserTable.inc.php');
require_once(ROOT_DIR . 'admin/modules/auth.inc.php');
$debug = 1;
if (isset($debug)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}
?>


<?php
if (isset($_POST['uid'])) { //IF Handling an update:
    $euid = $_POST['uid'];
    $u = new User($euid);
    $user = $u->getProperties(True);
    $usern = $_POST['user'];
    $first = $_POST['first'];
    $last = $_POST['last'];
    $email = $_POST['email'];
    $groupid = $_POST['groupid'];
    if(!$_POST['password'] == "") {$hash = md5($_POST['password']);}

    $active = 0;
    if (isset($_POST['active'])) {
        $active = 1;
    }

    $fields['uid'] = $uid;

    
    if ($user['active'] != $active) {
        if ($active) { $fields['active'] = 1;}
        else { $fields['active'] = 0; }
    }
    
    if ($user['user'] != $usern) {
        $fields['user'] = $usern;
    }
    
    if ($user['first'] != $first) {
        $fields['first'] = $first;
    }
    
    if ($user['last'] != $last) {
        $fields['last'] = $last;
    }
    
    if ($user['email'] != $email) {
        $fields['email'] = $email;
    }
    
    if ($user['groupid'] != $groupid) {
        $fields['groupid'] = $groupid;
    }
    
    if (isset($hash)) {
        if ($user['hash'] != $hash) {
            $fields['hash'] = $hash;
        }
    }
    
    
    $u->update($fields);
}
if (!isset($_GET['uid'])) {
    //No species selected, so list species
    echo "<HEAD><meta http-equiv=\"REFRESH\" content=\"0;url=" . HOME ."admin/index.php\"></HEAD>";
}
else {
    //Species selected
    $euid = $_GET['uid'];
    $u = new User($euid);
    $user = $u->getProperties(True);
?>
<h1>Edit User <? echo " {$user['user']}";?></h1>
<form name="edit_user" action="edit_user.php?uid=<?php echo $user['uid'];?>" method="POST">
<input type="hidden" name="uid" value="<?php echo $user['uid'];?>">
Username: <input type="text" name="user" value="<?php echo "{$user['user']}";?>"><br />
First Name: <input type="text" name="first" value="<?php echo "{$user['first']}";?>"><br />
Last Name: <input type="text" name="last" value="<?php echo "{$user['last']}";?>"><br />
Email: <input type="text" name="email" value="<?php echo "{$user['email']}";?>"><br />
Group Id: <input type="text" name="groupid" value="<?php echo "{$user['groupid']}";?>"><br />
Password: <input type="password" name="password" value=""><br />

Active: <input type="checkbox" name="active" value="true" <?php if ($user['active']) {echo "checked=\"checked\"";}?>><br />

<input type="submit" value="Submit">
</form>

<?php
}
?>
