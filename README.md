# FreifunkMoersRouterAuslastung
Dieses Projekt soll eine Lösung zur webbasierten Darstellung der Routerauslastung von Freifunk Moers sein.

## Aktueller Stand
* Nodes werden aus nodes.json ausgelesen
* Nodes werden als Objekte in PHP erzeugt
* Nodes werden in einere Tabelle aufgelistet
* Zusatzinformationen wie beispielsweise die Anzahl der Nodes oder die Anzahl der aktuell verbundenen Clients werden angezeigt

## TODO
* Daten in die Datenbankspeichern um eine Auswertung über längere Zeit zu ermöglichen
* Weitere Informationen zu den Nodes in die Node-Objekte speichern
* Nur mit den Node-Objekten arbeitet statt einzelne Informationen eines Nodes zwischenzuspeichern (siehe Datei tables/nodes.php)
* Eine bessere Struktur ausdenken (Order und Dateien)
* uvm.