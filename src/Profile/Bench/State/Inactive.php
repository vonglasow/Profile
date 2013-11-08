<?php

namespace Profile\Bench\State;

class Inactive implements IMark {
    protected static $aMark = array();
    protected $aStats = array();
    protected $sGroup;
    protected $sUniqid;

    public function __get($name)
    {
        if (isset(self::$aMark[$name])) {
            return self::$aMark[$name];
        }

        $oMark = new \Profile\Bench\Inactive($name, null);
        self::$aMark[$name] = $oMark;

        return $oMark;
    }

    public function __toString()
    {
        return '';
    }

    public function computeStatistics()
    {
    }

    public function count()
    {
    }

    public function current()
    {
    }

    public function getGroup()
    {
    }

    public function getStatistics()
    {
    }

    public function getUniqid()
    {
    }

    public function key()
    {
    }

    public function next()
    {
    }

    public function rewind()
    {
    }

    public function setGroup($sGroup)
    {
    }

    public function setUniqid($sUniqid)
    {
    }

    public function unsetAll()
    {
    }

    public function valid()
    {
    }
}