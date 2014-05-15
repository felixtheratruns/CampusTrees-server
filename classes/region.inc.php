<!-- This file is part of server-side of the CampusTrees Project. It is subject to the license terms in the LICENSE file found in the top-level directory of this distribution. No part of CampusTrees Project, including this file, may be copied, modified, propagated, or distributed except according to the terms contained in the LICENSE file.-->
<?php

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
