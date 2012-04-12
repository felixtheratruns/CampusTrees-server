<?php
//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");

class NewsRecord {
    protected $title;
    protected $body;
    protected $date;

    public function NewsRecord($ntitle, $nbody, $ndate) {
        $this->title = $ntitle;
        $this->body = $nbody;
        $this->date = $ndate;
    }

    public function getProperties() {
        $properties = get_object_vars($this);
        return $properties;
    }

}

class NewsTable {

    private $dbres;

    public function NewsTable () {
        $this->dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
    }

    public function getNews() {
        $query = "SELECT * FROM News
                  WHERE NRemoved = 0
                  ORDER BY NRecCreatedDate DESC";
        $res = $this->dbres->query($query);
        $i = 0;
        $news = array();
        while($row = mysql_fetch_assoc($res)) {
            $nRec = new NewsRecord($row['NTitle'], $row['NBody'], $row['NRecCreatedDate']);
            $news[$i] = $nRec->getProperties();
            $i++;
        }
        return $news;
    }

    public function JSON_getNews() {
        return json_encode($this->getnews());
    }
}

