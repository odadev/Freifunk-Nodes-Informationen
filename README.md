# Freifunk Nodes Informationen
Dieses Projekt soll eine Lösung zur webbasierten Darstellung der nodes.json sein.
Dies soll mit sämtlichen nodes.json funktionieren, sodass diese Anwendung von sämtlichen Communities verwendet werden kann.

Außerdem soll in Zukunft die Ermittlung von weiteren Informationen möglich sein.
* Routerauslastung
* Welcher Router hat einen eigenen uplink?
* Router-Abhängikeiten (Wer masht mit wem und wer ist von wem abhänhängig [eigener Uplink oder nicht])
* ...

## Aktueller Stand
* **Bisher ist es nur eine bessere Darstellung der nodes.json**
* Nodes werden aus nodes.json ausgelesen
* Nodes werden als Objekte in PHP erzeugt
* Nodes werden in einere Tabelle aufgelistet
* Zusatzinformationen wie beispielsweise die Anzahl der Nodes oder die Anzahl der aktuell verbundenen Clients werden angezeigt

## TODO
* Diese Anwendung soll für sämtliche Communities laufen - also mit verschiedenen JSON-Dateien
 * Eventuell sämtliche in die Datenbank mit Name und Link zu JSON eintragen + Auswahlmöglichkeit geben um selber eine JSON per Link einzugeben
* Daten in die Datenbankspeichern um eine Auswertung über längere Zeit zu ermöglichen
* Weitere Informationen zu den Nodes in die Node-Objekte speichern
* Nur mit den Node-Objekten arbeitet statt einzelne Informationen eines Nodes zwischenzuspeichern (siehe Datei tables/nodes.php)
* Eine bessere Struktur ausdenken (Order und Dateien)
* uvm.

## Links
* Link zum Projekt: [Freifunk Nodes Informationen](http://timojeske.de/odadev/FreifunkNodesInformationen/)