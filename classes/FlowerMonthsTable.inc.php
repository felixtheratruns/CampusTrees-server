<?php
//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");

class FlowerMonthsRecord {
    protected $sid;
    protected $mid;

    public function FlowerMonthsRecord($id, $month) {
        $this->sid = $id;
        $this->mid = $month;
    }

    public function getProperties() {
        $properties = get_object_vars($this);
        return $properties;
    }
        
}

class FlowerMonthsTable {
    private $dbres;		//Database resource

    public function FlowerMonthsTable() {
        $this->dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
    }

    public function speciesByMonth($month) {
        $res = $this->QueryByMonth($month);
        $i = 0;
        while ($row = mysql_fetch_assoc($res)) {
            $fmRec = new FlowerMonthsRecord($row['FMSpeciesId'], $row['FMMonthId']);
            $recs[$i] = $fmRec->getProperties();
            $i++;
        }
        if (isset($recs)) {return $recs;}
        else {return array('sid' => 0);}
    }

    public function monthsBySpecies($species) {
        $res = $this->QueryBySpecies($species);
        $i = 0;
        while ($row = mysql_fetch_assoc($res)) {
            $fmRec = new FlowerMonthsRecord($row['FMSpeciesId'], $row['FMMonthId']);
            $recs[$i] = $fmRec->getProperties();
            $i++;
        }
        if (isset($recs)) {return $recs;}
        else {return array('mid' => 0);}

    }

    private function QueryByMonth($month) {
        return $this->dbres->query("SELECT FMSpeciesId, FMMonthId FROM FlowerMonths
                                    WHERE FMMonthId = {$this->dbres->escapeString($month)}");

    }
  
    private function QueryBySpecies($species) {
        return $this->dbres->query("SELECT FMSpeciesId, FMMonthId FROM FlowerMonths
                                    WHERE FMSpeciesId = {$this->dbres->escapeString($species)}");
    }

}
?>
