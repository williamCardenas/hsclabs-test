<?php
require __DIR__ . '/vendor/autoload.php';

$value = new Entity\KeyValue();

if (php_sapi_name() == "cli") {
    $method = $argv[1];
    if (method_exists($value, $method)) {
        if (strtolower($method) == "set") {
            $value->set($argv[2], $argv[3]);
        }
        if (strtolower($method) == "get") {
            echo $value->get($argv[2]) . "\n";
        }
        if (strtolower($method) == "del") {
            $deletedCount = 0;
            for ($index = 2; $index < count($argv); $index++) {
                $deleted = $value->del($argv[$index]);
                if($deleted == "(integer) 1"){
                    $deletedCount++;
                }
            }
            echo "(integer) $deletedCount";
        }
        if (strtolower($method) == "dbsize") {
            $storage = new Entity\Storage();
            echo $storage->getDbSize() . "\n";
        }
    }
} else {
    if(array_key_exists("cmd", $_GET)){
        $argArray = explode(' ',$_GET['cmd']);
        $method = $argArray[0];
        if (method_exists($value, $method)) {
            if (strtolower($method) == "set") {
                $value->set($argArray[1], $argArray[2]);
                echo "OK";
            }
            if (strtolower($method) == "get") {
                echo $value->get($argArray[1]) . "\n";
            }
            if (strtolower($method) == "del") {
                $deletedCount = 0;
                for ($index = 1; $index < count($argArray); $index++) {
                    $deleted = $value->del($argArray[$index]);
                    if($deleted == "(integer) 1"){
                        $deletedCount++;
                    }
                }
                echo "(integer) $deletedCount";
            }
            if (strtolower($method) == "dbsize") {
                $storage = new Entity\Storage();
                echo $storage->getDbSize() . "\n";
            }
        }
    }
}
