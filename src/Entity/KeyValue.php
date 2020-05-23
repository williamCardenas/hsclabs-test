<?php

namespace Entity;

use phpDocumentor\Reflection\Types\Integer;

Class KeyValue
{
    private $key;
    private $value;
    private $cursorPosition = null;

    private $storage;

    public function __construct()
    {
        $this->storage = new Storage();
    }

    public function set($key, $value)
    {
        $oldValue = $this->storage->search($key);
        if(!empty($oldValue)){
            $this->loadFromString($oldValue);
        }else{
            $this->key = $key;
        }
        $this->value = $value;
        return $this->storage->save($this->getValueString(),$this->cursorPosition);
    }

    public function getValueString()
    {
        return $this->key."|".$this->value;
    }

    private function loadFromString(String $value):void
    {
        $value = explode("|", $value);
        $this->key = $value[0];
        $this->value = $value[1];
        
        $this->cursorPosition = intval(end($value));
    }

    public function get($key)
    {
        $value = $this->storage->search($key);
        if($value){
            $this->loadFromString($value);
            return $this->value;
        }
        return false;
    }
    
}