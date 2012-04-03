<?php
//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");

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
        protected $count;      //SEdibleFruit

//Admin Properties
	protected $recid;       //SRecId
	protected $gid;		//SGenusId
	protected $species;     //SSpecies
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
            }    
            $this->genCalFields();
        }

        public function getProperties() {
            $properties = get_object_vars($this);
            if (func_num_args() == 0) {//If not passed an arg, don't return admin properties
                unset($properties['recid']);
                unset($properties['gid']);
                unset($properties['species']);
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
                                  WHERE TSpeciesId = {$dbres->escapeString($this->sid)}");
            return mysql_result($res, 0);
        }

        public function setSid($sid) {
            $dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
            $res = mysql_fetch_assoc($dbres->query("SELECT SSpeciesId,
                SCommonName, SNAmerica,	SKy, SNonNative, SComments,
                SFlowerRelLeaves, SFruitType, SEdibleFruit, SRecId,
                SGenusId, SSpecies, SRecCreatedDate, SRecCreatorId
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
            return True;
        }     
}
?>
