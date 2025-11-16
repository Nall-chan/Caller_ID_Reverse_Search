[![SDK](https://img.shields.io/badge/Symcon-PHPModul-red.svg)](https://www.symcon.de/service/dokumentation/entwicklerbereich/sdk-tools/sdk-php/)
[![Module Version](https://img.shields.io/badge/dynamic/json?url=https%3A%2F%2Fraw.githubusercontent.com%2FNall-chan%2FCaller_ID_Reverse_Search%2Frefs%2Fheads%2Fmaster%2Flibrary.json&query=%24.version&label=Modul%20Version&color=blue)]()
[![Symcon Version](https://img.shields.io/badge/dynamic/json?url=https%3A%2F%2Fraw.githubusercontent.com%2FNall-chan%2FCaller_ID_Reverse_Search%2Frefs%2Fheads%2Fmaster%2Flibrary.json&query=%24.compatibility.version&suffix=%3E&label=Symcon%20Version&color=green)](https://www.symcon.de/de/service/dokumentation/installation/migrationen/v80-v81-q3-2025/)  
[![License](https://img.shields.io/badge/License-CC%20BY--NC--SA%204.0-green.svg)](https://creativecommons.org/licenses/by-nc-sa/4.0/)
[![Check Style](https://github.com/Nall-chan/Caller_ID_Reverse_Search/workflows/Check%20Style/badge.svg)](https://github.com/Nall-chan/Caller_ID_Reverse_Search/actions) [![Run Tests](https://github.com/Nall-chan/Caller_ID_Reverse_Search/workflows/Run%20Tests/badge.svg)](https://github.com/Nall-chan/Caller_ID_Reverse_Search/actions)  
[![PayPal.Me](https://img.shields.io/badge/PayPal-Me-lightblue.svg)](../README.md#spenden)
[![Wunschliste](https://img.shields.io/badge/Wunschliste-Amazon-ff69fb.svg)](../README.md#spenden)  

# Rückwärtssuche - Das Örtliche <!-- omit in toc -->  

Eine Rückwärtssuche welche den Dienst von Das Örtliche verwendet.  

## Inhaltsverzeichnis <!-- omit in toc -->  

- [1. Funktionsumfang](#1-funktionsumfang)
- [2. Voraussetzungen](#2-voraussetzungen)
- [3. Software-Installation](#3-software-installation)
- [4. Einrichten der Instanzen in IP-Symcon](#4-einrichten-der-instanzen-in-ip-symcon)
- [5. PHP-Befehlsreferenz](#5-php-befehlsreferenz)

## 1. Funktionsumfang

- Stellt eine Funktion bereit um über eine Rufnummer einen Namen zu ermitteln.  

## 2. Voraussetzungen

- IP-Symcon ab Version 8.1

## 3. Software-Installation

- Über den Module Store das 'Rückwärtssuche'-Modul installieren.  

## 4. Einrichten der Instanzen in IP-Symcon

- Unter `Instanz hinzufügen` kann das `Rückwärtssuche Das Örtliche`-Modul mithilfe des Schnellfilters gefunden werden.  
- Weitere Informationen zum Hinzufügen von Instanzen in der [Dokumentation der Instanzen](https://www.symcon.de/service/dokumentation/konzepte/instanzen/#Instanz_hinzufügen)

## 5. PHP-Befehlsreferenz

```php
boolean|string CIRS_GetName(integer $InstanzID, string $Number);
```

Versucht den Namen der unter $Number übergebenen Telefonnummer zu ermitteln.  
Im Fehlerfall, oder wenn kein Eintrag gefunden wurde, wird `false` zurück gegeben.

Beispiel:  

```php
echo CIRS_GetName(12345,'+4945130500511');
```  

---

```php
true CIRS_ClearCache(integer $InstanzID);
```

Löscht den Cache der Instanz.  

Beispiel:  

```php
CIRS_ClearCache(12345);
```
