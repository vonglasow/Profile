<?php

namespace Profile\Bench\State;

class Active extends Inactive {
    protected static $aMark = array();
    protected $aStats = array();

    public function __get($name)
    {
        $sGroup = $this->getGroup();

        if (isset(static::$aMark[$sGroup.$name])) {
            return static::$aMark[$sGroup.$name];
        }

        $oMark = new \Profile\Bench\Active($name, $sGroup);
        $oMark->setUniqid(($this->sUniqid) ?: $this->sUniqid = uniqid());
        static::$aMark[$sGroup.$name] = $oMark;

        return $oMark;
    }

    public function __toString()
    {
        return json_encode($this->aStats);
    }

    public function computeStatistics()
    {
        $fTotal             = 0;
        $fMaxUsageMemory    = 0;
        $fMaxPeakMemory     = 0;
        $this->aStats       = array();

        if (0 === count($this)) {
            return true;
        }

        foreach ($this as $key => $oMark) {
            if (null === $oMark->diff()) {
                continue;
            }
            $sGroup = $oMark->getMarkerGroup();
            $sUniqid = $oMark->getUniqid();

            $this->aStats[$sGroup][$key] = $oMark->diff();
            $this->aStats[$sGroup][$key]['name'] = $oMark->getMarkerName();
            $this->aStats[$sGroup][$key]['group'] = $sGroup;
            $this->aStats[$sGroup][$key]['uniqid'] = $sUniqid;
            $fTotal += $this->aStats[$sGroup][$key]['processTime'];
            $fMaxUsageMemory < $this->aStats[$sGroup][$key]['memoryUsageConsume'] and $fMaxUsageMemory = $this->aStats[$sGroup][$key]['memoryUsageConsume'];
            $fMaxPeakMemory < $this->aStats[$sGroup][$key]['memoryPeakConsume'] and $fMaxPeakMemory = $this->aStats[$sGroup][$key]['memoryPeakConsume'];
        }

        if (0 < $fTotal) {
            foreach ($this->aStats as $sGroup => $aStats) {
                foreach ($aStats as $key => $value) {
                    $this->aStats[$sGroup][$key]['processTimeRatio'] = round($value['processTime'] * 100 / $fTotal, 2);
                    $this->aStats[$sGroup][$key]['processMemoryRatio'] = round($value['memoryUsageConsume'] * 100 / $fMaxUsageMemory, 2);
                }
            }
        }

        $this->aStats['Total']              = $fTotal;
        $this->aStats['TotalMemoryUsage']   = $fMaxUsageMemory;
        $this->aStats['TotalMemoryPeak']    = $fMaxPeakMemory;

        return true;
    }

    public function count()
    {
        return count(static::$aMark);
    }

    public function current()
    {
        return current(static::$aMark);
    }

    public function getGroup()
    {
        return $this->sGroup;
    }

    public function getUniqid()
    {
        return $this->sUniqid;
    }

    public function getStatistics()
    {
        return $this->aStats;
    }

    public function key()
    {
        return key(static::$aMark);
    }

    public function next()
    {
        return next(static::$aMark);
    }

    public function rewind()
    {
        return reset(static::$aMark);
    }

    public function setGroup($sGroup)
    {
        $this->sGroup = $sGroup;
    }

    public function setUniqid($sUniqid)
    {
        $this->sUniqid = $sUniqid;
    }

    public function unsetAll()
    {
        static::$aMark = array();
    }

    public function valid()
    {
        if (empty(static::$aMark)) {
            return false;
        }

        $key    = key(static::$aMark);
        $return = next(static::$aMark) ? true : false;
        prev(static::$aMark);

        if (false === $return) {
            end(static::$aMark);

            if ($key === key(static::$aMark)) {
                $return = true;
            }
        }

        return $return;
    }
}