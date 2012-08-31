<?php
//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");


class NewsRecord {
     protected $nid;
     protected $uname;
     protected $uid;
     protected $rem;
     protected $date;
     protected $title;
     protected $body;
 
     public function NewsRecord($nnid, $username, $userid, $removed, $updatedate, $ntitle, $nbody) {
        $this->nid = $nnid;
        $this->uname = $username;
        $this->uid = $userid;
        $this->rem = $removed;
        $this->date = $updatedate;
        $this->title = $ntitle;
        $this->body = $nbody;
     }
 
     public function getProperties() {
         $properties = get_object_vars($this);
         return $properties;
    }
}
class NewsTable { 
    private $dbres;  //Database resource
 
    //Contructor
    public function NewsTable() {
        $this->dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
    }
 
    public function GetNews($admin=false) {
        /*Precondition: Database connected and populated
         *Postcondition: Returns JSON optimized array of species info.
           */
        $res = $this->QueryGetNews();
#       echo $this->dbres->getLastError();
        return $this->buildList($admin, $res);
    }
 
    public function JSON_getNews($admin=false) {
        /*Precondition: Database connected and populated
         *Postcondition: Returns JSON optimized array of species info.
        */
        return JSON_encode($this->GetNews($admin));
    }
 
    private function buildList($admin, $sqlres) {
        $i = 0;
        if ($admin) {}//Write meeeee
        else {
            while ($row = mysql_fetch_assoc($sqlres)) {
                $r = new NewsRecord ((int)$row['NRecId'], $row['UUserName'],
                  (int)$row['NRecCreatorId'], (bool)$row['NRemoved'],
                  $row['NRecCreatedDate'], $row['NTitle'],
                  $row['NBody']);
                $selectedNewsRecs[$i] = $r->getProperties();
                $i++;
            }
        }
        return $selectedNewsRecs;
    }
 
    public function addNews($uid, $title, $body) {
         
        $query = "INSERT INTO News (NRecCreatorId, NTitle,
                    NBody, NRemoved)
                  VALUES (
            '{$this->dbres->escapeString($uid)}',
            \"{$this->dbres->escapeString($title)}\",
            \"{$this->dbres->escapeString($body)}\",
            0,";
            $query = substr($query, 0, -1);
            $query .= ")";
            echo "<br>{$query}<br>";
            $this->dbres->query($query);
            echo $this->dbres->getLastError();
            return true;
    }
 
    public function removeNews($nid) {
        $query = "UPDATE News SET NRemoved = '1' WHERE NRecId = {$this->dbres->escapeString($nid)}";
        echo $query;
        $this->dbres->query($query);
    }
 
    private function QueryGetNews() {
        /*Precondition: Database connected and populated
         *Postcondition: Returns mysql_dataset of species info*/
        return $this->dbres->query("SELECT UUserName, UUserId,
                      NRecId, NTitle,
                      NBody, NRecCreatedDate, NRecCreatorId, NRemoved
                  FROM News INNER JOIN User ON (NRecCreatorId = UUserId)
                  WHERE NRemoved = 0
                  ORDER BY NRecCreatedDate DESC
                ");
          
    }
 
 /*
     public function getNextId() {
         $query = "SELECT SSpeciesId FROM Species ORDER BY SSpeciesId DESC LIMIT 1";
         $res = $this->dbres->query($query);
         $last = (int) mysql_result($res, 0);
         return $last + 1;
     }
 
     public function addSpecies($sid, $commonname, $species, $gf, $gid, $american, $ky,
                     $fruittype, $edible, $flowrelleaf, $comments, $uid) {
 
         $query = "INSERT INTO Species (SSpeciesId, SCommonName,
                     SSpecies, SGrowthFactor, SGenusId, SNAmerica, SKy,
                     SFruitType, SEdibleFruit, SFlowerRelLeaves, SComments,
                     SRecCreatorId)
                   VALUES (
             '{$this->dbres->escapeString($sid)}',
             '{$this->dbres->escapeString($commonname)}',
             '{$this->dbres->escapeString($species)}',
             '{$this->dbres->escapeString($gf)}',
             '{$this->dbres->escapeString($gid)}',
             '{$this->dbres->escapeString($american)}',
             '{$this->dbres->escapeString($ky)}',
             '{$this->dbres->escapeString($fruittype)}',
             '{$this->dbres->escapeString($edible)}',
             '{$this->dbres->escapeString($flowrelleaf)}',
             \"{$this->dbres->escapeString($comments)}\",
             '{$this->dbres->escapeString($uid)}',";
             $query = substr($query, 0, -1);
             $query .= ")";
             echo "<br>{$query}<br>";
             $this->dbres->query($query);
 //          echo $this->dbres->getLastError();
             return true;
     }
*/
}
?>
<?php
/*
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
 //      echo $query;
         $this->dbres->query($query);
     }
 
     public function getEditHistory($eid, $refid) {
         $query = "SELECT UUserName, UUserId,
                   EURefRecRemoved, EURefRecUpdatedDate
                   FROM EntityUpdate INNER JOIN User ON (EURefRecUpdatorId = UUserId)
                   WHERE EUEntityTypeId = {$this->dbres->escapeString($eid)} 
                   AND EURefRecId = {$this->dbres->escapeString($refid)}";
 //      echo $query;
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
*/
?>
