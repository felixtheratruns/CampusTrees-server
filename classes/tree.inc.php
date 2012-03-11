<?php
//Import configuration
require_once('/var/www/uofltrees-web/config.inc.php');
//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");

class Tree { 
	private $dbres;		//Database resource

	protected $recid;
	protected $id;		//Tree ID
	protected $sid;		//Species ID
	protected $long;	//GPS Longitude
	protected $lat;		//GPS Latitude
	protected $aid;		//Area id
	protected $qid;		//Quadrant ID
	protected $dbh;
	protected $dcrn;
	protected $dtree;
	protected $height;
	protected $cid;		//Crown ID
	protected $cw1;		//Crown width 1
	protected $cw2;		//Crown width 2
	protected $ca;		//Crown area
	protected $rem;		//Tree removed?
	protected $com;		//Comments


        //Contructor
        public function Tree($id) {
        $this->dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
        $this->setId($Id);

        }
        public function setId($id) {
        $res = mysql_fetch_assoc($this->dbres->query("SELECT TRecId, TTreeId,
            TSpeciesId, TLat, TLong, TAreaId, TQuadId, TDBH, TDistCrn, TDistTree,
            THeight,TCrwnId, TCrwnWidth1, TCrwnWidth2, TCrwnArea, TRemoved,
            TComments, TRecCreatedDate, TRecCreatorId
            FROM Tree where TTreeId = " . \
            strval($id) . ";"));
        //Now set all of the other attributes
        echo "<br>";
        echo $res['TTreeId'];
        echo "<br>";
        echo "<br>";
        echo $this->dbres->getLastError();
        return True;
        }     
}
?>
