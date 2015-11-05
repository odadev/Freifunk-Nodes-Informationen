<?php
require_once 'database.php';

class Node_Statistics_Model {
    
    private $db;
    
    /**
     * Query zum Herausholen der Anzahl an CLients und den Onlinestatus aus der DB
     */
    private static $query_getNodeClientinformation = "
            SELECT 
                    ROUND(AVG(CLIENTS)) AS CLIENTS, 
                    CONCAT(
                        YEAR(TIMESTAMP), 
                        MONTH(TIMESTAMP), 
                        DAY(TIMESTAMP), 
                        HOUR(TIMESTAMP)
                    ),  
                    TIMESTAMP, 
                    STATE 
            FROM 
                    node_clients_live 
            WHERE 
                    NODE_ID = :node_id 
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
    
     private static $query_getNodeHostnameByID = "
            SELECT 
                    HOSTNAME
            FROM 
                    node 
            WHERE 
                    ID = :node_id 
        ";
    
    /**
     * Statement zum Herausholen der Anzahl an CLients und den Onlinestatus aus der DB
     */
    private $stmt_getNodeClientinformation;
    
    private $stmt_getNodeHostnameByID;
    
    function __construct() {
        $this->db = Database::getInstance();
       
        $this->stmt_getNodeClientinformation = $this->db->prepare(self::$query_getNodeClientinformation);
        $this->stmt_getNodeHostnameByID = $this->db->prepare(self::$query_getNodeHostnameByID);
    }
    
    function getNodeClientInformationFromDB($node_id, $interval) {
        $this->stmt_getNodeClientinformation->bindParam(':node_id', $node_id);
        $this->stmt_getNodeClientinformation->bindValue(':interval', $interval);
                
        $this->stmt_getNodeClientinformation->execute();
        return $this->stmt_getNodeClientinformation->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function getNodeHostnameByID($node_id) {
        $this->stmt_getNodeHostnameByID->bindParam(':node_id', $node_id);
                
        $this->stmt_getNodeHostnameByID->execute();
        $array = $this->stmt_getNodeHostnameByID->fetch();
        
        return $array['HOSTNAME'];
    }
}