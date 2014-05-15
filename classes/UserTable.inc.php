/** This file is part of server-side of the CampusTrees Project. It is subject to the license terms in the LICENSE file found in the top-level directory of this distribution. No part of CampusTrees Project, including this file, may be copied, modified, propagated, or distributed except according to the terms contained in the LICENSE file.*/
<?php
//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");
require_once(ROOT_DIR . "classes/EntityUpdateTable.inc.php");


class User { 

    protected $uid;    //UUserId
    protected $user;   //UUsername
    protected $first;  //UFirstName
    protected $last;   //ULastName
    protected $email;  //UEmail
    protected $groupid;//UGroupId
    protected $active; //UActive
    protected $hash;   //UPassword
    protected $recid;


    public function User($uid, $user=null, $first=null, $last=null, $email=null, $groupid=null, $active=null, $hash=null, $recid=null) {
        if (isset($user)) {
            $this->uid = $uid;
            $this->user = $user;
            $this->first = $first;
            $this->last = $last;
            $this->email = $email;
            $this->groupid = $groupid;
            $this->active = $active;
            $this->hash = $hash;
            $this->recid = $recid;
        }
        else {
            $dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
            $query = "SELECT * from User WHERE UUserId =
            {$dbres->escapeString($uid)}";
            $res = $dbres->query($query);
            $data = mysql_fetch_assoc($res);

            $this->uid = $data['UUserId'];
            $this->user = $data['UUsername'];
            $this->first = $data['UFirstName'];
            $this->last = $data['ULastName'];
            $this->email = $data['UEmail'];
            $this->groupid = $data['UGroupId'];
            $this->active = $data['UActive'];
            $this->hash = $data['UPassword'];
            $this->recid = $data['URecId'];
        }
    }

        public function getProperties() {
            $properties = get_object_vars($this);
            return $properties;
        }

        public function update($f) {
            $dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
            $euTable = new EntityUpdateTable();
            $any = false;
            $query = "UPDATE User SET ";
            $remov = 0; //Need to implement removal for species

            if (isset($f['user'])) {
                $query .= "UUsername = '{$dbres->escapeString($f['user'])}', ";
                $any = True;
            }

            if (isset($f['first'])) {
                $query .= "UFirstName = '{$dbres->escapeString($f['first'])}', ";
                $any = True;
            }

            if (isset($f['last'])) {
                $query .= "ULastName = '{$dbres->escapeString($f['last'])}', ";
                $any = True;
            }

            if (isset($f['email'])) {
                $query .= "UEmail = '{$dbres->escapeString($f['email'])}', ";
                $any = True;
            }

            if (isset($f['groupid'])) {
                $query .= "UGroupId = '{$dbres->escapeString($f['groupid'])}', ";
                $any = True;
            }

            if (isset($f['hash'])) {
                $query .= "UPassword = '{$dbres->escapeString($f['hash'])}', ";
                $any = True;
            }

            if (isset($f['gid'])) {
                $query .= "SGenusId = '{$dbres->escapeString($f['gid'])}', ";
                $any = True;
            }

            if (isset($f['active'])) {
                $query .= "UActive= '{$dbres->escapeString($f['active'])}', ";
                $any = True;
            }


            if ($any) {
                $query = substr($query, 0, -2);
                $query .= " WHERE UUserId = {$this->uid}";
//              echo $query;
//              echo "<br>";
                $dbres->query($query);
                $euTable->logUpdate(7, $this->recid, $f['uid'], $remov);
            }
        }

}
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

    public function getNextId() {
        $query = "SELECT UUserId FROM User ORDER BY UUserId DESC LIMIT 1";
        $res = $this->dbres->query($query);
        $last = (int) mysql_result($res, 0);
        return $last + 1;
    }

    public function addUser($userid, $user, $first, $last, $email, $groupid, $hash, $uid) {
        $query = "INSERT INTO User (UUserId, UUsername,
                    UFirstName, ULastName, UEmail, UGroupId, UPassword,
                    UCreatorId)
                  VALUES (
            '{$this->dbres->escapeString($userid)}',
            '{$this->dbres->escapeString($user)}',
            '{$this->dbres->escapeString($first)}',
            '{$this->dbres->escapeString($last)}',
            '{$this->dbres->escapeString($email)}',
            '{$this->dbres->escapeString($groupid)}',
            '{$this->dbres->escapeString($hash)}',
            '{$this->dbres->escapeString($uid)}',";
            $query = substr($query, 0, -1);
            $query .= ")";
//              echo "<br>{$query}<br>";
            $this->dbres->query($query);
//              echo $this->dbres->getLastError();
            return true;
    }

/*
*/
}

?>
