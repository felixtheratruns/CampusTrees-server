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
            return True;
        }
        public function getZoneList() {
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
                $this->zoneList[$i] = array('id' => $row['ZZoneId'], 
                  "{$row['ZZoneId']}" => array(
                    'A' => array('lat' => $row['ZPointALat'], 'long' => $row['ZPointALong']), 
                    'B' => array('lat' => $row['ZPointBLat'], 'long' => $row['ZPointBLong']), 
                    'C' => array('lat' => $row['ZPointCLat'], 'long' => $row['ZPointCLong']), 
                    'D' => array('lat' => $row['ZPointDLat'], 'long' => $row['ZPointDLong']) 
                  )
                );
                $i++;
            }
}
        public function ZoneList_ToString() {
            $this->getZoneList();
            $res = "<br>";
            foreach ($this->zoneList as $row) {
                $i = $row['id'];
                $res .= "Zone: {$i}<br>";
                $res .= "&nbsp;&nbsp;Point A ({$row[$i]['A']['lat']}, {$row[$i]['A']['long']})<br>";
                $res .= "&nbsp;&nbsp;Point B ({$row[$i]['B']['lat']}, {$row[$i]['B']['long']})<br>";
                $res .= "&nbsp;&nbsp;Point C ({$row[$i]['C']['lat']}, {$row[$i]['C']['long']})<br>";
                $res .= "&nbsp;&nbsp;Point D ({$row[$i]['D']['lat']}, {$row[$i]['D']['long']})<br>";
            }
            return $res;
        }

        public function JSON_RequestZoneList() {
            $this->getZoneList();
            return json_encode($this->zoneList);
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
                $this->selectedTrees[$i] = array(
                  'id' => $row['TTreeId'],
                  'lat' => $row['TLat'],
                  'long' => $row['TLong']
                );
            $i++;
            }
        }

        public function JSON_RequestTreesByZone($zone) {
            $this->SelectZone($zone);
            echo json_encode($this->selectedTrees);
        }

        public function SelectedTrees_ToString() {
            $res = "<br><br>";
            $i = 1;
            foreach ($this->selectedTrees as $row) {
                $res .= "{$i}) ";
                foreach ($row as $col) {
                    $res .= "{$col}  ";
                }
                $res .= "<br>";
                $i++;
            }
        return $res;
        }
            
}
?>
