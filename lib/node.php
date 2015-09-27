<?php if(!'__IN_SITE__') { die(); }

/**
 * Repräsentiert einen Freifunk-Node
 * 
 * Allerdings nicht mit allen Daten. Diese Klasse kann und soll natürlich
 * entsprechend erweitert werden!
 * 
 * @author Timo Jeske <timo@jeske.email>
 */
class Node {
    
    /**
     * ID des Nodes
     */
    private $nodeID;
    
    /**
     * MAC-Adresse des Nodes
     */
    private $mac;
    
    /**
     * Array mit den IPv6-Adressen des Nodes
     */
    private $addresses = array();
    
    /**
     * Hostname des Nodes
     */
    private $hostname;
    
    /**
     * Model des Nodes
     */
    private $model;
    
    /**
     * Array mit den Firmware-Informationen "release" und "base"
     */
    private $firmware;
    
    /**
     * Uptime des Nodes (Zeit, die der Node schon online ist) in Minuten
     */
    private $uptime;
    
    /**
     * Auslastung des Arbeitsspeichers
     */
    private $memoryUsage;
    
    /**
     * Anzahl der verbundenen Clients
     */
    private $clients;
    
    /**
     * LoadAVG des Nodes
     */
    private $loadavg;
    
    /**
     * Array mit den kompletten Trafficinformationen des Nodes
     * 
     *  - forward
     *  - rx
     *  - mgmt_tx
     *  - tx
     *  - mgmt_rx
     */
    private $traffic = array();
    
    /**
     * Wann war der Node zuletzt online?
     */
    private $lastSeen;
    
    /**
     * Wann ist der Router online gegangen?
     */
    private $firstSeen;
    
    /**
     * Online oder nicht?
     */
    private $online;
    
    public function __construct() {

    }
    
    public function getMac() {
        return $this->mac;
    }
    
    public function getHostname() {
        return $this->hostname;
    }

    public function getModel() {
        return $this->model;
    }

    public function getUptime() {
        return $this->uptime;
    }

    public function getClients() {
        return $this->clients;
    }

    public function getTraffic() {
        return $this->traffic;
    }

    public function getLastSeen() {
        return $this->lastSeen;
    }

    public function getFirstSeen() {
        return $this->firstSeen;
    }

    public function setMac($mac) {
        $this->mac = $mac;
    }

    public function setHostname($hostname) {
        $this->hostname = $hostname;
    }

    public function setModel($model) {
        $this->model = $model;
    }

    public function setUptime($uptime) {
        $this->uptime = $uptime;
    }

    public function setClients($clients) {
        $this->clients = $clients;
    }

    public function setTraffic($traffic) {
        $this->traffic = $traffic;
    }

    public function setLastSeen($lastseen) {
        $this->lastSeen = $lastseen;
    }

    public function setFirstSeen($firstseen) {
        $this->firstSeen = $firstseen;
    }
    
    public function getAddresses() {
        return $this->addresses;
    }

    public function getFirmware() {
        return $this->firmware;
    }

    public function setAddresses($addresses) {
        $this->addresses = $addresses;
    }

    public function setFirmware($firmware) {
        $this->firmware = $firmware;
    }
    
    public function getNodeID() {
        return $this->nodeID;
    }

    public function setNodeID($nodeID) {
        $this->nodeID = $nodeID;
    }

    public function getLoadavg() {
        return $this->loadavg;
    }

    public function setLoadavg($loadavg) {
        $this->loadavg = $loadavg;
    }

    public function getMemoryUsage() {
        return $this->memoryUsage;
    }

    public function setMemoryUsage($memoryUsage) {
        $this->memoryUsage = $memoryUsage;
    }

    public function getOnline() {
        return $this->online;
    }

    public function setOnline($online) {
        $this->online = $online;
    }

}