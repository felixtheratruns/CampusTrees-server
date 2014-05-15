<!-- This file is part of server-side of the CampusTrees Project. It is subject to the license terms in the LICENSE file found in the top-level directory of this distribution. No part of CampusTrees Project, including this file, may be copied, modified, propagated, or distributed except according to the terms contained in the LICENSE file.-->
<?php
//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");

class EntityUpdateRecord {
        protected $uname;
        protected $uid;
        protected $rem;
        protected $date;

        public function EntityUpdateRecord($username, $userid, $removed, $updatedate) {
           $this->uname = $username;
           $this->uid = $userid;
           $this->rem = $removed;
           $this->date = $updatedate;
        }

        public function getProperties() {
            $properties = get_object_vars($this);
            return $properties;
        }
}
class EntityUpdateTable { 
//General Properties
        private $dbres;
        //Contructor
        public function EntityUpdateTable() {
            $this->dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
        }

        public function logUpdate($eid, $refid, $upid, $remov) {
            $query = "INSERT INTO EntityUpdate (EUEntityTypeId, EURefRecId,
                        EURefRecUpdatorId, EURefRecRemoved)
                        VALUES ({$this->dbres->escapeString($eid)},
                        {$this->dbres->escapeString($refid)},
                        {$this->dbres->escapeString($upid)},
                        {$remov})";
//          echo $query;
            $this->dbres->query($query);
        }

        public function getEditHistory($eid, $refid) {
            $query = "SELECT UUserName, UUserId,
                      EURefRecRemoved, EURefRecUpdatedDate
                      FROM EntityUpdate INNER JOIN User ON (EURefRecUpdatorId = UUserId)
                      WHERE EUEntityTypeId = {$this->dbres->escapeString($eid)} 
                      AND EURefRecId = {$this->dbres->escapeString($refid)}";
//          echo $query;
            $res = $this->dbres->query($query);
            $i = 0;
            $hist = array();
            while($row = mysql_fetch_assoc($res)) {
                $euRec = new EntityUpdateRecord($row['UUserName'], $row['UUserId'],
                  $row['EURefRecRemoved'], $row['EURefRecUpdatedDate']);
                $hist[$i] = $euRec->getProperties();
                $i++;
            }
            return $hist;
        }
}
?>
