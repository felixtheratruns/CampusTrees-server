<?php
//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");


class UserTable { 

    private $dbres;		//Database resource

    public function UserTable() {
        $this->dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
    }

    public function checkLogin($user, $pw) {
        $query = "SELECT UUserId, UPassword, UActive FROM User
                  WHERE UUsername = '{$this->dbres->escapeString($user)}'
                  LIMIT 1";
        $res = $this->dbres->query($query);
        if (mysql_num_rows($res) == 1) {
            $uid = mysql_result($res, 0, 0);
            $hash = mysql_result($res, 0, 1);
            $active = mysql_result($res, 0, 2);
            if (md5($pw) == $hash) {
                if($active != 1) {
                    echo "<br>User Deactivated<br>";
                    return false;
                }
                else {return $uid;}
            }
        }
        return false;
    }
}

?>
