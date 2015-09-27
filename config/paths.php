<?php if(!'__IN_SITE__') { die(); }

// Später aus der Datenbank holen
define('__JSON_NODES_PATH__', 'http://api.freifunk-niersufer.de/mo/nodes.json');

// Freifunk Rheinland JSON zum Testen
//define('__JSON_NODES_PATH__', 'http://ffmap.freifunk-rheinland.net/nodes.json');

// Andere JSON (Freifunk Krefeld) als Beispiel für die Unabhängigkeit
//define('__JSON_NODES_PATH__', 'http://api.freifunk-niersufer.de/kr/nodes.json');