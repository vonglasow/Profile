<?php

namespace Profile\Bench;

interface IMark
{
    public function __construct($sName, $sGroup);
    public function __toString();
    public function diff();
    public function getMarkerGroup();
    public function getMarkerName();
    public function getUniqid();
    public function isRunning();
    public function setMarkerGroup($sGroup);
    public function setMarkerName($sName);
    public function setUniqid($sUniqid);
    public function start();
    public function stop();
}