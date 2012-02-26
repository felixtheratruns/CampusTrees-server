<?php
//Import configuration
require_once("../config.inc.php");

//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");

class Region {
	private $dbres;		//Database resource
	
	protected $recid;
	protected $id;		//Region ID
	protected $name;	//Region name
	protected $areas;	//Array of areas in region
}
?>
