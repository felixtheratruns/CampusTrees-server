<?php
//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");

class ZonePointRecord {
    protected $zpid;
    protected $points;

    public function ZonePointRecord($id, $pointarr) {
        $this->zpid = $id;
        $this->points = $pointarr;
    }

    public function getProperties() {
        $properties = get_object_vars($this);
        return $properties;
    }
}


class ZonePointTable { 
	private $dbres;		//Database resource



        //Contructor
        public function ZonePointTable() {
            $this->dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);

        }

        public function GetZone($zpid) {
            $res = $this->QueryGetZone($zpid);
            
            $i = 0;
            while ($row = mysql_fetch_assoc($res)) {
                $pointList[$i] = array('lat' => (string)number_format($row['ZPLat'], 15), 'long' => (string)number_format($row['ZPLong'], 15), 'pid' => (int)$row['ZPPointId']);
                $i++;
            }
            if (!isset($pointList)) return False;
            $zp = new ZonePointRecord($zpid, $pointList);
            return $zp->getProperties();
        }

        public function GetZones() {
            /*Precondition: Database connected and populated
             *Postcondition: Returns JSON optimized array of zone info.
            */
            $res = $this->QueryGetZones();
            $cur_zone = mysql_result($res, 0, 0);
            $pointList[0][0] = array('lat' => (string)number_format(mysql_result($res, 0, 2), 15), 'long' => (string)number_format(mysql_result($res, 0, 3), 15), 'pid' => (double)mysql_result($res, 0, 1));
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
                $pointList[$i][$j] = array('lat' => (string)number_format($row['ZPLat'], 15), 'long' => (string)number_format($row['ZPLong'], 15), 'pid' => (int)$row['ZPPointId']);
            }
            $k = 0;
            foreach($zoneIds as $zoneId) {
                $zp = new ZonePointRecord((int)$zoneId, $pointList[$k]);
                $zoneList[$k] = $zp->getProperties();
                $k++;
            }
 
            return $zoneList;
        }

        public function UpdateZone($zpid, $updateList) {
            if (count($updateList) == 0) return False;
            $query = "SELECT ZPZoneId FROM ZonePoint WHERE ZPZoneId = '{$this->dbres->escapestring($zpid)}'";
            if (mysql_num_rows($this->dbres->query($query)) == 0) return False;
            foreach ($updateList as $row) {
                $this->UpdateZonePointQuery($zpid, $row['pid'], $row['type'], $row['coord']);
            }
            return True;
        }

        public function NewZonePoint($zpid, $pid, $lat, $long) {
            $z = $this->dbres->escapestring($zpid);
            $p = $this->dbres->escapestring($pid);
            $a = $this->dbres->escapestring($lat);
            $o = $this->dbres->escapestring($long);

            $query = "INSERT INTO ZonePoint (ZPZoneId, ZPPointId, ZPLat, ZPLong)
                        VALUES ({$z}, {$p}, {$a}, {$o})";
            echo $query;
            if ($this->dbres->query($query)) return True;
            else return false;
        }

        private function UpdateZonePointQuery($zpid, $pid, $type, $coord) {
            $t = $this->dbres->escapestring($type);
            $c = $this->dbres->escapestring($coord);
            $z = $this->dbres->escapestring($zpid);
            $p = $this->dbres->escapestring($pid);
            $query = "UPDATE ZonePoint
                        SET {$t} = 
                        '{$c}'
                        WHERE ZPZoneId = {$z}
                        AND ZPPointId = {$p}";
            echo $query;
            $res = $this->dbres->query($query);
            return $res;
        }

        private function QueryGetZone($zpid) {
            /*Precondition: Database connected and populated
             *Postcondition: Returns mysql_dataset of zone info*/
            $query = "SELECT ZPZoneId,
                ZPPointId, ZPLat, ZPLong
                FROM ZonePoint
                WHERE ZPZoneId = '{$this->dbres->escapestring($zpid)}'
                ORDER BY ZPZoneId, ZPPointId;";
            $res = $this->dbres->query($query);
            return $res;
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
