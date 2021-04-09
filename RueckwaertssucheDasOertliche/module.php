<?php
declare(strict_types=1);

eval('declare(strict_types=1);namespace RueckwaertssucheDasOertliche {?>' . file_get_contents(__DIR__ . '/../libs/helper/BufferHelper.php') . '}');
eval('declare(strict_types=1);namespace RueckwaertssucheDasOertliche {?>' . file_get_contents(__DIR__ . '/../libs/helper/DebugHelper.php') . '}');

require_once __DIR__.'/../libs/Cache.php';

/**
 * @property TNoVarList $Cache
 */
class RueckwaertssucheDasOertliche extends IPSModule
{
    use \RueckwaertssucheDasOertliche\BufferHelper;
    use \RueckwaertssucheDasOertliche\DebugHelper;

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
        //Never delete this line!
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
        $Url = 'https://www.dasoertliche.de/Controller?form_name=search_inv&ph='.$Number;
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
        $NameNode = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), 'st-treff-name')]");
        if ($NameNode->length == 0) {
            $this->SendDebug('search', 'no hit', 0);
            return false;
        }
        $Name = trim($NameNode->item(0)->nodeValue);
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
