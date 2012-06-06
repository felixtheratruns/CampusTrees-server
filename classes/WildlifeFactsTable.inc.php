<?php
//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");

class WildlifeFact {
    protected $wid;
    protected $uname;
    protected $uid;
    protected $rem;
    protected $date;
    protected $title;
    protected $body;

    public function WildlifeFact($wwid, $username, $userid, $removed, $updatedate, $wtitle, $wbody) {
        $this->wid = $wwid;
        $this->uname = $username;
        $this->uid = $userid;
        $this->rem = $removed;
        $this->date = $updatedate;
        $this->title = $wtitle;
        $this->body = $wbody;
    }

    public function getProperties() {
        $properties = get_object_vars($this);
        return $properties;
    }

}

class WildlifeFactsTable {

    private $dbres;

    public function WildlifeFactsTable () {
        $this->dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
    }

    public function getFacts($admin=false) {
        /*Precondition: Database connected and populated
         *Postcondition: Returns JSON optimized array of species info.
            */
        $res = $this->QuerygetFacts();
        echo $this->dbres->getLastError();
        return $this->buildList($admin, $res);
    }
 
    public function JSON_getFacts($admin=false) {
        /*Precondition: Database connected and populated
         *Postcondition: Returns JSON optimized array of species info.
        */
        return JSON_encode($this->getFacts($admin));
    }
 
    private function buildList($admin, $sqlres) {
        $i = 0;
        if ($admin) {}//Write meeeee
        else {
            while ($row = mysql_fetch_assoc($sqlres)) {
                $r = new WildlifeFact ((int)$row['WFRecId'], $row['UUserName'],
                  (int)$row['WFRecCreatorId'], (bool)$row['WFRemoved'],
                  $row['WFRecCreatedDate'], $row['WFTitle'],
                  $row['WFBody']);
                $selectedWildlifeFact[$i] = $r->getProperties();
                $i++;
            }
        }
        return $selectedWildlifeFact;
    }

    public function addFact($uid, $title, $body) {
         
        $query = "INSERT INTO WildlifeFacts (WFRecCreatorId, WFTitle,
                    WFBody, WFRemoved)
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

    public function removeFact($wid) {
        $query = "UPDATE WildlifeFacts SET WFRemoved = '1' WHERE WFRecId = {$this->dbres->escapeString($wid)}";
        echo $query;
        $this->dbres->query($query);
    }

    private function QuerygetFacts() {
        /*Precondition: Database connected and populated
         *Postcondition: Returns mysql_dataset of species info*/
        return $this->dbres->query("SELECT UUserName, UUserId,
                      WFRecId, WFTitle,
                      WFBody, WFRecCreatedDate, WFRecCreatorId, WFRemoved
                  FROM WildlifeFacts INNER JOIN User ON (WFRecCreatorId = UUserId)
                  WHERE WFRemoved = 0
                  ORDER BY WFRecCreatedDate DESC
                ");
          
    }
}

