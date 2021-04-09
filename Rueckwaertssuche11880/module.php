<?php
declare(strict_types=1);

eval('declare(strict_types=1);namespace Rueckwaertssuche11880 {?>' . file_get_contents(__DIR__ . '/../libs/helper/BufferHelper.php') . '}');
eval('declare(strict_types=1);namespace Rueckwaertssuche11880 {?>' . file_get_contents(__DIR__ . '/../libs/helper/DebugHelper.php') . '}');

require_once __DIR__.'/../libs/Cache.php';

/**
 * @property TNoVarList $Cache
 */
class Rueckwaertssuche11880 extends IPSModule
{
    use \Rueckwaertssuche11880\BufferHelper;
    use \Rueckwaertssuche11880\DebugHelper;

    public function Create()
    {
        //Never delete this line!
        parent::Create();
        $this->Cache = new \RueckwaertssucheCache\TNoVarList();
    }

    public function Destroy()
    {
        //Never delete this line!
        parent::Destroy();
    }

    public function ApplyChanges()
    {
        parent::ApplyChanges();
    }
    public function ClearCache()
    {
        $this->Cache = new \RueckwaertssucheCache\TNoVarList();
        return true;
    }

    public function GetName(string $Number)
    {
        /** @var \RueckwaertssucheCache\TNoVarList $Cache */
        $Cache = $this->Cache;
        $Name = $Cache->GetNameByNumber($Number);
        if ($Name !== false) {
            $this->SendDebug('Cache', 'found', 0);
            $this->SendDebug('RESULT', $Name, 0);
            return $Name;
        }
        $this->SendDebug('Cache', 'not found', 0);
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
        if ($Name !== false) {
            $TNoVar = new \RueckwaertssucheCache\TNoVar($Number, $Name);
            $this->SendDebug('AddCache', $TNoVar, 0);
            $Cache = $this->Cache;
            $Cache->Add($TNoVar);
            $this->Cache = $Cache;
        }
        return $Name;
    }
}
