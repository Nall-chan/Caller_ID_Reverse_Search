<?php

declare(strict_types=1);

require_once __DIR__ . '/../libs/BaseModule.php';

class RueckwaertssucheTelSearchCH extends RueckwaertssucheBase
{
    protected function DoSerach(string $Number)
    {
        $Url = 'http://tel.search.ch/?tel=' . $Number;
        $Data = @Sys_GetURLContentEx($Url, ['Timeout'=>5000]);
        if ($Data === false) {
            $this->SendDebug('ERROR', 'fetch Url', 0);
            return false;
        }
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        if ($dom->loadHTML($Data) === false) {
            $this->SendDebug('ERROR', 'parse HTML', 0);
            return false;
        }
        $xpath = new DomXPath($dom);
        $NameNode = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), 'tel-detail-baseinfo')]/h1");
        if ($NameNode->length == 0) {
            $NameNode = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), 'tel-result-main')]/h1");
            if ($NameNode->length == 0) {
                $this->SendDebug('search', 'no hit', 0);
                return false;
            }
        }
        $Name = trim($NameNode->item(0)->nodeValue);
        $this->SendDebug('Found Name', $Name, 0);
        return $Name;
    }
}
