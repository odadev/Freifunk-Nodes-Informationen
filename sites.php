<?php

switch($url) {
    case 'index':
        
        // PHP-Dateien laden
        require 'config/paths.php';
        require 'lib/node.php';
        require 'lib/nodemanager.php';
        
        // Seite laden
        require_once 'pages/dashboard.php'; 
    break;

    case 'statistic-offline':
        
        // PHP-Dateien laden
        require_once 'lib/node_statistics_model.php';
        
        // Seite laden
        require_once 'pages/statistic_offline.php'; 
    break;

    case 'statistic-node-clients':
        
        // PHP-Dateien laden
        require_once 'lib/node_statistics_model.php';
        
        // Seite laden
        require_once 'pages/statistic_node.php'; 
    break;
}
