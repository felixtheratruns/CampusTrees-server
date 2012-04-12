<?php
//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");
require_once(ROOT_DIR . "classes/EntityUpdateTable.inc.php");
require_once(ROOT_DIR . "classes/species.inc.php");
require_once(ROOT_DIR . "classes/genus.inc.php");

class Tree { 
//General Properties
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
/** Calculated Green Weight of Tree */
        protected $greenwt;     
/** Calculated Dry Weight of Tree */
        protected $drywt;     
/** Calculated Weight of Carbon in Tree */
        protected $carbonwt;     
/** Calculated Weight of CO2 Sequestered in Tree */
        protected $co2seqwt;     
/** Calculated Age of Tree */
        protected $age;     
/** Calculated CO2 Sequestered Per Year */
        protected $co2pyear;     
/** Calculated Area of Crown */
        protected $crownarea;     
/** bool indicator averaged growth factor used */
        protected $avged;     


//Admin properties
        protected $recid;        //TRecId
        protected $area;         //TAreaId
        protected $quad;         //TQuadId
        protected $dcrn;         //TDistCrn
        protected $dtree;        //TDistTree
        protected $crwnid;       //TCrwnId
        protected $crwnarea;     //TCrwnArea
        protected $removed;      //TRemoved
        protected $comments;     //TComments
        protected $createdate;   //TRecCreatedDate
        protected $creatorid;    //TRecCreatorId
        

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
            $properties = get_object_vars($this);
            if (func_num_args() == 0) {//If not passed an arg, don't return admin properties
                unset($properties['area']);
                unset($properties['quad']);
                unset($properties['dcrn']);
                unset($properties['dtree']);
                unset($properties['crwnid']);
                unset($properties['crwnarea']);
                unset($properties['removed']);
                unset($properties['comments']);
                unset($properties['createdate']);
                unset($properties['creatorid']);
                unset($properties['recid']);
            }
            return $properties;
        }
        public function ToJSON() {
            $properties = $this->getProperties();
            return json_encode($properties);
        }
        public function setId($id) {
            $dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
            $res = mysql_fetch_assoc($dbres->query("SELECT TTreeId,
                TSpeciesId, TLat, TLong, TDBH, 
                THeight, TCrwnWidth1, TCrwnWidth2,
                TAreaId, TQuadId, TDistCrn, TDistTree,
                TCrwnId, TCrwnArea, TRemoved, TComments,
                TRecCreatedDate, TRecCreatorId, TRecId
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
            $this->area = (int)$res['TAreaId'];
            $this->quad = (int)$res['TQuadId'];
            $this->dcrn = (float)$res['TDistCrn'];
            $this->dtree = (float)$res['TDistTree'];
            $this->crwnid = (int)$res['TCrwnId'];
            $this->crwnarea = (float)$res['TCrwnArea'];
            $this->removed = (bool)$res['TRemoved'];
            $this->comments = $res['TComments'];
            $this->createdate = $res['TRecCreatedDate'];
            $this->creatorid = (int)$res['TRecCreatorId'];
            $this->recid = (int)$res['TRecId'];
            return True;
        }     

        public function update($f) {
            $dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
            $euTable = new EntityUpdateTable();
            $any = false;
            $query = "UPDATE Tree SET ";
            $remov = 0;

            if (isset($f['lat'])) {
                $query .= "TLat = '{$dbres->escapeString($f['lat'])}', ";
                $any = True;
            }

            if (isset($f['long'])) {
                $query .= "TLong = '{$dbres->escapeString($f['long'])}', ";
                $any = True;
            }

            if (isset($f['sid'])) {
                $query .= "TSpeciesId = '{$dbres->escapeString($f['sid'])}', ";
                $any = True;
            }

            if (isset($f['height'])) {
                $query .= "THeight = '{$dbres->escapeString($f['height'])}', ";
                $any = True;
            }

            if (isset($f['removed'])) {
                $query .= "TRemoved = '{$dbres->escapeString($f['removed'])}', ";
                if ($f['removed']) {$remov = 1;}
                $any = True;
            }

            if (isset($f['comments'])) {
                $query .= "TComments = \"{$dbres->escapeString($f['comments'])}\", ";
                $any = True;
            }

            if (isset($f['dbh'])) {
                $query .= "TDBH = '{$dbres->escapeString($f['dbh'])}', ";
                $any = True;
            }

            if (isset($f['cw1'])) {
                $query .= "TCrwnWidth1 = '{$dbres->escapeString($f['cw1'])}', ";
                $any = True;
            }

            if (isset($f['cw2'])) {
                $query .= "TCrwnWidth2 = '{$dbres->escapeString($f['cw2'])}', ";
                $any = True;
            }

            if (isset($f['area'])) {
                $query .= "TAreaId = '{$dbres->escapeString($f['area'])}', ";
                $any = True;
            }

            if (isset($f['quad'])) {
                $query .= "TQuadId = '{$dbres->escapeString($f['quad'])}', ";
                $any = True;
            }

            if (isset($f['dcrn'])) {
                $query .= "TDistCrn = '{$dbres->escapeString($f['dcrn'])}', ";
                $any = True;
            }

            if (isset($f['dtree'])) {
                $query .= "TDistTree = '{$dbres->escapeString($f['dtree'])}', ";
                $any = True;
            }

            if (isset($f['crwnid'])) {
                $query .= "TCrwnId = '{$dbres->escapeString($f['crwnid'])}', ";
                $any = True;
            }

            if ($any) {
                $query = substr($query, 0, -2);
                $query .= " WHERE TTreeId = {$this->id}";
//              echo $query;
 //             echo "<br>";
                $dbres->query($query);
                $euTable->logUpdate(1, $this->id, $f['uid'], $remov);
            }
        }
        private function genCalFields() {
            $this->avged = false;
            $this->vol = $this->calVolume();
            $this->greenwt = $this->calGWeight();
            $this->drywt = $this->calDWeight();
            $this->carbonwt = $this->calCWeight();
            $this->co2seqwt = $this->calSWeight();
            $this->age = $this->calAge();
            $this->co2pyear = $this->calCO2PerYear();
            $this->crownarea = $this->calCrownArea();
            return true;
        }

        Private function calVolume() {/** @return Volume of Tree. */
            $radius = $this->dbh/24;
            $area = ($radius*$radius)*pi();
            $cubicfeet = ($area*$this->height)/4;
            return round($cubicfeet*12,3);
        }

        Private function calGWeight() {/** @return Green Weight of Tree. */
            if ($this->dbh < 11) {return 0.25*$this->dbh*$this->height*1.2;}
            else {return 0.15*$this->dbh*$this->height*1.2;}
        }

        Private function calDWeight() {/** @return Dry Weight of Tree. */
            if (!isset($this->greenwt)) {
                $this->greenwt = $this->calGWeight();
            }
            return $this->greenwt*.725;
        }

        Private function calCWeight() {/** @return Weight of Carbon in Tree. */
            if (!isset($this->drywt)) {
                $this->drywt = $this->calDWeight();
            }
            return $this->drywt*.5;
        }

        Private function calSWeight() {/** @return Weight of CO2 Sequestered in Tree. */
            if (!isset($this->carbonwt)) {
                $this->carbonwt = $this->calCWeight();
            }
            return $this->carbonwt*3.6663;
        }

        Private function calAge() {/** @return Tree Age. */
            $s = new Species($this->sid);
            $gf = $s->getgf();
            if ($gf == 0) {
                $g = new Genus($s->getgid());
                $gf = $g->getagf();
                $this->avged = true;
            }
            $age = $this->dbh * $gf;
            return $age;
        }

        Private function calCO2PerYear() {/** @return CO2 Seqeustered per year. */
            if (!isset($this->age)) {
                $this->age = $this->calAge();
            }
            if ($this->age > 0) {return $this->co2seqwt/$this->age;}
            else {return 0;}
        }

        Private function calCrownArea() {/** @return Area of Crown. *///TODO:cal Area of Crown once get info on Crown Ids
            return 0;//Something to do the a crown id coeff and the 2 crown widths
        }

}
?>
