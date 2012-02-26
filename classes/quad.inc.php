<?php
//Import configuration
require_once("../config.inc.php");

//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");

class Quad {
	private $dbres;		//Database resource
	
	protected $id;		//Quad ID
	protected $name;	//Quad name
}
?>
