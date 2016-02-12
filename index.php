<?php
    error_reporting(E_ALL);
    define('__IN_SITE__', true);

    // Einbinden der Bibliotheken
    require 'lib/dater.php';
    
    if(isset($_GET['url'])) {
        $url = htmlspecialchars($_GET['url']);
    } else {
        $url = "index";
    }
?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8" />
        <title>Freifunk Moers NodeInformation</title>
        
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        
        <!-- todo: noch doof gelöst. Muss dringend anders gemacht werden! -->
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/font-awesome.min.css" />
        <link rel="stylesheet" href="css/AdminLTE.min.css" />
        <link rel="stylesheet" href="css/skins/skin-purple-light.min.css" />
        <link rel="stylesheet" href="css/dataTables.min.css" />
        <link rel="stylesheet" href="css/responsive.dataTables.min.css" />
        <link rel="stylesheet" href="css/buttons.dataTables.min.css" />
        <link rel="stylesheet" href="css/c3.min.css" />
        <link rel="stylesheet" href="css/own.css" />
        
        <?php
        if($url == "statistic-node-clients") {
            echo '<link rel="stylesheet" href="css/node_statistics.css" />';
        }
        ?>
        
        <script type="text/javascript" src="js/jquery2.min.js"></script>
        <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="js/dataTables.bootstrap.min.js"></script>
        <script type="text/javascript" src="js/dataTables.responsive.min.js"></script>
        <script type="text/javascript" src="js/dataTables.numericComma.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/app.min.js"></script>
        
        <script type="text/javascript" src="js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="js/buttons.print.min.js"></script>
        <script type="text/javascript" src="js/jszip.min.js"></script>
        <script type="text/javascript" src="js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="js/dataTables.select.min.js"></script>
        <script type="text/javascript" src="js/moment-with-locales.js"></script>
        <script type="text/javascript" src="js/datetime-moment.js"></script>
        
        <script type="text/javascript" src="js/d3js/d3.min.js"></script>
        <script type="text/javascript" src="js/c3js/c3.min.js"></script>
    </head>
    <body class="fixed hold-transition skin-purple-light layout-top-nav background-grey"> 
        <div class="wrapper">
            <header class="main-header">
              <nav class="navbar navbar-static-top">
                <div class="container">
                  <div class="navbar-header">
                    <a href="index.php" class="navbar-brand"><b>Freifunk</b> NodeInformation</a>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                      <i class="fa fa-bars"></i>
                    </button>
                  </div>
                  <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                    <ul class="nav navbar-nav">
                      <li><a href="index.php">Dashboard</a></li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Statistiken <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="index.php?url=statistic-offline">Länger als 3 Tage offline</a></li>
                            <li><a href="index.php?url=statistic-offline&showAll=true">Länger als 3 Tage offline - Alle</a></li>
                            <!--<li><a href="index.php?url=statistic-node-clients">Node - Clientstatistik</a></li>-->
                        </ul>
                      </li>
                    </ul>
                  </div>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li><a target="_blank" href="https://github.com/odadev">made by Timo Jeske</a></li>
                        <li><a target="_blank" href="https://github.com/odadev/Freifunk-Nodes-Informationen"><i class="fa fa-github"></i></a></li>
                    </ul>
                </div>
                </div>
              </nav>
            </header>
            <div class="content-wrapper">
                <div class="container">
                    <?php
                        include 'sites.php'
                    ?>
                </div>
            </div>
            <footer class="main-footer">
                <div class="container">
                    <div class="pull-left">
                        made by <a target="_blank" href="https://github.com/odadev">Timo Jeske</a> for <a target="_blank" href="http://freifunk-moers.de/">Freifunk Moers</a>
                    </div>
                    <div class="pull-right">
                        <a target="_blank" href="https://github.com/odadev/Freifunk-Nodes-Informationen">view source on <i class="fa fa-github"></i></a>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>