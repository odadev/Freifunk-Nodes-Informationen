<?php
    error_reporting(E_ALL);
    define('__IN_SITE__', true);

    // Einbinden der Konfigurationsdateien
    require 'config/paths.php';

    // Einbinden der Bibliotheken
    require 'lib/node.php';
    require 'lib/nodemanager.php';
    
    // NodeManager-Objekt mit allen Datein zu den Nodes
    $nodeManager = new NodeManager();
    
    // Array mit allen Node-Objekten
    $nodes = $nodeManager->getAllNodes();
?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8" />
        <title>Freifunk Moers Nodes</title>
        
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="css/AdminLTE.min.css" />
        <link rel="stylesheet" href="css/skins/skin-blue.min.css" />
        <link rel="stylesheet" href="css/dataTables.min.css" />
        <link rel="stylesheet" href="css/responsive.dataTables.min.css" />
        <link rel="stylesheet" href="css/own.css" />
        
        <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="js/dataTables.bootstrap.min.js"></script>
        <script type="text/javascript" src="js/dataTables.responsive.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/app.min.js"></script>
    </head>
    <body class="background-grey"> 
        <section class="content">
            <?php
                include 'pages/dashboard.php'
            ?>
        </section>
        <footer>
            <?php echo "Stand: " . $nodeManager->getTimestamp(); ?>
        </footer>
    </body>
</html>