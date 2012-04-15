<?php
require_once(ROOT_DIR . 'classes/genus.inc.php');

class GenusTable {

    private $dbres;

    public function GenusTable() {
        $this->dbres = new MySQL(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);

    }

    public function getAll($admin=false) {
        $res = $this->QueryAll();
        $i = 0;
        if ($admin) {$selectedTrees = 0;}//Need to write this
        else {
            while ($row = mysql_fetch_assoc($res)) {
                $g = new Genus((int)$row['GGenusId'], $row['GGenus'],
                              $row['GNickname'], $row['GRecCreatedDate'],
                              (int)$row['GRecCreatorId'], (float)$row['GAvgGrowthFactor']);
                $selectedGenus[$i] = $g->getProperties();
                $i++;
            }
        }
        return $selectedGenus;
    }

    private function QueryAll() {
        return $this->dbres->query("SELECT GGenusId, GGenus, GNickname,
                                    GRecCreatedDate, GRecCreatorId, GAvgGrowthFactor
                                    FROM Genus");
    }

        public function getNextId() {
            $query = "SELECT GGenusId FROM Genus ORDER BY GGenusId DESC LIMIT 1";
            $res = $this->dbres->query($query);
            $last = (int) mysql_result($res, 0);
            return $last + 1;
        }

        public function addGenus($gid, $genus, $nick, $agf, $uid) {
            $query = "INSERT INTO Genus (GGenusId, GGenus,
                        Gnickname, GAvgGrowthFactor, GRecCreatorId)
                      VALUES (
                '{$this->dbres->escapeString($gid)}',
                '{$this->dbres->escapeString($genus)}',
                '{$this->dbres->escapeString($nick)}',
                '{$this->dbres->escapeString($agf)}',
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
