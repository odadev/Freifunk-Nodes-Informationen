# Freifunk Nodes Informationen
Dieses Projekt soll eine Lösung zur webbasierten Darstellung der nodes.json sein.
Dies soll mit sämtlichen nodes.json funktionieren, sodass diese Anwendung von sämtlichen Communities verwendet werden kann.

Außerdem soll in Zukunft die Ermittlung von weiteren Informationen möglich sein:
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
* Anzahl aller Nodes + Anzahl davon online und offline + Clients, die gerade insgesamt verbunden sind + Neuster Node + Am längsten Online (Node) werden angezeigt
* In der Tabelle können die Spalten über Klick auf einen "Link" synamisch ein- und ausgeblendet werden
* Der Onlinestatus des Nodes wird über einen farbigen Kreis (grün: online, rot: offline) angezeigt
* Jede Spalte kann einzeln durchsucht werden (befindet sich im Footer einer Spalte)
 * Bei einigen Spalten nicht sehr sinnvoll bei einer Spalte wie beispielsweise das Modell wäre eine Selectbox sinnvoller! (Siehe TODO)

## TODO
* Diese Anwendung soll für sämtliche Communities laufen - also mit verschiedenen JSON-Dateien
 * Eventuell sämtliche Communities in die Datenbank mit Name und Link zu JSON eintragen + Auswahlmöglichkeit geben um selber eine JSON per Link einzugeben
* Daten in die Datenbankspeichern um eine Auswertung über längere Zeit zu ermöglichen
* Weitere Informationen zu den Nodes in die Node-Objekte speichern
* Nur mit den Node-Objekten arbeitet statt einzelne Informationen eines Nodes zwischenzuspeichern (siehe Datei tables/nodes.php)
* Eine bessere Struktur ausdenken (Order und Dateien)
* Einzelne Spalten durchsuchen: Bei einigen entfernen und bei anderen (Beispiel: Modell) eine Selectbox einbinden statt ein Textfeld
* uvm.

## Links
* Link zum Projekt: [Freifunk Nodes Informationen](http://timojeske.de/odadev/FreifunkNodesInformationen/)