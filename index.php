<?php
require __DIR__ . '/vendor/autoload.php';

if (php_sapi_name() == "cli") {
    $value = new Entity\KeyValue();

    $method = $argv[1];
    if (method_exists($value, $method)) {
        if ($method == "set") {
            $value->set($argv[2], $argv[3]);
        }
        if ($method == "get") {
            echo $value->get($argv[2]) . "\n";
        }
    }
} else {
    // Not in cli-mode
}
