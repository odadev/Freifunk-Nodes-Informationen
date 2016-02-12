# Freifunk Nodes Informationen
Dieses Projekt soll eine Lösung zur webbasierten Darstellung der nodes.json sein.
Dies soll mit sämtlichen nodes.json funktionieren, sodass diese Anwendung von sämtlichen Communities verwendet werden kann.

Natürlich gibt es die aktuellen Daten auch in der Freifunk Map. Einige Communities nutzen auch Grafana und können somit auch die Daten in Langzeit darstellen.
Diese Webanwendung soll allerdings einige Daten einfacher und übersichtlicher darstellen, sodass man alles an einer Stelle findet und,je nach Wunsch, auch andere Informationen anhand der gespeicherten Informationen angezeigen kann.

Außerdem soll in Zukunft die Ermittlung von weiteren Informationen möglich sein:
* Routerauslastung
* Welcher Router hat einen eigenen uplink?
* Router-Abhängikeiten (Wer masht mit wem und wer ist von wem abhänhängig [eigener Uplink oder nicht])
* Traffic
* ...

## Aktueller Stand
* **Bisher ist es nur eine bessere Darstellung der nodes.json**
* **12.02.2016** Menü eingebaut, die Struktur verbessert und unsinnige Dateien gelöscht
* **12.02.2016** Neue Statistik: Anzeige aller Nodes, die länger als 3 Tage offline sind
* **12.02.2016** Clientstatistik angepasst: wenn mehr als 3 Monate an Daten geladen werden soll, dann hole einen tagesbasierten- und keinen stundenbasierten Wert mehr
* **12.02.2016** noch weitere Kleinigkeiten: Sorry, ich hätte eher commiten sollen und nicht alles zusammen...
* **09.11.2015: Nun kann man auf den Hostname in der Tabelle klicken und bekommt eine Langzeitstatistik der Clients angezeigt (Mittelwert pro Stunde, obwohl mehr Daten in DB)**
* Nodes werden aus nodes.json ausgelesen
* Nodes werden als Objekte in PHP erzeugt
* Nodes werden in einere Tabelle aufgelistet
* Zusatzinformationen wie beispielsweise die Anzahl der Nodes oder die Anzahl der aktuell verbundenen Clients werden angezeigt
* Anzahl aller Nodes + Anzahl davon online und offline + Clients, die gerade insgesamt verbunden sind + Neuster Node + Am längsten Online (Node) werden angezeigt
* In der Tabelle können die Spalten über Klick auf einen "Link" synamisch ein- und ausgeblendet werden
* Der Onlinestatus des Nodes wird über einen farbigen Kreis (grün: online, rot: offline) angezeigt
* Jede Spalte kann einzeln durchsucht werden (befindet sich im Footer einer Spalte)
 * Bei einigen Spalten nicht sehr sinnvoll bei einer Spalte wie beispielsweise das Modell wäre eine Selectbox sinnvoller! (Siehe TODO)
* 09.11.2015: Bei Klick auf Hostname öffnet sich eine neue Seite, die die Langzeitstatistik der Clients auf diesen Router anzeigt
 * Dafür werden die Daten aus der Datenbank genutzt
 * Zusätzlich werden noch einige Werte angezeigt - kann natürlich noch bearbeitet werden. Es handelt sich hierbei erst einmal nur um Beispiele (mit echten Daten)

## TODO
* Diese Anwendung soll für sämtliche Communities laufen - also mit verschiedenen JSON-Dateien
 * ~~Eventuell sämtliche Communities in die Datenbank mit Name und Link zu JSON eintragen + Auswahlmöglichkeit geben um selber eine JSON per Link einzugeben~~
 * Allerdings würde das ein riiiiiiiesen Datenberg bedeuten, für den man selber zuständig ist. Somit sollte jede Community eine eigene Version aufsetzen
* ~~Daten in die Datenbank speichern um eine Auswertung über längere Zeit zu ermöglichen~~ VORERST ERLEDIGT (muss noch um weitere Daten ergänzt werden)
* Weitere Informationen zu den Nodes in die Node-Objekte speichern
* Nur mit den Node-Objekten arbeitet statt einzelne Informationen eines Nodes zwischenzuspeichern (siehe Datei tables/nodes.php)
* Eine bessere Struktur ausdenken (Order und Dateien)
 * **12.02.2016** etwas verbessert, aber MVC wäre wünschenswert
* Einzelne Spalten durchsuchen: Bei einigen entfernen und bei anderen (Beispiel: Modell) eine Selectbox einbinden statt ein Textfeld
* Langzeit-Clientstatistik erweitern
 * weitere Informationen wie beispielsweise die Trafficauslastung als Diagramm darstellen
 * Donut-Chart(s)(?!) für die prozentuale online- und offline-Zeit gesamt und letzte 24 Stunden erstellen
 * Online- und offline-Status im Diagramm anzeigen. Problem: Im Moment sind es gemittelte Werte pro Stunde - das sollte natürlich nicht mit dem Onlinestatus geschehen!!! 
  * eventuell Prozent online / offline für den Wert der Stunde (bzw. Tag)
 * ...
* uvm.

## Links
* Link zum Projekt: [Freifunk Nodes Informationen](http://timojeske.de/odadev/FreifunkNodesInformationen/)
* Link zum Projekt, welches für das Einfügen der Daten zuständig ist: [Freifunk Nodes To Database](https://github.com/odadev/Freifunk-Nodes-To-Database/) 