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

}

?>
