<?php

namespace Profile\Bench\State;

interface IMark extends \Iterator, \Countable
{
    public function __get($name);
    public function __toString();
    public function computeStatistics();
    public function count();
    public function current();
    public function getGroup();
    public function getStatistics();
    public function getUniqid();
    public function key();
    public function next();
    public function rewind();
    public function setGroup($sGroup);
    public function setUniqid($sUniqid);
    public function unsetAll();
    public function valid();
}