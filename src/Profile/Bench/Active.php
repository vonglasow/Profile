<?php

namespace Profile\Bench;

class Active extends Inactive {
    protected $bRunning = false;
    protected $fMemoryStart;
    protected $fMemoryStop;
    protected $fStart;
    protected $fStop;
    protected $sMarkerName;
    protected $sMarkerGroup;
    protected $sUniqid;

    public function __construct($sName, $sGroup)
    {
        $this->setMarkerName($sName);
        $this->setMarkerGroup($sGroup);
    }

    public function __toString()
    {
        return json_encode($this->diff());
    }

    public function diff()
    {
        if ($this->isRunning()) {
            $this->stop();
        }

        if (null === $this->fStart && null === $this->fStop) {
            return null;
        }

        return array(
            'startTime'             => $this->fStart,
            'stopTime'              => $this->fStop,
            'processTime'           => $this->fStop - $this->fStart,
            'memoryUsageStart'      => $this->fMemoryStart['usage'],
            'memoryUsageStop'       => $this->fMemoryStop['usage'],
            'memoryUsageConsume'    => $this->fMemoryStop['usage'] - $this->fMemoryStart['usage'],
            'memoryPeakStart'       => $this->fMemoryStart['peak'],
            'memoryPeakStop'        => $this->fMemoryStop['peak'],
            'memoryPeakConsume'     => $this->fMemoryStop['peak'] - $this->fMemoryStart['peak'],
        );
    }

    public function getMarkerGroup()
    {
        return $this->sMarkerGroup;
    }

    public function getMarkerName()
    {
        return $this->sMarkerName;
    }

    public function getUniqid()
    {
        return $this->sUniqid;
    }

    public function isRunning()
    {
        return $this->bRunning;
    }

    public function setMarkerGroup($sGroup)
    {
        $sOldMarkerGroup = $this->sMarkerGroup;
        $this->sMarkerGroup = $sGroup;

        return $sOldMarkerGroup;
    }

    public function setMarkerName($sName)
    {
        $sOldMarkerName = $this->sMarkerName;
        $this->sMarkerName = $sName;

        return $sOldMarkerName;
    }

    public function setUniqid($sUniqid)
    {
        $sOldUniqid = $this->sUniqid;
        $this->sUniqid = $sUniqid;

        return $sOldUniqid;
    }

    public function start()
    {
        $this->fStart                   = microtime(true);
        $this->fMemoryStart['usage']    = memory_get_usage();
        $this->fMemoryStart['peak']     = memory_get_peak_usage();
        $this->bRunning                 = true;
        return $this;
    }

    public function stop()
    {
        if ($this->isRunning()) {
            $this->fStop                = microtime(true);
            $this->fMemoryStop['usage'] = memory_get_usage();
            $this->fMemoryStop['peak']  = memory_get_peak_usage();
            $this->bRunning             = false;
        }

        return $this;
    }
} 