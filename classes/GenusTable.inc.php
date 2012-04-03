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
                              (int)$row['GRecCreatorId']);
                $selectedGenus[$i] = $g->getProperties();
                $i++;
            }
        }
        return $selectedGenus;
    }

    private function QueryAll() {
        return $this->dbres->query("SELECT GGenusId, GGenus, GNickname, GRecCreatedDate, GRecCreatorId
                                    FROM Genus");
    }
}

?>
