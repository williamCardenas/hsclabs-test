<?php 
if (php_sapi_name() == "cli") {
    var_dump('teste');
} else {
    // Not in cli-mode
}