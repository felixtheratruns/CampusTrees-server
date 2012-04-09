<?php
//Requirements
require_once(GCTOOLS_DIR . "database.inc.php");
require_once(ROOT_DIR . "classes/species.inc.php");

class SpeciesTable { 
	private $dbres;		//Database resource



        //Contructor
        public function SpeciesTable() {
            $this->dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);

        }

        public function GetSpecies($admin=false) {
            /*Precondition: Database connected and populated
             *Postcondition: Returns JSON optimized array of species info.
            */
            $res = $this->QueryGetSpecies();
            echo $this->dbres->getLastError();
            return $this->buildList($admin, $res);
        }

        public function GetSpeciesByGenus($gid, $admin=false) {
            /*Precondition: Database connected and populated
             *Postcondition: Returns JSON optimized array of species info.
            */
            $res = $this->QueryGetSpeciesByGenus($gid);
            echo $this->dbres->getLastError();
            return $this->buildList($admin, $res);
        }

        private function buildList($admin, $sqlres) {
            $i = 0;
            if ($admin) {}//Write meeeee
            else {
                while ($row = mysql_fetch_assoc($sqlres)) {
                    $s = new Species ((int)$row['SSpeciesId'],
                      $row['SCommonName'], (bool)$row['SNAmerica'],
                      (bool)$row['SKy'], (bool)$row['SNonNative'],
                      $row['SComments'], (int)$row['SFlowerRelLeaves'],
                      $row['SFruitType'], (bool)$row['SEdibleFruit']);
                    $selectedSpecies[$i] = $s->getProperties();
                    $i++;
                }
            }
            return $selectedSpecies;
        }

        private function QueryGetSpecies() {
            /*Precondition: Database connected and populated
             *Postcondition: Returns mysql_dataset of species info*/
            return $this->dbres->query("SELECT SSpeciesId, SCommonName,
                          SNAmerica, SKy, SNonNative, SComments,
                          SFlowerRelLeaves, SFruitType, SEdibleFruit
                    FROM  Species
                    ");
         
        }
        private function QueryGetSpeciesByGenus($gid) {
            /*Precondition: Database connected and populated
             *Postcondition: Returns mysql_dataset of species info*/
            return $this->dbres->query("SELECT SSpeciesId, SCommonName,
                          SNAmerica, SKy, SNonNative, SComments,
                          SFlowerRelLeaves, SFruitType, SEdibleFruit
                    FROM  Species WHERE SGenusId = {$this->dbres->escapeString($gid)}
                    ");
         
        }
}
?>
