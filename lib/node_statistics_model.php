<?php
require_once 'database.php';

/**
 * Klasse für sämtliche Abfragen und Daten zu Statistiken
 * 
 * todo: Singleton machen!
 */
class Node_Statistics_Model {
    
    private $db;
    
    /**
     * Query zum Herausholen der Anzahl an Clients und den Onlinestatus aus der DB
     */
    private static $query_getNodeClientinformation = "
            SELECT 
                    ROUND(AVG(CLIENTS)) AS CLIENTS, 
                    MAX(CLIENTS) AS CLIENTS_MAX,
                    MIN(CLIENTS) AS CLIENTS_MIN,
                    CONCAT(
                        DAY(TIMESTAMP), 
                        '.',
                        MONTH(TIMESTAMP), 
                        '.',
                        YEAR(TIMESTAMP), 
                        ' ',     
                        HOUR(TIMESTAMP),
                        ' - ',
                        HOUR(DATE_ADD(TIMESTAMP, INTERVAL 1 HOUR))
                    ) as TIMESTAMP_HOUR,
                    STATE 
            FROM 
                    node_clients_live 
            WHERE 
                    NODE_ID LIKE :node_id 
                    AND TIMESTAMP >= DATE_SUB(NOW(), INTERVAL :interval HOUR) 
            GROUP BY 
                    CONCAT(
                        YEAR(TIMESTAMP), 
                        MONTH(TIMESTAMP), 
                        DAY(TIMESTAMP), 
                        HOUR(TIMESTAMP)
                    ) 
            ORDER BY
                    TIMESTAMP ASC
    ";
    
    /**
     * Query zum Herausholen der Anzahl an Clients und den Onlinestatus aus der DB
     * Nur einen Wert pro Tag
     */
    private static $query_getNodeClientinformationOneDay = "
            SELECT 
                    ROUND(AVG(CLIENTS)) AS CLIENTS, 
                    MAX(CLIENTS) AS CLIENTS_MAX,
                    MIN(CLIENTS) AS CLIENTS_MIN,
                    CONCAT(
                        DAY(TIMESTAMP), 
                        '.',
                        MONTH(TIMESTAMP), 
                        '.',
                        YEAR(TIMESTAMP), 
                        ' '
                    ) as TIMESTAMP_HOUR,
                    -- ja TIMESTAMP_HOUR, weil das PHP-Script so nicht umgeschrieben werden muss
                    STATE 
            FROM 
                    node_clients_live 
            WHERE 
                    NODE_ID LIKE :node_id
                    AND TIMESTAMP >= DATE_SUB(NOW(), INTERVAL :interval HOUR) 
            GROUP BY 
                    CONCAT(
                        YEAR(TIMESTAMP), 
                        MONTH(TIMESTAMP), 
                        DAY(TIMESTAMP)
                    ) 
            ORDER BY
                    TIMESTAMP ASC
    ";
    
    /**
     * Query zum herausholen des Hostnames eines Nodes anhand seiner ID
     */
    private static $query_getNodeHostnameByID = "
            SELECT 
                    HOSTNAME
            FROM 
                    node 
            WHERE 
                    ID = :node_id 
    ";
    
    /**
     * Liste mit allen Nodes, die seit n Stunden nicht mehr online waren
     */
    private static $query_getOfflineNodesNHours = "
            SELECT 
                    ID, 
                    HOSTNAME, 
                    NODE_TIMESTAMP,
                    LAST_SEEN, 
                    IP_EXTERN,
                    FIRMWARE_RELEASE,
                    FIRMWARE_BASE,
                    DATEDIFF(NOW(),LAST_SEEN) as DAYS_OFFLINE
            FROM 
                    node
            WHERE 
                    LAST_SEEN < DATE_SUB(NOW(), INTERVAL :hours HOUR)
            ORDER BY 
                    NODE_TIMESTAMP DESC, 
                    LAST_SEEN DESC, 
                    ID DESC, 
                    HOSTNAME ASC;
    ";

    /**
     * Query zum herausholen aller Nodes
     */
    private static $query_getNodes = "
            SELECT
                    ID,
                    HOSTNAME
            FROM
                    node
    ";
    
    /**
     * Statement zum Herausholen der Anzahl an Clients und den Onlinestatus aus der DB
     */
    private $stmt_getNodeClientinformation;
    
    /**
     * Statement zum Herausholen der Anzahl an Clients und den Onlinestatus aus der DB
     * Nur einen Wert pro Tag
     */
    private $stmt_getNodeClientinformationOneDay;
    
    /**
     * Statement für die Liste mit allen Nodes, die seit n Stunden nicht mehr online waren
     */
    private $stmt_getNodeHostnameByID;
    
    /**
     * Statement für die Liste mit allen Nodes, die seit n Stunden nicht mehr online waren
     */
    private $stmt_getOfflineNodesNHours;

    /**
     * Statement das Herausholen aller Nodes
     */
    private $stmt_getNodes;

    function __construct() {
        $this->db = Database::getInstance();
       
        $this->stmt_getNodeClientinformation = $this->db->prepare(self::$query_getNodeClientinformation);
        $this->stmt_getNodeClientinformationOneDay = $this->db->prepare(self::$query_getNodeClientinformationOneDay);
        $this->stmt_getNodeHostnameByID = $this->db->prepare(self::$query_getNodeHostnameByID);
        $this->stmt_getOfflineNodesNHours = $this->db->prepare(self::$query_getOfflineNodesNHours);
        $this->stmt_getNodes = $this->db->prepare(self::$query_getNodes);
    }
    
    /**
     * Gibt alle Informationen über einen gewissen Zeitraum von einem Node zurück
     * 
     * @param   string  $node_id
     * @param   int     $interval
     * @return  type
     */
    function getNodeClientInformationFromDB($node_id, $interval) {
        
        /*
         * todo: das mit den zwei verschiedenen Queries und Statements muss noch
         * verbessert werden.
        */
        if($interval > 2160) {//2160) { // mehr als 3 Monate, dann nur einen Wert pro Tag
            $this->stmt_getNodeClientinformationOneDay->bindParam(':node_id', $node_id);
            $this->stmt_getNodeClientinformationOneDay->bindValue(':interval', $interval);
            $this->stmt_getNodeClientinformationOneDay->execute();
            return $this->stmt_getNodeClientinformationOneDay->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $this->stmt_getNodeClientinformation->bindParam(':node_id', $node_id);
            $this->stmt_getNodeClientinformation->bindValue(':interval', $interval);
            $this->stmt_getNodeClientinformation->execute();
            return $this->stmt_getNodeClientinformation->fetchAll(PDO::FETCH_ASSOC);
        }   
            
        
    }
    
    /**
     * Gibt es Hostname zu einer NodeID zurück
     * 
     * @param   string    $node_id
     * @return  string   Hostname
     */
    function getNodeHostnameByID($node_id) {
        $this->stmt_getNodeHostnameByID->bindParam(':node_id', $node_id);
                
        $this->stmt_getNodeHostnameByID->execute();
        $array = $this->stmt_getNodeHostnameByID->fetch();
        
        return $array['HOSTNAME'];
    }
    
    /**
     * Gibt eine Liste mit allen Nodes, die seit n Stunden nicht mehr online waren
     * zurück
     * 
     * @param  $hours
     */
    function getOfflineNodesNHours($hours) {
        $this->stmt_getOfflineNodesNHours->bindParam(':hours', $hours);
        
        $this->stmt_getOfflineNodesNHours->execute();
        return $this->stmt_getOfflineNodesNHours->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Gibt alle Nodes zurück (im Moment nur ID und Hostname)
     *
     * @return mixed
     */
    function getNodes() {
        $this->stmt_getNodes->execute();
        return $this->stmt_getNodes->fetchAll(PDO::FETCH_ASSOC);
    }
}