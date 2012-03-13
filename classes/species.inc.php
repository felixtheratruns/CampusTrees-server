<?php
//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");

class Species {
	private $dbres;		//Database resource
	
	protected $recid;
	protected $id;		//Species ID
	protected $name;	//Common name
	protected $gid;		//Genus ID
	protected $species;
	protected $na;		//Bool if species is from N.America
	protected $ky;		//Bool if species is from KY
	protected $native;	//Bool if species is native
	protected $comments;
	protected $treecount;
}
?>
