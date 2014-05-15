/** This file is part of server-side of the CampusTrees Project. It is subject to the license terms in the LICENSE file found in the top-level directory of this distribution. No part of CampusTrees Project, including this file, may be copied, modified, propagated, or distributed except according to the terms contained in the LICENSE file.*/
<?php
//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");
require_once(ROOT_DIR . "classes/EntityUpdateTable.inc.php");
require_once(ROOT_DIR . "classes/CacheMan.inc.php");

class Species {
	
	protected $sid;		//SSpeciesId
	protected $commonname;	//SCommonName
	protected $american;	//SNAmerica - Bool if species is from N.America
	protected $ky;		//SKy - Bool if species is from KY
	protected $nonnative;	//SNonNative - Bool if species is native
	protected $comments;    //SComments
        protected $flowrelleaf; //SFlowerRelLeaves
        protected $fruittype;   //SFruitType
        protected $edible;      //SEdibleFruit
        protected $gf;      //sGrowthFactor
	protected $gid;		//SGenusId
	protected $species;     //SSpecies

//Calculated Fields
        protected $count;      //Count of trees of this species

//Admin Properties
	protected $recid;       //SRecId
        protected $createdate; //SRecCreatedDate
        protected $creatorid;   //SRecCreatorId

        public function Species() {

            if (func_num_args() == 1) {
                $this->setSid(func_get_arg(0));
            }
            else {
                $this->sid = func_get_arg(0);
                $this->commonname = func_get_arg(1);
                $this->american = func_get_arg(2);
                $this->ky = func_get_arg(3);
                $this->nonnative = func_get_arg(4);
                $this->comments = func_get_arg(5);
                $this->flowrelleaf = func_get_arg(6);
                $this->fruittype = func_get_arg(7);
                $this->edible = func_get_arg(8);
                $this->gf = func_get_arg(9);
                $this->gid = func_get_arg(10);
                $this->species = func_get_arg(11);
            }    
            $this->genCalFields();
        }

        public function getProperties() {
            $properties = get_object_vars($this);
            if (func_num_args() == 0) {//If not passed an arg, don't return admin properties
                unset($properties['recid']);
                unset($properties['createdate']);
                unset($properties['creatorid']);
            }
            return $properties;
        }
        public function ToJSON() {
            $properties = $this->getProperties();
            return json_encode($properties);
        }

        public function genCalFields() { //need to cal tree count
            $this->count = $this->calCount();
        }

        public function calCount() {
            $dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
            $res = $dbres->query("SELECT COUNT(*) FROM Tree
                                  WHERE TSpeciesId = {$dbres->escapeString($this->sid)}
                                  AND TRemoved = 0");
            return mysql_result($res, 0);
        }

        public function setSid($sid) {
            $dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
            $res = mysql_fetch_assoc($dbres->query("SELECT SSpeciesId,
                SCommonName, SNAmerica,	SKy, SNonNative, SComments,
                SFlowerRelLeaves, SFruitType, SEdibleFruit, SRecId,
                SGenusId, SSpecies, SRecCreatedDate, SRecCreatorId, SGrowthFactor
                FROM Species where SSpeciesId = " . $dbres->escapeString($sid) . ""));
            //Now set all of the other attributes
            $this->sid = (int)$res['SSpeciesId'];
            $this->commonname = $res['SCommonName'];
            $this->american = (bool)$res['SNAmerica'];
            $this->ky = (bool)$res['SKy'];
            $this->nonnative = (bool)$res['SNonNative'];
            $this->comments = $res['SComments'];
            $this->flowrelleaf = (int)$res['SFlowerRelLeaves'];
            $this->fruittype = $res['SFruitType'];
            $this->edible = (bool)$res['SEdibleFruit'];
            $this->recid = (int)$res['SRecId'];
            $this->gid = (int)$res['SGenusId'];
            $this->species = $res['SSpecies'];
            $this->createdate = $res['SRecCreatedDate'];
            $this->creatorid = (int)$res['SRecCreatorId'];
            $this->gf = (float)$res['SGrowthFactor'];
            return True;
        }     

        public function update($f) {
            $dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
            $cache = new CacheManager();
            $euTable = new EntityUpdateTable();
            $any = false;
            $query = "UPDATE Species SET ";
            $remov = 0; //Need to implement removal for species

            if (isset($f['american'])) {
                $query .= "SNAmerica = '{$dbres->escapeString($f['american'])}', ";
                $any = True;
            }

            if (isset($f['ky'])) {
                $query .= "SKy = '{$dbres->escapeString($f['ky'])}', ";
                $any = True;
            }

            if (isset($f['edible'])) {
                $query .= "SEdibleFruit = '{$dbres->escapeString($f['edible'])}', ";//Won't work when 0 because of escape
                $any = True;
            }

            if (isset($f['commonname'])) {
                $query .= "SCommonName = '{$dbres->escapeString($f['commonname'])}', ";
                $any = True;
            }

            if (isset($f['species'])) {
                $query .= "SSpecies = '{$dbres->escapeString($f['species'])}', ";
                $any = True;
            }

            if (isset($f['gf'])) {
                $query .= "SGrowthFactor = '{$dbres->escapeString($f['gf'])}', ";
                $any = True;
            }

            if (isset($f['gid'])) {
                $query .= "SGenusId = '{$dbres->escapeString($f['gid'])}', ";
                $any = True;
            }

            if (isset($f['fruittype'])) {
                $query .= "SFruitType= '{$dbres->escapeString($f['fruittype'])}', ";
                $any = True;
            }

            if (isset($f['flowrelleaf'])) {
                $query .= "SFlowerRelLeaves = '{$dbres->escapeString($f['flowrelleaf'])}', ";
                $any = True;
            }

            if (isset($f['comments'])) {
                $query .= "SComments= \"{$dbres->escapeString($f['comments'])}\", ";
                $any = True;
            }


            if ($any) {
                $query = substr($query, 0, -2);
                $query .= " WHERE SSpeciesId = {$this->sid}";
//              echo $query;
//              echo "<br>";
                $dbres->query($query);
                $euTable->logUpdate(2, $this->recid, $f['uid'], $remov);
                $cache->clear(1);
            }
        }

        public function getgid() {
            return $this->gid;
        }

        public function getgf() {
            return $this->gf;
        }

        private function repNull($maybeNull) {
            if (!isset($maybeNull)) {return 0;}
            return $maybeNull;
        }


}
?>
