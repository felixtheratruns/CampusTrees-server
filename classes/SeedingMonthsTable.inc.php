<!-- This file is part of server-side of the CampusTrees Project. It is subject to the license terms in the LICENSE file found in the top-level directory of this distribution. No part of CampusTrees Project, including this file, may be copied, modified, propagated, or distributed except according to the terms contained in the LICENSE file.-->
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
            $smRec = new SeedingMonthsRecord((int)$row['SMSpeciesId'], (int)$row['SMMonthId']);
            $recs[$i] = $smRec->getProperties();
            $i++;
        }
        if (isset($recs)) {return $recs;}
        else {return array(array('sid' => 0, 'mid' => $month));}
    }

    public function JSON_speciesByMonth($month) {
        $res = $this->speciesByMonth($month);
        return json_encode($res);
    }

    public function monthsBySpecies($species) {
        $res = $this->QueryBySpecies($species);
        $i = 0;
        while ($row = mysql_fetch_assoc($res)) {
            $smRec = new SeedingMonthsRecord((int)$row['SMSpeciesId'], (int)$row['SMMonthId']);
            $recs[$i] = $smRec->getProperties();
            $i++;
        }
        if (isset($recs)) {return $recs;}
        else {return array(array('sid' => 0, 'mid' => $species));}

    }

    public function JSON_monthsBySpecies($species) {
        $res = $this->monthsBySpecies($species);
        return json_encode($res);
    }

    private function QueryByMonth($month) {
        return $this->dbres->query("SELECT SMSpeciesId, SMMonthId FROM SeedingMonths
                                    WHERE SMMonthId = {$this->dbres->escapeString($month)}");

    }
  
    private function QueryBySpecies($species) {
        return $this->dbres->query("SELECT SMSpeciesId, SMMonthId FROM SeedingMonths
                                    WHERE SMSpeciesId = {$this->dbres->escapeString($species)}
                                    ORDER BY SMMonthId");
    }

    public function addMonth($species, $month) {
        $this->dbres->query("INSERT INTO SeedingMonths (SMSpeciesId, SMMonthId)
                            VALUES ('{$this->dbres->escapeString($species)}',
                            '{$this->dbres->escapeString($month)}')");
    }

    public function removeMonth($species, $month) {
        $this->dbres->query("DELETE FROM SeedingMonths
                            WHERE SMSpeciesId = '{$this->dbres->escapeString($species)}'
                            AND SMMonthId = '{$this->dbres->escapeString($month)}'");
    }

}
?>
