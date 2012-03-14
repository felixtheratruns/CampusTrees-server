<?php
//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");

class ZonePointTable { 
	private $dbres;		//Database resource



        //Contructor
        public function ZonePointTable() {
            $this->dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);

        }

        public function GetZones() {
            /*Precondition: Database connected and populated
             *Postcondition: Returns JSON optimized array of zone info.
            */
            $res = $this->QueryGetZones();
            $cur_zone = mysql_result($res, 0, 0);
            $pointList[0][0] = array('lat' => (float)mysql_result($res, 0, 2), 'long' => (float)mysql_result($res, 0, 3));
            $i = 0;
            $j = 0;
            while ($row = mysql_fetch_assoc($res)) {
                if ($row['ZPZoneId'] == $cur_zone) {
                    $j++;
                }
                else {
                    $cur_zone = $row['ZPZoneId'];
                    $i++;
                    $j = 0;
                }
                $zoneIds[$i] = $row['ZPZoneId'];
                $pointList[$i][$j] = array('lat' => (float)$row['ZPLat'], 'long' => (float)$row['ZPLong']);
            }
            $k = 0;
            foreach($zoneIds as $zoneId) {
                $zoneList[$k] = array('id' => (int)$zoneId, "points" => $pointList[$k]);
                $k++;
            }
 
            return $zoneList;
        }

        private function QueryGetZones() {
            /*Precondition: Database connected and populated
             *Postcondition: Returns mysql_dataset of zone info*/
            $res = $this->dbres->query("SELECT ZPZoneId,
                ZPPointId, ZPLat, ZPLong
                FROM ZonePoint
                ORDER BY ZPZoneId, ZPPointId;");
            return $res;
        }
}
?>
