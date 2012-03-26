<?php
//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");
require_once(ROOT_DIR . "classes/tree.inc.php");

class TreeTable { 
	private $dbres;		//Database resource



        //Contructor
        public function TreeTable() {
            $this->dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);

        }

        public function ByZone($zId) {
            /*Precondition: $zId is a valid zone Id integer, Database connected and populated
             *Postcondition: Returns JSON optimized array of Tree info of trees in the zone specified
            */
            $res = $this->QueryByZone($zId);
//          echo $this->dbres->getLastError();
            $i = 0;
            while ($row = mysql_fetch_assoc($res)) {
                $t = new tree((int)$row['TTreeId'], (float)$row['TSpeciesId'],
                              (float)$row['TLat'], (float)$row['TLong'],
                              (float)$row['TDBH'], (float)$row['THeight'],
                              (int)$row['TCrwnWidth1'], (int)$row['TCrwnWidth2']);
                $selectedTrees[$i] = $t->getProperties();
                $i++;
            }
            return $selectedTrees;
        }

        public function getTallest() {
            $res = mysql_fetch_assoc($this->QueryTallest());
            $tallestId = (int)$res['TTreeId'];
            $tallestTree = new tree($tallestId);
            return $tallestTree->getProperties();
        }

        public function getMCLife () { //Currently just returning filler data
            $t = new tree(765);
            return $t->getProperties();
        }

        public function getMCyear () {//Currently just returning filler data
            $t = new tree(894);
            return $t->getProperties();
        }

        private function QueryTallest() {
            return $this->dbres->query("SELECT TTreeId FROM Tree ORDER BY THeight DESC LIMIT 1");
        }
        private function QueryByZone($zone) {
            /*Precondition: $zone is a valid zone Id integer, Database connected and populated
             *Postcondition: Returns mysql_dataset of Tree info of trees in the zone specified*/
            return $this->dbres->query("SELECT TTreeId, TLat, TLong, TSpeciesId,
                          TDBH, THeight, TCrwnWidth1, TCrwnWidth2
                    FROM  Tree INNER JOIN ZoneAreaMapping ON (TAreaId = ZAPAreaId)
                    WHERE ZAPZoneId = " . $this->dbres->escapeString($zone) . " AND TRemoved = 0");
         
        }
}
?>
