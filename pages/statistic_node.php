<section class="content">
    <?php
    $nodeID = htmlspecialchars($_GET['nodeID']);
    $nodeStatisticsModel = new Node_Statistics_Model();

    /*
     * Kleine Überprüfung ob Variable gesendet und nodeID die richtige Länge.
     *
     * Wenn keine nodeID übergeben würde, oder die Länge falsch ist, dann wird eine zufällige nodeID genommen
    */
    if(empty($nodeID) || strlen($nodeID) != 12) {
        $nodeID = $nodeStatisticsModel->getNodes()[array_rand($nodeStatisticsModel->getNodes())]['ID'];
    }

    /*
     * Prüfen ob eine Anzahl an Tagen eingegeben wurde.
     *
     * Wenn ja, dann den Text und die Anzahl der Stunden entsprechend setzen.
     */
    if (isset($_GET['days']) && is_numeric($_GET['days'])) {
        $hours = htmlspecialchars($_GET['days'])  * 24;
        $hoursOrDaysText = "Tage";
    } else {
        $hours = 2160; // 3 Monate (90 Tage)
        $hoursOrDaysText = "Stunden";
    }
    ?>
    <!-- Help Modal -->
    <div class="modal fade" id="statisticNodeHelpModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
                    <h4 class="modal-title" id="myModalLabel">Informationen / Hilfe</h4>
                </div>
                <div class="modal-body">
                    <div class="box-group" id="statisticNodeHelpModalAccordion">
                        <!-- 0 -->
                        <div class="panel box-primary">
                            <div class="box-header">
                                <h4 class="box-title">
                                    <a data-toggle="collapse" data-parent="statisticNodeHelpModalAccordion" href="#statisticNodeHelpModalAccordion_0" aria-expanded="false">
                                        Alllgemeines
                                    </a>
                                </h4>
                            </div>
                            <div id="statisticNodeHelpModalAccordion_0" class="panel-collapse collapse" aria-expanded="false">
                                <div class="box-body">
                                    Wenn mehr als 90 Tage ausgewählt werden, werden die Daten automatisch als
                                    Tageswerte herausgeholt, da sonst zu vele Werte angezeigt werden würden, die den Client durchaus sehr belasten könnten
                                </div>
                            </div>
                        </div>

                        <!-- 1 -->
                        <div class="panel box-primary">
                            <div class="box-header">
                                <h4 class="box-title">
                                    <a data-toggle="collapse" data-parent="statisticNodeHelpModalAccordion" href="#statisticNodeHelpModalAccordion_1" aria-expanded="false">
                                        Anzahl Werte (Stunden / Tage)
                                    </a>
                                </h4>
                            </div>
                            <div id="statisticNodeHelpModalAccordion_1" class="panel-collapse collapse" aria-expanded="false">
                                <div class="box-body">
                                    <strong>Konkret:</strong><br />
                                    Die Anzahl der Werte, die in einem gewissen Zeitraum vorhanden sind.

                                    <br /><br />
                                    <strong>Beschreibung:</strong>
                                    Dieser Wert gibt an, wie viele einzelne Werte in einem Zeitraum (gesamt oder selbst ausgewählt) vorhanden sind.<br />
                                    Wenn man beispielsweise die Werte von 20 Tagen haben möchte, aber nicht 480h sondern weniger angezeigt werden, dann liegt es daran,
                                    dass zwischendurch Werte fehlen.
                                </div>
                            </div>
                        </div>

                        <!-- 2 -->
                        <div class="panel box-primary">
                            <div class="box-header">
                                <h4 class="box-title">
                                    <a data-toggle="collapse" data-parent="statisticNodeHelpModalAccordion" href="#statisticNodeHelpModalAccordion_2" aria-expanded="false">
                                        &#216; Clients (gesamt)
                                    </a>
                                </h4>
                            </div>
                            <div id="statisticNodeHelpModalAccordion_2" class="panel-collapse collapse" aria-expanded="false">
                                <div class="box-body">
                                    Anzahl der durchschnittlichen Clients über den gesamten Zeitraum.<br /><br />
                                    Dieser Wert kann - auch wenn der ausgewählte Zeitraum einen Tag betrifft - vom "Durchschnitt letzte 24 Stunden" abweichen, da es mehr oder weniger Werte als 24 sein können.
                                </div>
                            </div>
                        </div>

                        <!-- 3 -->
                        <div class="panel box-primary">
                            <div class="box-header">
                                <h4 class="box-title">
                                    <a data-toggle="collapse" data-parent="statisticNodeHelpModalAccordion" href="#statisticNodeHelpModalAccordion_3" aria-expanded="false">
                                        Maximum Clients (gesamt)
                                    </a>
                                </h4>
                            </div>
                            <div id="statisticNodeHelpModalAccordion_3" class="panel-collapse collapse" aria-expanded="false">
                                <div class="box-body">
                                    Maximale Anzahl der Clients über den gesamten Zeitraum.
                                </div>
                            </div>
                        </div>

                        <!-- 4 -->
                        <div class="panel box-primary">
                            <div class="box-header">
                                <h4 class="box-title">
                                    <a data-toggle="collapse" data-parent="statisticNodeHelpModalAccordion" href="#statisticNodeHelpModalAccordion_4" aria-expanded="false">
                                        &#216; Clients (letzte 24 Stunden)
                                    </a>
                                </h4>
                            </div>
                            <div id="statisticNodeHelpModalAccordion_4" class="panel-collapse collapse" aria-expanded="false">
                                <div class="box-body">
                                    Anzahl der durchschnittlichen Clients in den letzten 24 Stunden.
                                </div>
                            </div>
                        </div>

                        <!-- 5 -->
                        <div class="panel box-primary">
                            <div class="box-header">
                                <h4 class="box-title">
                                    <a data-toggle="collapse" data-parent="statisticNodeHelpModalAccordion" href="#statisticNodeHelpModalAccordion_5" aria-expanded="false">
                                        Startdatum
                                    </a>
                                </h4>
                            </div>
                            <div id="statisticNodeHelpModalAccordion_5" class="panel-collapse collapse" aria-expanded="false">
                                <div class="box-body">
                                    Datum und Uhrzeit des ersten Wertes im ausgewählten Zeitraum.
                                </div>
                            </div>
                        </div>

                        <!-- 6 -->
                        <div class="panel box-primary">
                            <div class="box-header">
                                <h4 class="box-title">
                                    <a data-toggle="collapse" data-parent="statisticNodeHelpModalAccordion" href="#statisticNodeHelpModalAccordion_6" aria-expanded="false">
                                        Enddatum
                                    </a>
                                </h4>
                            </div>
                            <div id="statisticNodeHelpModalAccordion_6" class="panel-collapse collapse" aria-expanded="false">
                                <div class="box-body">
                                    Datum und Uhrzeit des letzten Wertes im ausgewählten Zeitraum. Im Normalfall ist dies der aktuelle Tag und die aktuelle Stunde.
                                </div>
                            </div>
                        </div>

                        <!-- 7 -->
                        <div class="panel box-primary">
                            <div class="box-header">
                                <h4 class="box-title">
                                    <a data-toggle="collapse" data-parent="statisticNodeHelpModalAccordion" href="#statisticNodeHelpModalAccordion_7" aria-expanded="false">
                                        Tage
                                    </a>
                                </h4>
                            </div>
                            <div id="statisticNodeHelpModalAccordion_7" class="panel-collapse collapse" aria-expanded="false">
                                <div class="box-body">
                                    Anzahl der Werte / 24 = Tage. Dient als kleine Hilfe, wenn beispielsweise kein Zeitraum ausgewählt wurde.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Schließen</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Formular zum Auswählen der Anzahl der Tage -->
    <div class="row">
        <div id="help-icon" class="right">
            <i data-toggle="modal" data-target="#statisticNodeHelpModal" class="fa fa-info-circle fa-2x"></i>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <form action="index.php" method="get">
                    <input type="hidden" name="url" value="statistic-node-clients" />
                    <input type="hidden" name="days" value="<?php echo ($hours / 24);?>" />
                    <select id="nodeID" name="nodeID" class="form-control select2" onchange="this.form.submit();">
                        <?php
                            foreach($nodeStatisticsModel->getNodes() as $nodeStatistic) {
                                echo "<option value='" . $nodeStatistic['ID'] . "'";
                                if($nodeID == $nodeStatistic['ID']) {
                                    echo " selected='selected'";
                                }
                                echo ">" . $nodeStatistic['HOSTNAME'] . "</option>";
                            }
                        ?>
                    </select>
                </form>
            </div>
        </div>
        <div class="col-lg-1">
            <form action="index.php" method="get">
                <input type="hidden" name="url" value="statistic-node-clients" />
                <input type="hidden" name="nodeID" value="<?php echo $nodeID; ?>" />
                <div class="input-group input-group-sm">
                    <input type="text" name="days" id="days" class="form-control" placeholder="Anzahl Tage"
                           value="<?php if($hoursOrDaysText == "Tage") { echo $hours / 24; } ?>" required />
                    <span class="input-group-btn">
                        <input type="submit" value="GO" class="btn btn-default"/>
                    </span>
                </div>
            </form>
        </div>
    </div>

    <!-- Diagramm -->
    <div class="row">
            <?php
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
                            Anzahl Werte (Stunden / Tage): &nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                        <div class='table-cell'>
                            <?php
                            if($hours > 2160) {
                                $days = $count_values;
                                echo ($count_values * 24) . " / " . $days;
                            } else {
                                $days = round($count_values / 24, 2);
                                echo $count_values . " / " . $days;
                            }
                            ?>
                        </div>
                    </div>
                    <div class='table-row'>
                        <div class='table-cell text-strong'>
                            &#216; Clients (gesamt):
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
                            <?php echo max($infos_clients_max_total) . " (&#216; " . round(array_sum($infos_clients_max_total) / count($infos_clients_max_total), 2) . ")"; ?>
                        </div>
                    </div>
                    <div class='table-row'>
                        <div class='table-cell text-strong'>
                            &#216; Clients (letzte 24 Stunden): &nbsp;&nbsp;&nbsp;&nbsp
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
                                Tage
                                <?php
                                if($hoursOrDaysText == "Stunden") {
                                    echo "(anz. Stunden / 24): &nbsp;&nbsp;&nbsp;&nbsp;";
                                } else {
                                    echo ": &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                }
                                ?>
                            </div>
                            <div class='table-cell'>
                                <?php echo $days; ?>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        
        <div id="chart-statistic-node"></div>
    </div>
</section>
<script>
    $("#nodeID").select2();

    var chart = c3.generate({
        bindto: '#chart-statistic-node',
        data: {
          columns: [
            ['Maximum Clients', <?php echo $infos_clients_max; ?>],
            ['Durchschnitt Clients', <?php echo $infos_clients_values; ?>],
            ['Mininum Clients', <?php echo $infos_clients_min; ?>]
          ],
           types: {
                'Maximum Clients': 'step',
                'Durchschnitt Clients': 'step',
                'Mininum Clients': 'step'
            },
            colors: {
                'Maximum Clients': '#8BB78F',
                'Durchschnitt Clients': '#000',
                'Mininum Clients': '#BA7E7E'
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
                // Zeigt immer die letzten 24 Stunden in groß an im oberen Chart
                extent: [<?php echo $count_values - 24; ?>, <?php echo $count_values; ?>],
                type: 'category',
                categories: [<?php echo $infos_clients_x_axis; ?>],
                tick: {
                    fit: false,
                    width: 50
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