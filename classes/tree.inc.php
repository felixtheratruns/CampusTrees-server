<?php
//Import configuration
require_once("../config.inc.php");

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
}
?>
