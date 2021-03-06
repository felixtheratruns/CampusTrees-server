<!-- This file is part of server-side of the CampusTrees Project. It is subject to the license terms in the LICENSE file found in the top-level directory of this distribution. No part of CampusTrees Project, including this file, may be copied, modified, propagated, or distributed except according to the terms contained in the LICENSE file.-->
<?php
//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");

class MaintenanceTypeRec {
    protected $tyid;    //MTMaintenanceTypeId
    protected $ty;      //MTMaintenanceType
    protected $damage;      //MTDamage
    protected $uid;      //MTRecCreatorId

    public function MaintenanceTypeRec($mttyid, $mtty, $mtdamage, $mtuid) {
        $this->tyid = $mttyid;
        $this->ty = $mtty;
        $this->damage = $mtdamage;
        $this->uid = $mtuid;
    }

    public function getProperties() {
        $properties = get_object_vars($this);
        return $properties;
    }


}

class MaintenanceEventRec { 

    protected $tyid;    //MEMaintenanceTypeId
    protected $comments;      //MEComments
    protected $date;      //MERecCreatedDate
    protected $uid;      //MERecCreatorId
    protected $tid;      //METreeId
    protected $user;

    public function MaintenanceEventRec($metyid, $mecomments, $medate, $meuid, $metid, $uuser) {
        $this->tyid = $metyid;
        $this->comments = $mecomments;
        $this->date = $medate;
        $this->uid = $meuid;
        $this->tid = $metid;
        $this->user = $uuser;
    }

    public function getProperties() {
        $properties = get_object_vars($this);
        return $properties;
    }


}

class MaintenanceTables { 
    private $dbres;		//Database resource

    public function MaintenanceTables() {
        $this->dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
    }

    public function getTypes($damaged) {
        if ($damaged) {$query = "SELECT * FROM MaintenanceType WHERE MTDamage = 1";}
        else {$query = "SELECT * FROM MaintenanceType WHERE MTDamage = 0";}
        $res = $this->dbres->query($query);
        $i = 0;
        $types = array();
        while ($row = mysql_fetch_assoc($res)) {
            $mtRec = new MaintenanceTypeRec($row['MTMaintenanceTypeId'], $row['MTMaintenanceType'],
                                            $row['MTDamage'], $row['MTRecCreatorId']);
            $types[$i] = $mtRec->getProperties();
            $i++;
        }
        return $types;
    }

    public function getHist($treeid, $tyid) {
        $query = "SELECT * FROM MaintenanceEvent inner join User on (MERecCreatorId = UUserId) WHERE
                  MEMaintenanceTypeId = '{$this->dbres->escapeString($tyid)}' AND
                  METreeId = '{$this->dbres->escapeString($treeid)}'
                  ORDER BY MERecCreatedDate DESC";

        $res = $this->dbres->query($query);
        $i = 0;
        $events = array();
        while ($row = mysql_fetch_assoc($res)) {
            $meRec = new MaintenanceEventRec($row['MEMaintenanceTypeId'], $row['MEComments'],
                                            $row['MERecCreatedDate'], $row['MERecCreatorId'],
                                            $row['METreeId'], $row['UUsername']);
            $events[$i] = $meRec->getProperties();
            $i++;
        }
        return $events;
    }
  
        public function logEvent($treeid, $tyid, $comments, $uid) {
            $query = "INSERT INTO MaintenanceEvent (MEMaintenanceTypeId,
                        MEComments, MERecCreatorId, METreeId)
                        VALUES ('{$this->dbres->escapeString($tyid)}',
                        \"{$this->dbres->escapeString($comments)}\",
                        '{$this->dbres->escapeString($uid)}', 
                        '{$treeid}')";
//          echo $query;
            $this->dbres->query($query);
//          echo $this->dbres->getLastError();
        }
  
}
