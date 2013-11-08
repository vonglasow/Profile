<?php

namespace Profile\Decorators;


class Cli extends Output
{
    private $aColor = array(
        'normal' => "[0m",
        'red' => "[0;31m",
        'green' => "[0;32m",
        'blue' => "[0;34m",
    );

    protected function formatBody()
    {
        $margin = 0;

        foreach ($this->aData as $aData) {
            foreach ($aData as $aStat) {
                strlen($aStat['name']) > $margin and $margin = strlen($aStat['name']);
            }
        }

        $margin += 3; // Increase margin due to formatting adding 1 space and 2 brackets

        foreach ($this->aData as $sGroup => $aData) {
            $this->sOutput .= $sGroup . PHP_EOL;
            $this->sOutput .= str_repeat('=', strlen($sGroup)) . PHP_EOL;

            $width = $this->sWidth - $margin;

            $formatTime = $this->getColor('green') . '%-' . $margin . 's %-' . $width . 's %5.1f %%, %s' . $this->getColor() . PHP_EOL;
            $formatMemoryUsage = $this->getColor('blue') . '%-' . $margin . 's %-' . $width . 's %5.1f %%, %s' . $this->getColor() . PHP_EOL;

            foreach ($aData as $v) {
                $this->sOutput .= sprintf(
                    $formatTime,
                    substr($v['name'], 0, -13) . ' (' . substr($v['name'], -13) . ')',
                    str_repeat(
                        '#',
                        round($v['processTimeRatio'] * $width / 100)
                    ),
                    $v['processTimeRatio'],
                    static::formatTime($v['processTime'])
                );
                $this->sOutput .= sprintf(
                    $formatMemoryUsage,
                    substr($v['name'], 0, -13) . ' (' . substr($v['name'], -13) . ')',
                    str_repeat(
                        '#',
                        abs(round($v['processMemoryRatio'] * $width / 100))
                    ),
                    $v['processMemoryRatio'],
                    static::formatNumberOfOctets($v['memoryUsageConsume'])
                );
                $this->sOutput .= $this->separator();
            }
        }
    }

    protected function formatHeader()
    {
        $fTotal = static::formatTime($this->aData['Total']);
        $fTotalMemoryUsage = static::formatNumberOfOctets($this->aData['TotalMemoryUsage']);
        $fTotalMemoryPeak = static::formatNumberOfOctets($this->aData['TotalMemoryPeak']);

        if ($this->aData['Total'] > 1) {
            $this->sOutput = $this->getColor('red') . "Total time: $fTotal. - ";
        } else {
            $this->sOutput = $this->getColor('green') . "Total time: $fTotal. - ";
        }

        unset($this->aData['Total'], $this->aData['TotalMemoryUsage'], $this->aData['TotalMemoryPeak']);

        $this->sOutput .= $this->getColor('blue') . "Total Memory Usage: $fTotalMemoryUsage. - ";
        $this->sOutput .= $this->getColor('blue') . "Total Memory Peak: $fTotalMemoryPeak." . $this->getColor() . PHP_EOL;
        $this->sOutput .= $this->separator();
    }

    public function display()
    {
        $this->formatHeader();
        $this->formatBody();

        return $this->sOutput;
    }

    public function getColor($sColor = null)
    {
        $sColor = (isset($this->aColor[$sColor])) ? $sColor : 'normal';
        return chr(27) . $this->aColor[$sColor];
    }

    public function separator()
    {
        return str_repeat('-', $this->sWidth + 20) . PHP_EOL;
    }
}