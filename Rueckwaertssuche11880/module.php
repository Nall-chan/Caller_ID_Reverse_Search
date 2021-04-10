<?php
declare(strict_types=1);

require_once __DIR__.'/../libs/BaseModule.php';

class Rueckwaertssuche11880 extends RueckwaertssucheBase
{
    protected function DoSerach(string $Number)
    {
        $Url = 'https://www.11880.com/rueckwaertssuche/'.$Number;
        $Data = @Sys_GetURLContentEx($Url, ['Timeout'=>5000]);
        if ($Data === false) {
            $this->SendDebug('ERROR', 'fetch Url', 0);
            return false;
        }
        $TitleTag=[];
        preg_match('/<title>(.*)<\/title>/i', $Data, $TitleTag); // minimal schneller als xpath;
        if (sizeof($TitleTag)<=1) {
            $this->SendDebug('ERROR', 'Title not found', 0);
            return false;
        }
        $this->SendDebug('Title', $TitleTag[1], 0);
        if (strpos($TitleTag[1], 'Telefonbuch Rückwärtssuche') !== false) {
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($Data);
            if ($dom->loadHTML($Data) === false) {
                $this->SendDebug('ERROR', 'parse HTML', 0);
                return false;
            }
            $xpath = new DOMXPath($dom);
            $NameNode = $xpath->query('/html/body/div[3]/section/div[1]/div[2]/div[1]/div[1]/div[3]/ol/li[2]/div[1]/div[1]/a/h2', null, false);
            if ($NameNode->length == 0) {
                $this->SendDebug('search', 'no hit', 0);
                return false;
            }
            $Name = trim($NameNode->item(0)->nodeValue);
        } else {
            $Name = trim(explode('|', $TitleTag[1])[0]);
        }
        if ($Name == 'Leider wurde zu dieser Suche kein Eintrag gefunden.') {
            $this->SendDebug('search', 'no hit', 0);
            return false;
        }
        $this->SendDebug('Found Name', $Name, 0);
        return $Name;
    }
}
