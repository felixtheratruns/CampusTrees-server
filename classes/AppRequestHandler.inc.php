<?php
//Requirements
require_once(ROOT_DIR . 'classes/TreeTable.inc.php');
require_once(ROOT_DIR . 'classes/ZonePointTable.inc.php');
require_once(ROOT_DIR . 'classes/SpeciesTable.inc.php');
require_once(ROOT_DIR . 'classes/tree.inc.php');

class ARHandler { /*Should probably create a generic
  Handler class and then make a App specific subclass with
  all of the JSON stuff*/
        private $phoneCon;       //Information for communicating with client

        protected $zoneList;    //List of Zones in DB
        protected $speciesList;    //List of Species in DB
        protected $selectedTrees;
        protected $tTable;      //Tree Table Object
        protected $zpTable;     //ZonePoint table object
        protected $sTable;      //Species table object
        

        //Contructor
        public function ARHandler() {
            $this->tTable = new TreeTable();
            $this->zpTable = new ZonePointTable();
            $this->sTable = new SpeciesTable();
            return True;
        }

        public function RequestTById($tid) {
            $t = new tree($tid);
            return $t->getProperties();
        }
        public function getTree($tid) {
            $t = new tree($tid);
            echo $t->ToJSON();
            $t2 = new tree(5, 29, 264376.08427, 1206561.72721, 22, 40, 170, 145);
            echo $t2->ToJSON();
        }

//Plant facts
        private function getPFacts() {
            $res["Tallest"] = $this->tTable->getTallest();
            $res["Most CO2 Sequestered in Lifetime"] = $this->tTable->getMCLife();
            $res["Most CO2 Sequestered per Year"] = $this->tTable->getMCYear();
            return $res;
        }

        public function JSON_RequestPFacts() {
            return json_encode($this->getPFacts());
        }

//Species Table functions
        private function getSpeciesList() {
            $this->speciesList = $this->sTable->GetSpecies();
        }

        public function JSON_RequestSpeciesList() {
            $this->getSpeciesList();
            return json_encode($this->speciesList);
        }

//Zone List Functions
        private function getZoneList() {
            $this->zoneList = $this->zpTable->GetZones();
        }
        public function JSON_RequestZoneList() {
            $this->getZoneList();
            return json_encode($this->zoneList);
        }

        public function ZoneList_ToString() {
            $this->getZoneList();
            $res = "<br>";
            foreach ($this->zoneList as $row) {
                $i = $row['id'];
                $res .= "Zone: {$i}<br>";
                foreach ($row['points'] as $point) {
                    $res .= "&nbsp;&nbsp;{$point['lat']}, {$point['long']}<br>";
                }
            }
            return $res;
        }

//Tree Table Functions
        public function SelectZone($zId) {
            $this->selectedTrees = $this->tTable->ByZone($zId);
        }

        public function RequestTreesByZone($zone) {
            $this->SelectZone($zone);
            return $this->selectedTrees;
        }

        public function JSON_RequestTreesByZone($zone) {
            $this->SelectZone($zone);
            return json_encode($this->selectedTrees);
        }

        public function SelectedTrees_ToString() {
            $res = "<br><br>";
            $i = 1;
            foreach ($this->selectedTrees as $row) {
                $res .= "{$i}) ";
                foreach ($row as $col) {
                    $res .= "{$col}  ";
                }
                $res .= "<br>";
                $i++;
            }
        return $res;
        }
//Flowering/Fruiting
        public function RequestFlower($month) {
            return "Ok so I need to write the class to handle this";
        }
            
}
?>
