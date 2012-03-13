<?php
//Requirements
require_once(ROOT_DIR . 'classes/TreeTable.inc.php');
require_once(ROOT_DIR . 'classes/ZonePointTable.inc.php');
require_once(ROOT_DIR . 'classes/SpeciesTable.inc.php');

class ARHandler { /*Should probably create a generic
  Handler class and then make a App specific subclass with
  all of the JSON stuff*/
        private $phoneCon;       //Information for communicating with client

        protected $zoneList;    //List of Zones in DB
        protected $speciesList;    //List of Species in DB
        protected $selectedTrees;
        protected $tTable;      //Tree Table Object
        protected $zpTable;
        protected $sTable;
        

        //Contructor
        public function ARHandler(/*Will require info for response to Phone*/) {
            $this->tTable = new TreeTable();
            $this->zpTable = new ZonePointTable();
            $this->sTable = new SpeciesTable();
            return True;
        }
        private function getSpeciesList() {
            $this->speciesList = $this->sTable->GetSpecies();
        }
        public function JSON_RequestSpeciesList() {
            $this->getSpeciesList();
            return json_encode($this->speciesList);
        }

        private function getZoneList() {
            $this->zoneList = $this->zpTable->GetZones();
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

        public function JSON_RequestZoneList() {
            $this->getZoneList();
            return json_encode($this->zoneList);
        }
        public function SelectZone($zId) {
            $this->selectedTrees = $this->tTable->ByZone($zId);
        }

        public function JSON_RequestTreesByZone($zone) {
            $this->SelectZone($zone);
            echo json_encode($this->selectedTrees);
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
            
}
?>
