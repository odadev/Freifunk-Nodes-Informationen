<section class="content">
    <div class="row">
        <?php   
            $nodeID = htmlspecialchars($_GET['nodeID']);

            // Kleine Überprüfung ob Variable gesendet und nodeID die richtige Länge.
            if(empty($nodeID) || strlen($nodeID) != 12) {
                echo "<div>Es wurde kein oder kein gültiger Node ausgewählt!</div>";
                die(); 
            }
            
            $nodeStatisticsModel = new Node_Statistics_Model();
            $hours = 9999999;
            $node_statistics = $nodeStatisticsModel->getNodeClientInformationFromDB($nodeID, $hours);
            $node_hostname = $nodeStatisticsModel->getNodeHostnameByID($nodeID);

            $infos_clients_x_axis = "";
            $infos_clients_values = "";
            $infos_clients_online = "";
            $infos_clients_max = "";
            $infos_clients_min = "";

            // Durchschnitt über den gesamten Zeitraum
            $infos_clients_values_total = array();
            $infos_clients_max_total = array();
            $infos_clients_min_total = array();

            // Für später um die Werte etwas verdichtet darzustellen...
            //$infos_clients_values_tmp = array();
            $first = true;
            $count_values = 0;
            $lasthour_clients_avg = array();
            $datetime_start = "";
            $datetime_end = "";

            foreach($node_statistics as $timestamp) {
                if($first == false) {
                    $infos_clients_x_axis .= ", ";
                    $infos_clients_values .= ", ";
                    $infos_clients_online .= ", ";
                    $infos_clients_max .= ", ";
                    $infos_clients_min .= ", ";
                } else {
                    $datetime_start = $timestamp['TIMESTAMP_HOUR'];
                }
                $infos_clients_x_axis .= "'" . $timestamp['TIMESTAMP_HOUR'] . "'";
                $infos_clients_values .= "'" . $timestamp['CLIENTS'] . "'";
                $infos_clients_max .= "'" . $timestamp['CLIENTS_MAX'] . "'";
                $infos_clients_min .= "'" . $timestamp['CLIENTS_MIN'] . "'";

                $infos_clients_values_total[] = $timestamp['CLIENTS'];
                $infos_clients_max_total[] = $timestamp['CLIENTS_MAX'];
                $infos_clients_min_total[] = $timestamp['CLIENTS_MIN'];

                if((count($node_statistics) - 24) <= $count_values) {
                    $lasthour_clients_avg[] =  $timestamp['CLIENTS'];
                }

                if(count($node_statistics)-1 == $count_values) {
                    $datetime_end = $timestamp['TIMESTAMP_HOUR'];
                }

                $first = false;
                $count_values++;
            }

            $lasthour_clients_avg_value = round(array_sum($lasthour_clients_avg) / count($lasthour_clients_avg), 2);

            echo "<h1>" . $node_hostname . " (" . $nodeID . ") - Clientstatistik</h1>";
        ?>
        
        <div class='chart-info-box'>
            <div class='chart-info left'>
                <div class='table'>
                    <div class='table-row'>
                        <div class='table-cell text-strong'>
                            Anzahl Werte (Stunden):
                        </div>
                        <div class='table-cell'>
                            <?php echo $count_values; ?>
                        </div>
                    </div>
                    <div class='table-row'>
                        <div class='table-cell text-strong'>
                            Durchschnitt Clients (gesamt):
                        </div>
                        <div class='table-cell'>
                            <?php echo round(array_sum($infos_clients_values_total) / count($infos_clients_values_total), 2); ?>
                        </div>
                    </div>
                    <div class='table-row'>
                        <div class='table-cell text-strong'>
                            Maximum Clients (gesamt):
                        </div>
                        <div class='table-cell'>
                            <?php echo max($infos_clients_max_total) . " (AVG: " . round(array_sum($infos_clients_max_total) / count($infos_clients_max_total), 2) . ")"; ?>
                        </div>
                    </div>
                    <div class='table-row'>
                        <div class='table-cell text-strong'>
                            Durchschnitt Clients (letzte 24 Stunden): &nbsp;&nbsp;&nbsp;&nbsp
                        </div>
                        <div class='table-cell'>
                            <?php echo $lasthour_clients_avg_value; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class='chart-info right'>
                <div class='table'>
                        <div class='table-row'>
                            <div class='table-cell text-strong'>
                                Startdatum:
                            </div>
                            <div class='table-cell'>
                                <?php echo $datetime_start; ?>
                            </div>
                        </div>
                        <div class='table-row'>
                            <div class='table-cell text-strong'>
                                Enddatum:
                            </div>
                            <div class='table-cell'>
                                <?php echo $datetime_end; ?>
                            </div>
                        </div>
                        <div class='table-row'>
                            <div class='table-cell text-strong'>
                                Tage (anz. Stunden / 24): &nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                            <div class='table-cell'>
                                <?php echo round(count($infos_clients_values_total) / 24, 2); ?>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        
        <div id="chart"></div>
    </div>
</section>
<script>
    var chart = c3.generate({
        bindto: '#chart',
        data: {
          columns: [
            ['Maximum Clients', <?php echo $infos_clients_max; ?>],
            ['Durchschnitt Clients', <?php echo $infos_clients_values; ?>],
            ['Mininum Clients', <?php echo $infos_clients_min; ?>]
          ],
           types: {
                'Maximum Clients': 'line',
                'Durchschnitt Clients': 'line',
                'Mininum Clients': 'line'
            },
            colors: {
                'Maximum Clients': '#8BB78F', //'#00aa00',
                'Durchschnitt Clients': '#000',
                'Mininum Clients': '#BA7E7E', //#dd0000'
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
                // Zeigt immer die letzten 48 Stunden in groß an im oberen Chart
                extent: [<?php echo $count_values - 48; ?>, <?php echo $count_values; ?>],
                type: 'category',
                categories: [<?php echo $infos_clients_x_axis; ?>],
                tick: {
                    count: 25,
                    width: 60
                },
                height: 60
            },
            y: {
                padding: {
                    top: 30, 
                    bottom: 1
                },
                label: {
                    text: 'Anzahl Clients',
                    position: 'outer-center'
                }
            }
        },
        grid: {
            y: {
                show: true,
                lines: [
                    {value: <?php echo round(array_sum($infos_clients_values_total) / count($infos_clients_values_total), 2); ?>, text: 'Durchschnitt gesamt'},
                    {value: <?php echo max($infos_clients_max_total); ?>, text: 'Maximum'},
                    {value: <?php echo $lasthour_clients_avg_value; ?>, text: 'Durchschnitt letzte 24 Stunden'}
                ]
            }
        },
        point: {
            r: 2.5
        }
    });
</script>