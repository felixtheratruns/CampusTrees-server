<?php
//Import configuration
require_once('/var/www/uofltrees-web/config.inc.php');
//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");

class TreeTable { 
	private $dbres;		//Database resource



        //Contructor
        public function TreeTable() {
        $this->dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);

        }

        public function ByZone($zone) {
            return $this->dbres->query("SELECT TTreeId, TLat, TLong
                    FROM  Tree INNER JOIN 
                          (
                            ZoneAreaMapping INNER JOIN Area 
                            ON (AAreaId = ZAPAreaId) 
                          ) ON (TAreaId = AAreaId)
                    WHERE ZAPZoneId = {$zone}");
        }
}
?>
