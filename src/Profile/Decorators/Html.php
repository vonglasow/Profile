<?php

namespace Profile\Decorators;

class Html extends Output
{
    public function formatPageHeader()
    {
        $this->sOutput .= '<html><head></head><body><div id="list"></div>';
        $this->sOutput .= '<script type="text/javascript" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>';
        $this->sOutput .= '<script type="text/javascript" src="https://datatables.net/release-datatables/media/js/jquery.dataTables.js"></script>';
    }

    public function formatPageFooter()
    {
        $this->sOutput .= "<script>$(document).ready(function(){ $('#benchmark').dataTable(); });</script>";
        $this->sOutput .= '</body>';
    }

    public function formatHeader()
    {
        $fTotal = static::formatTime($this->aData['Total']);
        $fTotalMemoryUsage = static::formatNumberOfOctets($this->aData['TotalMemoryUsage']);
        $fTotalMemoryPeak = static::formatNumberOfOctets($this->aData['TotalMemoryPeak']);

        $this->sOutput .= "<div>Total time: $fTotal - Total Memory Usage: $fTotalMemoryUsage - Total Memory Peak: $fTotalMemoryPeak</div>";

        unset($this->aData['Total'], $this->aData['TotalMemoryUsage'], $this->aData['TotalMemoryPeak']);
    }

    public function formatBody()
    {
        $this->sOutput .= "<table border=1 cellpadding=0 cellspacing=0 id='benchmark'>";
        $this->sOutput .= "<thead></tr>
            <th>Group</th>
            <th>Mark</th>
            <th>Time %</th>
            <th>Time</th>
            <th>Memory ratio</th>
            <th>Memory</th>
        </tr></thead><tbody>";
        foreach ($this->aData as $aStats) {
            foreach ($aStats as $aData) {
                $this->sOutput .= "<tr>
                    <td>{$aData['group']} ({$aData['uniqid']})</td>
                    <td>" . substr($aData['name'], 0, -13) . "</td>
                    <td>{$aData['processTimeRatio']}</td>
                    <td>" . static::formatTime($aData['processTime']) . "</td>
                    <td>{$aData['processMemoryRatio']}</td>
                    <td>" . static::formatNumberOfOctets($aData['memoryUsageConsume']) . "</td></tr>";
            }
        }
        $this->sOutput .= "</tbody></table>";
    }

    public function display()
    {
        $this->formatPageHeader();
        $this->formatHeader();
        $this->formatBody();
        $this->formatPageFooter();

        return $this->sOutput;
    }
} 