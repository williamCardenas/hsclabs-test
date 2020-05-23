<?php

namespace Entity;

use \Exception;

class Storage
{
    const FILE_NAME = "values";
    const PATH = "storage";

    private $file;

    public function save(String $value, int $line = null): bool
    {
        try {
            if ($line === null) {
                $file = fopen(self::PATH . DIRECTORY_SEPARATOR . self::FILE_NAME, 'a');
                fwrite($file, $value . PHP_EOL);
                fclose($file);
            }else{
                $file = fopen(self::PATH . DIRECTORY_SEPARATOR . self::FILE_NAME, 'r');
                $fileWrite = fopen(self::PATH . DIRECTORY_SEPARATOR . self::FILE_NAME.'_new', 'w');
                $fileLine = 0;
                while (($buffer = fgets($file)) !== false) {
                    if($fileLine == $line){
                        fwrite($fileWrite, $value . PHP_EOL);
                    }else{
                        fwrite($fileWrite, $buffer);
                    }
                    $fileLine++;
                }
                fclose($fileWrite);
                fclose($file);
                unlink(self::PATH . DIRECTORY_SEPARATOR . self::FILE_NAME);
                rename(self::PATH . DIRECTORY_SEPARATOR . self::FILE_NAME.'_new',self::PATH . DIRECTORY_SEPARATOR . self::FILE_NAME);
            }
            
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    public function search(String $key): ?String
    {
        if(file_exists(self::PATH . DIRECTORY_SEPARATOR . self::FILE_NAME)){
            $file = fopen(self::PATH . DIRECTORY_SEPARATOR . self::FILE_NAME, "r");
    
            $line = 0;
            while (($buffer = fgets($file)) !== false) {
                if (preg_match('/^' . $key . '\|/', $buffer) > 0) {
                    $buffer = preg_replace('/\s+/', ' ', trim($buffer));
                    fclose($file);
                    return $buffer . "|" . $line;
                }
                $line++;
            }
            fclose($file);
        }
        return null;
    }
}
