<?php
//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");

class SeedingMonthsRecord {
    protected $sid;
    protected $mid;

    public function SeedingMonthsRecord($id, $month) {
        $this->sid = $id;
        $this->mid = $month;
    }

    public function getProperties() {
        $properties = get_object_vars($this);
        return $properties;
    }
        
}

class SeedingMonthsTable {
    private $dbres;		//Database resource

    public function SeedingMonthsTable() {
        $this->dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
    }

    public function speciesByMonth($month) {
        $res = $this->QueryByMonth($month);
        $i = 0;
        while ($row = mysql_fetch_assoc($res)) {
            $smRec = new SeedingMonthsRecord($row['SMSpeciesId'], $row['SMMonthId']);
            $recs[$i] = $smRec->getProperties();
            $i++;
        }
        if (isset($recs)) {return $recs;}
        else {return array('sid' => 0);}
    }

    public function monthsBySpecies($species) {
        $res = $this->QueryBySpecies($species);
        $i = 0;
        while ($row = mysql_fetch_assoc($res)) {
            $smRec = new SeedingMonthsRecord($row['SMSpeciesId'], $row['SMMonthId']);
            $recs[$i] = $smRec->getProperties();
            $i++;
        }
        if (isset($recs)) {return $recs;}
        else {return array('mid' => 0);}

    }

    private function QueryByMonth($month) {
        return $this->dbres->query("SELECT SMSpeciesId, SMMonthId FROM SeedingMonths
                                    WHERE SMMonthId = {$this->dbres->escapeString($month)}");

    }
  
    private function QueryBySpecies($species) {
        return $this->dbres->query("SELECT SMSpeciesId, SMMonthId FROM SeedingMonths
                                    WHERE SMSpeciesId = {$this->dbres->escapeString($species)}");
    }

}
?>
