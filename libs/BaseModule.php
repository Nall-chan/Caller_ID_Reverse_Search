<?php
declare(strict_types=1);

eval('declare(strict_types=1);namespace Rueckwaertssuche {?>' . file_get_contents(__DIR__ . '/../libs/helper/BufferHelper.php') . '}');
eval('declare(strict_types=1);namespace Rueckwaertssuche {?>' . file_get_contents(__DIR__ . '/../libs/helper/DebugHelper.php') . '}');

require_once __DIR__.'/Cache.php';

/**
 * @property TNoVarList $Cache
 */
abstract class RueckwaertssucheBase extends IPSModule
{
    use \Rueckwaertssuche\BufferHelper;
    use \Rueckwaertssuche\DebugHelper;

    public function Create()
    {
        //Never delete this line!
        parent::Create();
        $this->RegisterPropertyString('AreaCode', '');
        $this->Cache = new \RueckwaertssucheCache\TNoVarList();
    }
    public function ClearCache()
    {
        $this->SendDebug('Clear cache bytes', strlen(serialize($this->Cache)), 0);
        $this->Cache = new \RueckwaertssucheCache\TNoVarList();
        return true;
    }
    public function GetName(string $Number)
    {
        /** @var \RueckwaertssucheCache\TNoVarList $Cache */
        $Cache = $this->Cache;
        if ($Number[0] !=='0') {
            $Number = $this->ReadPropertyString('AreaCode').$Number;
        }
        $Name = $Cache->GetNameByNumber($Number);
        if ($Name !== null) {
            $this->SendDebug('Cache', 'found', 0);
            $this->SendDebug('RESULT', $Name, 0);
            return $Name;
        }
        $this->SendDebug('Cache', 'not found', 0);
        $Name = $this->DoSerach($Number);
        $TNoVar = new \RueckwaertssucheCache\TNoVar($Number, $Name);
        $this->SendDebug('AddCache', $TNoVar, 0);
        $Cache = $this->Cache;
        $Cache->Add($TNoVar);
        $this->Cache = $Cache;
        return $Name;
    }
    abstract protected function DoSerach(string $Number);
}
