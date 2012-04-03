<?php
//Import configuration

//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");

class Genus {
	
	protected $gid;		//Genus ID
	protected $genus;	//Genus name
	protected $nick;	//Genus nickname
	private $createdate;
	private $creatorid;

	//Class constructor
	public function Genus($genID, $gname=null, $gnick=null, $gcreate=null, $gcreator=null) {
		//Precondition checking
		if (!isset($genID) || empty($genID) || $genID <=0)
			throw new Exception("A proper Genus ID was not provided");

		//Connect to the database
		//$this->dbres = new MySQL();

		//Query
                if (!isset($gname)) {
                    $dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
		    $query = $dbres->Query("SELECT * FROM `Genus` WHERE `GGenusID`='" . $this->dbres->escapeString($genID) . "' LIMIT 1;");
    
		    //Check that query was a success
		    if (!$query || mysql_num_rows($query) != 1)
			    throw new Exception("The Genus was not found in the database.");
    
		    //Pull data
		    $data = mysql_fetch_assoc($query);
    
		    //Set data
		    $this->gid = $genID;
		    $this->genus = $data['GGenus'];
		    $this->nick = $data['GNickname'];
		    $this->createdate = $data['GRecCreatedDate'];
		    $this->creatorid = $data['GRecCreatorId'];
                }
                else {
		    $this->gid = $genID;
		    $this->genus = $gname;
		    $this->nick = $gnick;
		    $this->createdate = $gcreate;
		    $this->creatorid = $gcreator;
                }
	}

	//Getters and Setters
	public function getID() {
		return $this->gid;
	}
	protected function setID($newID) {
		//Precondition checking
		if (!isset($newID) || empty($newID))
			return FALSE;

		//Set the variable
		$this->gid = $newID;

		//Fin
		return TRUE;
	}

	public function getName() {
		return $this->genus;
	}
	protected function setName($newName) {
		//Precondition checking
		if (!isset($newName) || empty($newName))
			return FALSE;

		//Set the variable
		$this->genus = $newName;

		return TRUE;
	}

	public function getNick() {
		return $this->nick;
	}
	protected function setNick($newNick) {
		//Precondition checking
		if (!isset($newNick) || empty($newNick))
			return FALSE;

		//Set the variable
		$this->nick = $newNick;

		return TRUE;
	}

        public function getProperties() {
            $properties = get_object_vars($this);
            return $properties;
        }

	//Additional functions
	public function getSpecies() {
		//Precondition: None
		//Postcondition: Return an array of species IDs, or FALSE if none exist

		//Query
		$query = $this->dbres->Query("SELECT SSpeciesId FROM Species WHERE `SGenusId`='" . $this->dbres->escapeString($this->id) . "' ORDER BY `SSpeciesId` ASC;");

		//Make sure it was a success
		if (!$query)
			throw new Exception("There was an error finding the species for this genus.");

		//Determine what to return
		if (mysql_num_rows($query) == 0)
			return FALSE;
		else {
			//Build array
			$SArr = array();

			while($row = mysql_fetch_assoc($query)) {
				array_push($SArr, $row['SSpeciesId']);
			}

			//Return array
			return $SArr;
		}
	}
}
?>
