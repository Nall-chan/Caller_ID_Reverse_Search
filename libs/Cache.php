<?php

declare(strict_types=1);

namespace RueckwaertssucheCache;

/**
 * TNoVar ist eine Klasse welche die Daten einer Rufnummer und dessen Namen enthält.
 *
 * @author        Michael Tröger <micha@nall-chan.net>
 * @copyright     2021 Michael Tröger
 * @license       https://creativecommons.org/licenses/by-nc-sa/4.0/ CC BY-NC-SA 4.0
 *
 * @version       1.11
 *
 * @example <b>Ohne</b>
 *
 * @property string $Number Rufnummer
 * @property false|string $Name Name
 * @property int $Expire Timestamp
 */
class TNoVar
{
    public string $Number = '';

    public false|string $Name = false;

    public int $Expire = 0;

    /**
     * Erzeugt ein neues Objekt aus TNoVar.
     *
     * @param string $Number Rufnummer
     * @param string|false $Name Name
     *
     * @return TNoVar Das erzeugte Objekt.
     */
    public function __construct(string $Number, false|string $Name)
    {
        $this->Number = $Number;
        $this->Name = $Name;
        $this->Expire = time() + (86400 * 7); // 1 woche
    }
}

/**
 * TNoVarList ist eine Klasse welche die Daten des Cache enthält.
 *
 * @author        Michael Tröger <micha@nall-chan.net>
 * @copyright     2021 Michael Tröger
 * @license       https://creativecommons.org/licenses/by-nc-sa/4.0/ CC BY-NC-SA 4.0
 *
 * @version       1.11
 *
 * @example <b>Ohne</b>
 * @property TNoVar[] $Items Enthält ein Array von TNoVar
 */
class TNoVarList
{
    public array $Items = [];

    /**
     * Liefert die Daten welche behalten werden müssen.
     */
    public function __sleep(): array
    {
        $this->Items = array_filter($this->Items, function (TNoVar $Item)
        {
            return $Item->Expire > time();
        });
        return ['Items'];
    }

    /**
     * Fügt einen Eintrag in $Items hinzu.
     *
     * @param TNoVar $TNoVar Das hinzuzufügende Objekt.
     */
    public function Add(TNoVar $TNoVar): void
    {
        $this->Items[] = $TNoVar;
    }

    /**
     * Liefert den Namen zu einer Nummer, wenn kein Eintrag gefunden wird, dann false.
     *
     * @param string $Number Die Rufnummer zu welcher der Name gesucht wird.
     *
     * @return string|NULL|false Der Name oder false wenn nicht gefunden.
     */
    public function GetNameByNumber(string $Number): string|false|null
    {
        foreach ($this->Items as $TNoVar) {
            if ($TNoVar->Number == $Number) {
                return $TNoVar->Name;
            }
        }
        return null;
    }
}
