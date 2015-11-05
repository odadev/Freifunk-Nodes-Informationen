<?php
    define('__IN_SITE__', true);
    require_once 'lib/node_statistics_model.php';
    $node_statistics_model = new Node_Statistics_Model();
    
     $node_id = $_GET['nodeID'];
?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8" />
        <title>Freifunk Moers Node Clientstatistik</title>
        
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        
        <!-- Load c3.css -->
        <link href="js/c3js/c3.css" rel="stylesheet" type="text/css">
        
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/AdminLTE.min.css" />
        <link rel="stylesheet" href="css/skins/skin-blue.min.css" />
        
        <!-- Load own css -->
        <link href="css/node_statistics.css" rel="stylesheet" type="text/css">
        
        <!-- Load d3.js and c3.js -->
        <script src="js/d3js/d3.min.js" charset="utf-8"></script>
        <script src="js/c3js/c3.min.js"></script>
    </head>
    <body>
        <?php
            // Kleine Überprüfung ob Variable gesendet und nodeID die richtige Länge.
            if(empty($node_id) || strlen($node_id) != 12) {
                echo "<div>Es wurde kein oder kein gültiger Node ausgewählt!</div>";
                die();
            }
            
            $node_statistics = $node_statistics_model->getNodeClientInformationFromDB($node_id, 9999999);
            $node_hostname = $node_statistics_model->getNodeHostnameByID($node_id);

            $infos_clients_x_axis = "";
            $infos_clients_values = "";
            $infos_clients_online = "";

            // Für später um die Werte etwas verdichtet darzustellen...
            //$infos_clients_values_tmp = array();
            $first = true;
            $count_values = 0;
            foreach($node_statistics as $timestamp) {
                if($first == false) {
                    $infos_clients_x_axis .= ", ";
                    $infos_clients_values .= ", ";
                    $infos_clients_online .= ", ";
                }
                $infos_clients_x_axis .= "'" . date("d.m.Y H:i:s", strtotime($timestamp['TIMESTAMP'])) . "'";
                $infos_clients_values .= "'" . $timestamp['CLIENTS'] . "'";

                $first = false;
                $count_values++;
            }

            echo "<h1>" . $node_hostname . " (" . $node_id . ")</h1>";
            echo "<div style='text-align: center; margin-bottom: 20px;'>";
                echo "Anzahl Werte (Stunden): " . $count_values;
            echo "</div>";
        ?>
        
        <div id="chart" style="width: 100%; height: 78vh;"></div>

        <script>
            var chart = c3.generate({
                bindto: '#chart',
                data: {
                  columns: [
                    ['Anzahl Clients', <?php echo $infos_clients_values; ?>],
                  ],
                   types: {
                        'Anzahl Clients': 'area',
                        'Online': 'scatter',
                    }
                },
                zoom: {
                    enabled: true
                },
                subchart: {
                    show: true
                },
                axis: {
                    x: {
                        extent: [<?php echo $count_values - 24; ?>, <?php echo $count_values; ?>],
                        type: 'category',
                        categories: [<?php echo $infos_clients_x_axis; ?>],
                        tick: {
                            count: 5,
                            width: 60
                        },
                        height: 100
                    },
                },
                grid: {
                    y: {
                        show: true
                    }
                }
            });
        </script>
    </body>
</html>