<?php

/**
 * Klasse zur Verwaltung der Nodes
 * 
 * Noch macht sie nicht viel, kann aber nach belieben ausgebaut werden
 * 
 * @author Timo Jeske <timo@jeske.email>
 */
class NodeManager {
    
    /**
     * Array, welches alle Nodes beinhaltet
     */
    private $allNodes = array();
    
    /**
     * Zeitpunkt des Datenbestandes (Von wann die Daten sind)
     */
    private $timestamp;
    
    /**
     * Daten aus der JSON-Datei zu den Nodes
     */
    private $jsonData;
    
    public function __construct() {
        $this->getNodesFromServer();
        $this->createNewNodes();
        $this->createTimestamp();
    }
    
    private function createTimestamp() {
        // Zeigt an, von wann die Daten, die angezeigt werden, sind.
        $this->timestamp = date("d.m.Y H:i", strtotime($this->jsonData["timestamp"])+(60*60*2));
    }
    
    private function getNodesFromServer() {
        // Holen der JSON-Datei + "Decodieren" zum assoziativem Array
        $seite = file_get_contents(__JSON_NODES_PATH__);
        $this->jsonData = json_decode($seite, true);
    }
    
    private function createNewNodes() {        
        $nodes = array();
        $nodes2 = array();
        $zaehler = 0;
        foreach($this->jsonData["nodes"] as $node) {
            // Erhalt aller Informationen eines Nodes
            $nodes[]= current(array_slice($this->jsonData["nodes"], $zaehler, 1));

            // Erstellen eines neuen Node-Objektes und füllen dieses
            $nodeObject = new Node();
            if(isset($nodes[$zaehler]["nodeinfo"]["node_id"])) {
                $nodeObject->setNodeID($nodes[$zaehler]["nodeinfo"]["node_id"]);
            }
            if(isset($nodes[$zaehler]["nodeinfo"]["network"]["mac"])) {
                $nodeObject->setMac($nodes[$zaehler]["nodeinfo"]["network"]["mac"]);
            }
            if(isset($nodes[$zaehler]["nodeinfo"]["network"]["addresses"])) {
                $nodeObject->setAddresses($nodes[$zaehler]["nodeinfo"]["network"]["addresses"]);
            }
            if(isset($nodes[$zaehler]["nodeinfo"]["hostname"])) {
                $nodeObject->setHostname($nodes[$zaehler]["nodeinfo"]["hostname"]);
            }
            if(isset($nodes[$zaehler]["nodeinfo"]["hardware"]["model"])) {
                $nodeObject->setModel($nodes[$zaehler]["nodeinfo"]["hardware"]["model"]);
            }
            if(isset($nodes[$zaehler]["nodeinfo"]["software"]["firmware"])) {
                $nodeObject->setFirmware($nodes[$zaehler]["nodeinfo"]["software"]["firmware"]);
            }
            if(isset($nodes[$zaehler]["statistics"]["uptime"])) {
                $nodeObject->setUptime($nodes[$zaehler]["statistics"]["uptime"]);
            }
            if(isset($nodes[$zaehler]["statistics"]["memory_usage"])) {
                $nodeObject->setMemoryUsage($nodes[$zaehler]["statistics"]["memory_usage"]);
            }
            if(isset($nodes[$zaehler]["statistics"]["clients"])) {
                $nodeObject->setClients($nodes[$zaehler]["statistics"]["clients"]);
            }
            if(isset($nodes[$zaehler]["statistics"]["loadavg"])) {
                $nodeObject->setLoadavg($nodes[$zaehler]["statistics"]["loadavg"]);
            }
            if(isset($nodes[$zaehler]["statistics"]["traffic"])) {
                $nodeObject->setTraffic($nodes[$zaehler]["statistics"]["traffic"]);
            }
            if(isset($nodes[$zaehler]["lastseen"])) {
                $nodeObject->setLastSeen(date("d.m.Y H:i", strtotime($nodes[$zaehler]["lastseen"])+(60*60*2)));
            }
            if(isset($nodes[$zaehler]["firstseen"])) {
                $nodeObject->setFirstSeen(date("d.m.Y H:i", strtotime($nodes[$zaehler]["firstseen"])+(60*60*2)));
            }
            if(isset($nodes[$zaehler]["flags"]["online"])) {
                if($nodes[$zaehler]["flags"]["online"] == "true") {
                    $nodeObject->setOnline(true);
                } else {
                    $nodeObject->setOnline(false);
                }
                
            }

            // Node zum Array aller Nodes hinzufügen
            $nodes2[] = $nodeObject;
            $zaehler++;
        }
        $this->setAllNodes($nodes2);
    }
    
    public function getAllNodes() {
        return $this->allNodes;
    }

    public function setAllNodes($allNodes) {
        $this->allNodes = $allNodes;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }
}