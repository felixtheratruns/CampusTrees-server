<!-- This file is part of server-side of the CampusTrees Project. It is subject to the license terms in the LICENSE file found in the top-level directory of this distribution. No part of CampusTrees Project, including this file, may be copied, modified, propagated, or distributed except according to the terms contained in the LICENSE file.-->
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
                      $row['SFruitType'], (bool)$row['SEdibleFruit'],
                      $row['SGrowthFactor'], (int)$row['SGenusId'],
                      $row['SSpecies']);
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
                          SFlowerRelLeaves, SFruitType, SEdibleFruit, SGrowthFactor,
                          SGenusId, SSpecies
                    FROM  Species
                    ");
         
        }
        private function QueryGetSpeciesByGenus($gid) {
            /*Precondition: Database connected and populated
             *Postcondition: Returns mysql_dataset of species info*/
            return $this->dbres->query("SELECT SSpeciesId, SCommonName,
                          SNAmerica, SKy, SNonNative, SComments,
                          SFlowerRelLeaves, SFruitType, SEdibleFruit, SGrowthFactor,
                          SGenusId, SSpecies
                    FROM  Species WHERE SGenusId = {$this->dbres->escapeString($gid)}
                    ");
         
        }

        public function getNextId() {
            $query = "SELECT SSpeciesId FROM Species ORDER BY SSpeciesId DESC LIMIT 1";
            $res = $this->dbres->query($query);
            $last = (int) mysql_result($res, 0);
            return $last + 1;
        }

        public function addSpecies($sid, $commonname, $species, $gf, $gid, $american, $ky,
                        $fruittype, $edible, $flowrelleaf, $comments, $uid) {

            $query = "INSERT INTO Species (SSpeciesId, SCommonName,
                        SSpecies, SGrowthFactor, SGenusId, SNAmerica, SKy,
                        SFruitType, SEdibleFruit, SFlowerRelLeaves, SComments,
                        SRecCreatorId)
                      VALUES (
                '{$this->dbres->escapeString($sid)}',
                '{$this->dbres->escapeString($commonname)}',
                '{$this->dbres->escapeString($species)}',
                '{$this->dbres->escapeString($gf)}',
                '{$this->dbres->escapeString($gid)}',
                '{$this->dbres->escapeString($american)}',
                '{$this->dbres->escapeString($ky)}',
                '{$this->dbres->escapeString($fruittype)}',
                '{$this->dbres->escapeString($edible)}',
                '{$this->dbres->escapeString($flowrelleaf)}',
                \"{$this->dbres->escapeString($comments)}\",
                '{$this->dbres->escapeString($uid)}',";
                $query = substr($query, 0, -1);
                $query .= ")";
//              echo "<br>{$query}<br>";
                $this->dbres->query($query);
//              echo $this->dbres->getLastError();
                return true;
        }
}
?>
