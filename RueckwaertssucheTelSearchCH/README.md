# Rückwärtssuche - search.CH <!-- omit in toc -->  
Eine Rückwärtssuche welche den Dienst von search.CH verwendet.  

### Inhaltsverzeichnis <!-- omit in toc -->  

- [1. Funktionsumfang](#1-funktionsumfang)
- [2. Vorraussetzungen](#2-vorraussetzungen)
- [3. Software-Installation](#3-software-installation)
- [4. Einrichten der Instanzen in IP-Symcon](#4-einrichten-der-instanzen-in-ip-symcon)
- [5. PHP-Befehlsreferenz](#5-php-befehlsreferenz)

### 1. Funktionsumfang

* Stellt eine Funktion bereit um über eine Rufnummer einen Namen zu ermitteln.  

### 2. Vorraussetzungen

- IP-Symcon ab Version 6.0

### 3. Software-Installation

* Über den Module Store das 'Rückwärtssuche'-Modul installieren.  

### 4. Einrichten der Instanzen in IP-Symcon

- Unter `Instanz hinzufügen` kann das `Rückwärtssuche search.CH`-Modul mithilfe des Schnellfilters gefunden werden.  
- Weitere Informationen zum Hinzufügen von Instanzen in der [Dokumentation der Instanzen](https://www.symcon.de/service/dokumentation/konzepte/instanzen/#Instanz_hinzufügen)


### 5. PHP-Befehlsreferenz

---
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
null CIRS_ClearCache(integer $InstanzID);
```
Löscht den Cache der Instanz.  

Beispiel:  
```php
CIRS_ClearCache(12345);
```
