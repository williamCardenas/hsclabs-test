<?php

namespace Entity;

use DateTime;
use DateInterval;
use phpDocumentor\Reflection\Types\Integer;

Class KeyValue
{
    const SECUND_TYPE = "EX";
    const MILESECUND_TYPE = "PX";

    private $key;
    private $value;
    private $cursorPosition = null;
    private $expireType = null;
    private $timestampToExpire = null;
    private $deleted = 0;

    private $storage;

    public function __construct()
    {
        $this->storage = new Storage();
    }

    public function set($key, $value, $expireType = null, $expireTime = null)
    {
        $oldValue = $this->storage->search($key);
        if(!empty($oldValue)){
            $this->loadFromString($oldValue);
        }else{
            $this->key = $key;
        }
        $this->value = $value;
        $this->deleted = 0;

        if(!empty($expireTime) && !empty($expireType)){
            $this->expireType = $expireType;
            $date = new DateTime("Now");

            if($this->expireType == self::MILESECUND_TYPE){
                $this->timestampToExpire = $date->getTimestamp()*1000;
            }else{
                $date->add(new DateInterval('PT'.$expireTime.'S'));
                $this->timestampToExpire = $date->getTimestamp();
            }
        }
        
        return $this->storage->save($this->getValueString(),$this->cursorPosition);
    }

    public function getValueString()
    {
            return $this->key."|".$this->value."|".$this->expireType."|".$this->timestampToExpire."|".$this->deleted;
    }

    private function loadFromString(String $value):void
    {
        $value = explode("|", $value);

        $this->key = $value[0];
        $this->value = $value[1];
        $this->cursorPosition = intval(array_pop($value));

        $this->expireType = array_key_exists(2,$value)?$value[2]:null;
        $this->timestampToExpire = array_key_exists(3,$value)?$value[3]:null;
    }

    public function get(String $key)
    {
        $value = $this->storage->search($key);
        if($value){
            $this->loadFromString($value);
            if($this->deleted == 0){
                $timestampToExpire = intval($this->timestampToExpire);
    
                if(!empty($timestampToExpire)){
                    $date = new DateTime('Now');
        
                    $dateExpire = new DateTime("@$timestampToExpire");
        
                    if($date > $dateExpire){
                        return "(nil)";
                    }
                }
                return $this->value;
            }
        }
        return "(nil)";
    }

    public function del(String $key):String
    {
        $value = $this->storage->search($key);
        if(!empty($value)){
            $this->loadFromString($value);
            $this->deleted = 1;
            $this->storage->save($this->getValueString(),$this->cursorPosition);

            return "(integer) 1";
        }else{
            return "(integer) 0";
        }
    }
    
}