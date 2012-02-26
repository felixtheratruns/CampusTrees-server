<?php
//Import configuration
require_once("../config.inc.php");

//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");

class Genus {
	private $dbres;		//Database resource
	
	protected $id;		//Genus ID
	protected $name;	//Genus name
	protected $nick;	//Genus nickname
}
?>
