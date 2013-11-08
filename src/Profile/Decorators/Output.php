<?php

namespace Profile\Decorators;

use Profile\Bench\State\IMark;

abstract class Output implements IDecorator
{
    const PRECISION = 2;

    protected $aData;
    protected $sOutput = '';
    protected $sWidth = 80;

    static protected $aNumberOfOctetsUnits = array(
        'Go' => 1000000000,
        'Mo' => 1000000,
        'ko' => 1000,
        'o' => 0
    );

    abstract public function display();

    public function __toString()
    {
        return $this->display();
    }

    public function setData(IMark $oBench)
    {
        $this->aData = $oBench->getStatistics();
    }

    public static function formatTime($iTime, $iPrecision = self::PRECISION)
    {
        return ($iTime < 1) ? round($iTime * 1000, $iPrecision) . ' ms' : round($iTime, $iPrecision) . ' s';
    }

    public static function formatNumberOfOctets($iNumberOfOctets, $iPrecision = self::PRECISION)
    {
        $iAbsNumberOfOctets = abs($iNumberOfOctets);

        foreach (static::$aNumberOfOctetsUnits as $sUnit => $iFloor) {
            if ($iAbsNumberOfOctets >= $iFloor) {
                return number_format(
                    $iFloor === 0 ? $iNumberOfOctets : $iNumberOfOctets / $iFloor,
                    $iPrecision
                ) . ' ' . $sUnit;
            }
        }

        return null;
    }
}