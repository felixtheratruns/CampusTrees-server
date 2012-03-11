<?php
//Import configuration
require_once('/var/www/uofltrees-web/config.inc.php');
//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");

class ARHandler {
	private $dbres;		//Database resource
        private $phoneCon;       //Information for communicating with client

        protected $zoneList;    //List of Zones in DB
        protected $selectedTrees;
        

        //Contructor
        public function ARHandler(/*Will require info for response to Phone*/) {
            $this->dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
            try { //Try-Catch doesn't work probably because not using error handler
                $res = $this->dbres->query("SELECT ZZoneId,
                    ZPointALat, ZPointALong,
                    ZPointBLat, ZPointBLong,
                    ZPointCLat, ZPointCLong,
                    ZPointDLat, ZPointDLong
                    FROM Zone;");
            }
            catch (Exception $e) {
                echo $this->dbres->getLastError();
            }
            $i = 0;
            while ($row = mysql_fetch_assoc($res)) {
                $this->zoneList[$i][0] = intval($row['ZZoneId']);
                $this->zoneList[$i][1] = $row['ZPointALat'];
                $this->zoneList[$i][2] = $row['ZPointALong'];
                $this->zoneList[$i][3] = $row['ZPointBLat'];
                $this->zoneList[$i][4] = $row['ZPointBLong'];
                $this->zoneList[$i][5] = $row['ZPointCLat'];
                $this->zoneList[$i][6] = $row['ZPointCLong'];
                $this->zoneList[$i][7] = $row['ZPointDLat'];
                $this->zoneList[$i][8] = $row['ZPointDLong'];
                $i++;
            }
            //SendZoneListJSON();
            return True;
        }
        public function PrintZoneList() {
            foreach ($this->zoneList as $row) {
                echo "<br>";
                foreach($row as $col) {
                    echo "{$col}, ";
                }
            }
        }

        public function SelectZone($zId) {
            try {
                $res = $this->dbres->query("SELECT TTreeId, TLat, TLong
                    FROM  Tree INNER JOIN 
                          (
                            ZoneAreaMapping INNER JOIN Area 
                            ON (AAreaId = ZAPAreaId) 
                          ) ON (TAreaId = AAreaId)
                    WHERE ZAPZoneId = {$zId}");
            }
            catch (Exception $e) {
            }
                echo $this->dbres->getLastError();
            echo "<br><br>";
            $i = 0;
            while ($row = mysql_fetch_assoc($res)) {
                $this->selectedTrees[$i][0] = $row['TTreeId'];
                $this->selectedTrees[$i][1] = $row['TLat'];
                $this->selectedTrees[$i][2] = $row['TLong'];
                $i++;
            }
        }


        public function PrintSelectedTrees() {
            echo "<br><br>";
            $i = 1;
            foreach ($this->selectedTrees as $row) {
                echo "{$i}) ";
                foreach ($row as $col) {
                    echo "{$col}  ";
                }
                echo "<br>";
                $i++;
            }
        }
//        private function SendZoneListJSON()
            
}
?>
