<?php

class CacheManager {

    public function CacheManager() {
        $yaay = true;
    }

    public function createDataCache($file, $selectedTrees) {
        $dFile = fopen($file, "w");
        if ($dFile) {
            fputs($dFile, json_encode($selectedTrees), strlen(json_encode($selectedTrees)));
            fclose($dFile);
        }
        else {echo "Oh poo";}
    }

    public function readDataCache($file) {
        ob_start();
        require $file;
        $data = ob_get_clean();
        $trees = json_decode($data);
        $res = array();
        foreach ($trees as $t) {array_push($res, get_object_vars($t));}
        return $res;
    }

    public function clear($type) {
        if ($type == 1) {
            $allT = ROOT_DIR . "cache/allTree.data";
            $z1T = ROOT_DIR . "cache/z1Tree.data";
            $z2T = ROOT_DIR . "cache/z2Tree.data";
            if (is_file($allT)) {unlink($allT);}
            if (is_file($z1T)) {unlink($z1T);}
            if (is_file($z2T)) {unlink($z2T);}
        }
    }

}

?>
