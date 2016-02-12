<?php if (!defined('__IN_SITE__')) { echo "Zugriff verweigert!"; die(); } ?>

<?php
    $nodeStatisticsModel = new Node_Statistics_Model();
    $statisticHours = 72;
    $statisticNodesState = $nodeStatisticsModel->getOfflineNodesNHours(72); // 3 Tage
    
    // Sollen direkt alle Einträge angezeigt werden oder wie standard?
    if(isset($_GET['showAll'])) {
        $showAlll = htmlspecialchars($_GET['showAll']);
    } else {
        $showAlll = false;
    }    
    
    // Soll die Uhrzeit mit in der Tabelle angezeigt werden?
    $statisticWithTime = true;
?>

<div class="row">
    <div class="col-xs-12">
        <div id="nodes-table" class="box box-solid box-freifunk-default">
            <div class="box-header with-border">
                <i class="fa fa-power-off"></i><h3 class="box-title">Länger als <?php echo round(($statisticHours / 24), 2) . " Tage (" . $statisticHours . "h)";?> offline</h3>
            </div>
            <div class="box-body">
                <!-- Container für die Suche -->
                <div class="custom-search-container">
                    <label for="customSearchStatistic">Suche: </label><input type="text" id="customSearchStatistic" />
                    <button onclick="resetSearchStatistic()">X</button>
                </div>
                <!-- Tabelle -->
                <table id="nodesTableStatistic" class="display responsive nowrap" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">Hostname</th>
                            <th class="text-center">Tage <br />offline</th>
                            <th class="text-center">Offline seit</th>
                            <th class="text-center">Zuletzt auf der Karte</th>
                            <th class="text-center">IPv6-Adresse</th>
                            <th class="text-center">Node auf Map</th>
                            <th class="text-center">Firmware <br />Base</th>
                            <th class="text-center">Firmware <br />Release</th>
                        </tr>
                    </thead>
                    
                    <tfoot>
                        <tr>
                            <th class="text-center">Hostname</th>
                            <th class="text-center">Tage <br />offline</th>
                            <th class="text-center">Offline seit</th>
                            <th class="text-center">Zuletzt auf der Karte</th>
                            <th class="text-center">IPv6-Adresse</th>
                            <th class="text-center">Node auf Map</th>
                            <th class="text-center">Firmware <br />Base</th>
                            <th class="text-center">Firmware <br />Release</th>
                        </tr>
                    </tfoot>
                    
                    <tbody>          
                        <?php
                            foreach($statisticNodesState as $node) {
                                echo "<tr style='color: #FFFFFF; background-color: ";
                                if($node['DAYS_OFFLINE'] <= 5) { echo "#dd7d00"; }
                                else if($node['DAYS_OFFLINE'] < 14) { echo "#d10000"; }
                                else if($node['DAYS_OFFLINE'] >= 14) { echo "#8400cc"; }
                                echo ";'>";
                                    echo "<td><a target='_blank' style='color: #FFFFFF;' href='index.php?url=statistic-node-clients&nodeID=" . $node['ID'] . "'>" . $node['HOSTNAME'] . "</a></td>";
                                    echo "<td style='text-align: center; font-weight: bold;'>" . $node['DAYS_OFFLINE'] . "</td>";
                                    //echo "<td class='text-center'><span class='hidden'>" . $node['LAST_SEEN'] . "</span>" . Dater::convertSQLDateToGermanDate($node['LAST_SEEN'], $statistic_with_time) . "</td>";
                                    echo "<td class='text-center'>" . Dater::convertSQLDateToGermanDate($node['LAST_SEEN'], $statisticWithTime) . "</td>";
                                    echo "<td class='text-center'>" . Dater::convertSQLDateToGermanDate($node['NODE_TIMESTAMP'], $statisticWithTime) . "</td>";
                                    echo "<td class='text-center'><a target='_blank' style='color: #FFFFFF;' href='http://[" . $node['IP_EXTERN'] . "]'>" . $node['IP_EXTERN'] . "</td>";
                                    echo "<td class='text-center'><a target='_blank' style='color: #FFFFFF;' href='http://map.freifunk-moers.de/#!n:" . $node['ID'] . "'>" . $node['ID'] . "</td>";
                                    echo "<td>" . $node['FIRMWARE_BASE'] . "</td>";
                                    echo "<td>" . $node['FIRMWARE_RELEASE'] . "</td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">   
    var nodesTableStatistic;
    $(document).ready(function () {
        
        $('#nodesTableStatistic tfoot th').each( function () {
            var title = $('#nodesTableStatistic thead th').eq( $(this).index() ).text();
            $(this).html( '<input type="text" placeholder="'+title+'" style="width: 100%" class="text-center text-overflow-ellipsis" />' );
        } );
    
        // Das Datum in jeder Spalte wie folgt sortieren:
        $.fn.dataTable.moment( 'DD.MM.YYYY HH:mm:ss' );
        
        nodesTableStatistic = $('#nodesTableStatistic').DataTable({
            dom: 'Blitp',
            buttons: [
                {
                    extend: 'print',
                    text: 'Druckansicht',
                    title: 'Freifunk Moers Nodes, die länger als <?php echo round(($statisticHours / 24), 2) . " Tage (" . $statisticHours . "h)";?> offline sind',
                    autoPrint: false,
                },
                {
                    extend: 'excelHtml5',
                    text: 'Export nach Excel',
                    title: 'Offline_Nodes_FF-MO',
                    exportOptions: {
                        //columns: [0,1,2,3,4,5,6,7,8,9, ':hidden']
                    }
                },
                {
                    extend: 'print',
                    text: 'Druckansicht: ausgewählte Zeilen',
                    title: 'Freifunk Moers Nodes, die länger als <?php echo round(($statisticHours / 24), 2) . " Tage (" . $statisticHours . "h)";?> offline sind (ausgewählte Zeilen)',
                    exportOptions: {
                        modifier: {
                            selected: true
                        }
                    },
                    autoPrint: false
                },
                {
                    extend: 'excelHtml5',
                    text: 'Export nach Excel: ausgewählte Zeilen',
                    title: 'Offline_Nodes_FF-MO_Ausgewaehlte_Zeilen',
                    exportOptions: {
                        modifier: {
                            selected: true
                        }
                    }
                }
            ],
            select: true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": true,
            "stateSave": false,
            <?php 
            if($showAlll != true) {
                echo '"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Alle"]],';
            } else {
                echo '"lengthMenu": [[-1], ["Alle"]],';
            }
            ?>
                        
            "order": [[ 2, "desc" ]],
            "responsive": true,
            "orderClasses": false,
            "columnDefs": [
                { "width": "50px", "targets": [1, 6, 7] },
                { "width": "120px", "targets": [2, 3] },
                { "width": "240px", "targets": 4 },
                { "width": "100px", "targets": 5 }
            ],
            "language": {
                "sEmptyTable": "Keine Daten in der Tabelle vorhanden",
                "sInfo": "_START_ bis _END_ von _TOTAL_ Einträgen",
                "sInfoEmpty": "0 bis 0 von 0 Einträgen",
                "sInfoFiltered": "(gefiltert von _MAX_ Einträgen)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ Einträge anzeigen",
                "sLoadingRecords": "Wird geladen...",
                "sProcessing": "Bitte warten...",
                "sSearch": "Suchen",
                "sZeroRecords": "Keine Einträge vorhanden.",
                "oPaginate": {
                    "sFirst": "Erste",
                    "sPrevious": "Zurück",
                    "sNext": "Nächste",
                    "sLast": "Letzte"
                },
                "oAria": {
                    "sSortAscending": ": aktivieren, um Spalte aufsteigend zu sortieren",
                    "sSortDescending": ": aktivieren, um Spalte absteigend zu sortieren"
                },
                "select": {
                    "rows": {
                        "_": "%d Zeilen ausgewählt",
                        "0": "Keine Zeile(n) ausgewählt",
                        "1": "%d Zeile ausgewählt"
                    }
                }
            }
        });
        
        nodesTableStatistic.columns().every( function () {
            var that = this;

            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );
        
        $('a.toggle-vis').on( 'click', function (e) {
            e.preventDefault();
            var column = nodesTableStatistic.column( $(this).attr('data-column') );
            column.visible( ! column.visible() );
        } );
    });
    
    //  Damit die Suche über das eigene Feld funktioniert
    $('#customSearchStatistic').keyup(function() {
        nodesTableStatistic.columns(0).search($(this).val()).draw();
    });
    
    function resetSearchStatistic() {
        $("#customSearchStatistic").val('');
        searchStatistic('');
    }
    
    function searchStatistic(value) {
        //  Falls value leer sein sollte, soll die Suche erst zurückgesetzt
        // und das ausgeführt werden.
        if(value !=  '') {
            resetSearchStatistic();
        }
        
        //  Den gesuchten Text zum Suchfeld hinzufügen, da bessere Usabillity
        $("#customSearchStatistic").val(value);
        
        //  Die tatsächliche Suche durchführen
        nodesTableStatistic.columns(0).search(value).draw();
    }
</script>