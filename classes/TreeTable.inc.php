<?php
//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");

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
                $selectedTrees[$i] = array(
                  'id' => (int)$row['TTreeId'],
                  'lat' => (float)$row['TLat'],
                  'long' => (float)$row['TLong'],
                  'sid' => (float)$row['TSpeciesId'],
                  'dbh' => (float)$row['TDBH'],
                  'height' => (float)$row['THeight']
                );
            $i++;
            }
            return $selectedTrees;
        }

        private function QueryByZone($zone) {
            /*Precondition: $zone is a valid zone Id integer, Database connected and populated
             *Postcondition: Returns mysql_dataset of Tree info of trees in the zone specified*/
            return $this->dbres->query("SELECT TTreeId, TLat, TLong, TSpeciesId,
                          TDBH, THeight 
                    FROM  Tree INNER JOIN 
                          (
                            ZoneAreaMapping INNER JOIN Area 
                            ON (AAreaId = ZAPAreaId) 
                          ) ON (TAreaId = AAreaId)
                    WHERE ZAPZoneId = " . $this->dbres->escapeString($zone) . " AND TRemoved = 0");
         
        }
}
?>
