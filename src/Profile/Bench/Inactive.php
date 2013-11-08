<?php

namespace Profile\Bench;

class Inactive implements \Profile\Bench\IMark {
    protected $sMarkerName;
    protected $sMarkerGroup;

    public function __construct($sName, $sGroup)
    {
        $this->setMarkerName($sName);
        $this->setMarkerGroup($sGroup);
    }

    public function __toString()
    {
        return '';
    }

    public function diff()
    {
    }

    public function getMarkerGroup()
    {
    }

    public function getMarkerName()
    {
    }

    public function getUniqid()
    {
    }

    public function isRunning()
    {
    }

    public function setMarkerGroup($sGroup)
    {
    }

    public function setMarkerName($sName)
    {
    }

    public function setUniqid($sUniqid)
    {
    }

    public function start()
    {
    }

    public function stop()
    {
    }
}