<!-- This file is part of server-side of the CampusTrees Project. It is subject to the license terms in the LICENSE file found in the top-level directory of this distribution. No part of CampusTrees Project, including this file, may be copied, modified, propagated, or distributed except according to the terms contained in the LICENSE file.-->
<?php
//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");

class AdminTree { 
	protected $recid;
	protected $id;		//Tree ID
	protected $sid;		//Species ID
	protected $lat;		//GPS Latitude
	protected $long;	//GPS Longitude
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
        protected $createddate;
        protected $creatorid;


        //Contructor
        public function AdminTree($id) {
            $this->setId($id);

        }
        public function getProperties() {
            return get_object_vars($this);
        }
        public function ToJSON() {
            return json_encode(get_object_vars($this));
        }
        public function setId($id) {
            $dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
            $res = mysql_fetch_assoc($dbres->query("SELECT TRecId, TTreeId,
                TSpeciesId, TLat, TLong, TAreaId, TQuadId, TDBH, TDistCrn, TDistTree,
                THeight,TCrwnId, TCrwnWidth1, TCrwnWidth2, TCrwnArea, TRemoved,
                TComments, TRecCreatedDate, TRecCreatorId
                FROM Tree where TTreeId = " . $dbres->escapeString($id) . ""));
            //Now set all of the other attributes
            $this->recid = (int)$res['TRecId'];
            $this->id = (int)$res['TTreeId'];
            $this->sid = (int)$res['TSpeciesId'];
            $this->lat = (double)$res['TLat'];
            $this->long = (double)$res['TLong'];
            $this->aid = (int)$res['TAreaId'];
            $this->qid = (int)$res['TQuadId'];
            $this->dbh = (double)$res['TDBH'];
            $this->dcrn = (double)$res['TDistCrn'];
            $this->dtree = (double)$res['TDistTree'];
            $this->height = (double)$res['THeight'];
            $this->cid = (int)$res['TCrwnId'];
            $this->cw1 = (double)$res['TCrwnWidth1'];
            $this->cw2 = (double)$res['TCrwnWidth2'];
            $this->ca = (double)$res['TCrwnArea'];
            $this->rem = (bool)$res['TRemoved'];
            $this->com = $res['TComments'];
            $this->createddate = $res['TRecCreatedDate'];
            $this->creatorid = (int)$res['TRecCreatorId'];
            return True;
        }     
}
?>
