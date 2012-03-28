<?php
//Import configuration

//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");

class Genus {
	private $dbres;		//Database resource
	
	protected $id;		//Genus ID
	protected $name;	//Genus name
	protected $nick;	//Genus nickname
	private $createDate;
	private $createdBy;

	//Class constructor
	public function Genus($genID) {
		//Precondition checking
		if (!isset($genID) || empty($genID) || $genID <=0)
			throw new Exception("A proper Genus ID was not provided");

		//Connect to the database
		//$this->dbres = new MySQL();

		//Query
		$query = $this->dbres->Query("SELECT * FROM `Genus` WHERE `GGenusID`='" . $this->dbres->escapeString($genID) . "' LIMIT 1;");

		//Check that query was a success
		if (!$query || mysql_num_rows($query) != 1)
			throw new Exception("The Genus was not found in the database.");

		//Pull data
		$data = mysql_fetch_assoc($query);

		//Set data
		$this->id = $genID;
		$this->name = $data['GGenus'];
		$this->nick = $data['GNickname'];
		$this->createDate = $data['GRecCreatedDate'];
		$this->createdBy = $data['GRecCreatorId'];
	}

	//Getters and Setters
	public function getID() {
		return $this->id;
	}
	protected function setID($newID) {
		//Precondition checking
		if (!isset($newID) || empty($newID))
			return FALSE;

		//Set the variable
		$this->id = $newID;

		//Fin
		return TRUE;
	}

	public function getName() {
		return $this->name;
	}
	protected function setName($newName) {
		//Precondition checking
		if (!isset($newName) || empty($newName))
			return FALSE;

		//Set the variable
		$this->name = $newName;

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
