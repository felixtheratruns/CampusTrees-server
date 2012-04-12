<?php
//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");

class WildlifeFact {
    protected $title;
    protected $body;

    public function WildlifeFact($wtitle, $wbody) {
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

    public function getFacts() {
        $query = "SELECT * FROM WildlifeFacts
                  WHERE WFRemoved = 0";
        $res = $this->dbres->query($query);
        $i = 0;
        $news = array();
        while($row = mysql_fetch_assoc($res)) {
            $nRec = new WildlifeFact($row['WFTitle'], $row['WFBody']);
            $news[$i] = $nRec->getProperties();
            $i++;
        }
        return $news;
    }

    public function JSON_getFacts() {
        return json_encode($this->getFacts());
    }
}

