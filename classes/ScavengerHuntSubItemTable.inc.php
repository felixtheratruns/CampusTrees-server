<?php
//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");


class ScavengerHuntSubItemRecord {
     protected $sid;
     protected $uname;
     protected $uid;
     protected $rem;
     protected $date;
     protected $title;
     protected $body;
     protected $belong_id; 
     protected $png_name;

     public function ScavengerHuntSubItemRecord($ssid, $username, $userid, $removed, $updatedate, $stitle, $sbody, $sbelong_id, $spng_name) {
        $this->sid = $ssid;
        $this->uname = $username;
        $this->uid = $userid;
        $this->rem = $removed;
        $this->date = $updatedate;
        $this->title = $stitle;
        $this->body = $sbody;
        $this->belong_id = $sbelong_id;
        $this->png_name = $spng_name;
     }
 
     public function getProperties() {
         $properties = get_object_vars($this);
         return $properties;
    }
}

class ScavengerHuntSubItemTable { 
    private $dbres;  //Database resource
 
    //Contructor
    public function ScavengerHuntSubItemTable() {
        $this->dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
    }
 
    public function GetScavengerHuntSubItem($admin=false) {
        /*Precondition: Database connected and populated
         *Postcondition: Returns JSON optimized array of species info.
           */

/*
        echo "test admin: $admin";
        if($admin){
            $res = $this->QueryGetScavengerHuntSubItem();
        } else {
            
            $res = $this->QueryGetScavengerHuntSubItemSpec($scavId);
            echo "\n second if";
        } 
*/        
        $res = $this->QueryGetScavengerHuntSubItem();
        return $this->buildList($admin, $res);
    }

 
    public function GetScavengerHuntSubItemSpec($scavId) {
        /*Precondition: Database connected and populated
         *Postcondition: Returns JSON optimized array of species info.
           */

        $res = $this->QueryGetScavengerHuntSubItemSpec($scavId);
        $admin = false; //watch out!! hard coded value
        return $this->buildList($admin, $res);
    }


    public function JSON_getSubItemsByScavengerHunt($scavId){
//        echo $this->dbres->getLastError();
        return JSON_encode($this->GetScavengerHuntSubItemSpec($scavId));

    }
 
    public function JSON_getScavengerHuntSubItem($admin=false) {
        /*Precondition: Database connected and populated
         *Postcondition: Returns JSON optimized array of species info.
     //   */
//        echo "JSON_getScavengerHuntSubItem:" . $scavId;
//        echo $this->dbres->getLastError();
        return JSON_encode($this->GetScavengerHuntSubItem($admin));
    }
 
    private function buildList($admin, $sqlres) {
        $i = 0;
        if ($admin) {}//Write meeeee
        else {
            while ($row = mysql_fetch_assoc($sqlres)) {
                $r = new ScavengerHuntSubItemRecord ((int)$row['SRecId'], $row['UUserName'],
                  (int)$row['SRecCreatorId'], (bool)$row['SRemoved'],
                  $row['SRecCreatedDate'], $row['STitle'],
                  $row['SBody'],(int)$row['SScavId'],$row['SPngPath']);
                $selectedScavengerHuntSubItemRecs[$i] = $r->getProperties();
                $i++;
            }
        }
       if($selectedScavengerHuntSubItemRecs){
        
       }else {
        return NULL;
        }

       return $selectedScavengerHuntSubItemRecs;
    }
 
    public function addScavengerHuntSubItem($uid, $title, $body, $belong_id, $png_name) {
         
        $query = "INSERT INTO ScavengerHuntSubItem (SRecCreatorId, STitle,
                    SBody, SScavId, SPngPath, SRemoved)
                  VALUES (
            '{$this->dbres->escapeString($uid)}',
            \"{$this->dbres->escapeString($title)}\",
            \"{$this->dbres->escapeString($body)}\",
            \"{$this->dbres->escapeString($belong_id)}\", 
            \"{$this->dbres->escapeString($png_name)}\",
            0,";
            $query = substr($query, 0, -1);
            $query .= ")";
            //echo "<br>{$query}<br>";
            $this->dbres->query($query);
            //echo $this->dbres->getLastError();
            return true;
    }
 
    public function removeScavengerHuntSubItem($sid) {
        $query = "UPDATE ScavengerHuntSubItem SET SRemoved = '1' WHERE SRecId = {$this->dbres->escapeString($sid)}";
        echo $query;
        $this->dbres->query($query);
    }
 
    private function QueryGetScavengerHuntSubItemSpec($scavId) {
        /*Precondition: Database connected and populated
         *Postcondition: Returns mysql_dataset of species info*/
        $query = $this->dbres->query("SELECT UUserName, UUserId,
                      SRecId, STitle,
                      SBody, SScavId, SPngPath, SRecCreatedDate, SRecCreatorId, SRemoved
                  FROM ScavengerHuntSubItem INNER JOIN User ON (SRecCreatorId = UUserId)
                  WHERE SRemoved = 0
                  AND SScavId = " . $scavId . " 
                  ORDER BY SRecCreatedDate DESC
                ");
        if($query == NULL){
            echo "query returned NULL";
        }
        return $query;
          
    }
 
    private function QueryGetScavengerHuntSubItem() {
        /*Precondition: Database connected and populated
         *Postcondition: Returns mysql_dataset of species info*/
        $query = $this->dbres->query("SELECT UUserName, UUserId,
                      SRecId, STitle,
                      SBody, SScavId, SPngPath, SRecCreatedDate, SRecCreatorId, SRemoved
                  FROM ScavengerHuntSubItem INNER JOIN User ON (SRecCreatorId = UUserId)
                  WHERE SRemoved = 0
                  ORDER BY SRecCreatedDate DESC
                ");
        if($query == NULL){
            echo "query returned NULL";
        }
        return $query;
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
