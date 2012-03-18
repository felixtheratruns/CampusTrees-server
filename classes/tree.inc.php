<?php
//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");

class Tree { 
        //Lookup properties
	protected $id;		//Tree ID
	protected $sid;		//Species ID
	protected $lat;		//GPS Latitude
	protected $long;	//GPS Longitude
	protected $dbh;
	protected $height;
	protected $cw1;		//Crown width 1
	protected $cw2;		//Crown width 2

        //Generated properties
        protected $vol;         //Tree volumne in BoardFeet

        //Contructor
        public function Tree() {//$tid, $tsid, $tlat, $tlong,
                 //            $tdbh, $theight, $tcw1, $tcw2) {
            if (func_num_args() == 1) {
                $this->setId(func_get_arg(0));
            }
            else {
                $this->id = func_get_arg(0);
                $this->sid = func_get_arg(1);
                $this->lat = func_get_arg(2);
                $this->long = func_get_arg(3);
                $this->dbh = func_get_arg(4);
                $this->height = func_get_arg(5);
                $this->cw1 = func_get_arg(6);
                $this->cw2 = func_get_arg(7);
            }    
            $this->genCalFields();
        }
        public function getProperties() {
            return get_object_vars($this);
        }
        public function ToJSON() {
            return json_encode(get_object_vars($this));
        }
        public function setId($id) {
            $dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
            $res = mysql_fetch_assoc($dbres->query("SELECT TTreeId,
                TSpeciesId, TLat, TLong, TDBH, 
                THeight, TCrwnWidth1, TCrwnWidth2
                FROM Tree where TTreeId = " . $dbres->escapeString($id) . ""));
            //Now set all of the other attributes
            $this->id = (int)$res['TTreeId'];
            $this->sid = (int)$res['TSpeciesId'];
            $this->lat = (double)$res['TLat'];
            $this->long = (double)$res['TLong'];
            $this->dbh = (double)$res['TDBH'];
            $this->height = (double)$res['THeight'];
            $this->cw1 = (double)$res['TCrwnWidth1'];
            $this->cw2 = (double)$res['TCrwnWidth2'];
            return True;
        }     

        private function genCalFields() {
            $this->vol = $this->calVolume();
            return true;
        }

        Private function calVolume() {//Returns volume in BoardFeet!
            $radius = $this->dbh/24;
            $area = ($radius*$radius)*pi();
            $cubicfeet = ($area*$this->height)/4;
            return round($cubicfeet*12,3);
        }
}
?>
