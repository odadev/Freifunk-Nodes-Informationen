<?php if (!defined('__IN_SITE__')) { echo "Zugriff verweigert!"; die(); } ?>
<div class="col-xs-12">
    <div id="nodes-table" class="box box-solid box-freifunk-default">
        <div class="box-header with-border">
            <i class="fa fa-list-ul"></i><h3 class="box-title">Nodes</h3>
        </div>
        <div class="box-body">
            <!-- COntainer zum Ein- und Ausblenden der Spalten -->
            <div class="toggle-columns text-center">
                Spalte ein-/ausblenden: 
                <br />
                <a class="toggle-vis" data-column="0">Hostname</a> - 
                <a class="toggle-vis" data-column="1">On</a> - 
                <a class="toggle-vis" data-column="2">Clients</a> - 
                <a class="toggle-vis" data-column="3">Uptime</a> - 
                <a class="toggle-vis" data-column="4">Modell</a> - 
                <a class="toggle-vis" data-column="5">IPv6</a> - 
                <a class="toggle-vis" data-column="6">Node auf Map</a> - 
                <a class="toggle-vis" data-column="7">Speicherauslastung</a> - 
                <a class="toggle-vis" data-column="8">Load AVG</a>
            </div>

            <!-- Container für die Suche -->
            <div class="custom-search-container">
                <label for="customSearch">Suche: </label><input type="text" id="customSearch" />
                <button onclick="resetSearch()">X</button>
            </div>

            <!-- Tabelle -->
            <table id="nodesTable" class="display responsive nowrap" width="100%">
                <thead>
                    <tr>
                        <th class="text-center">Hostname</th>
                        <th class="text-center"><i class="fa fa-power-off"></i></th>
                        <th class="text-center">Clients</th>
                        <th class="text-center">Uptime</span></th>
                        <th class="text-center">Modell</th>
                        <th class="text-center">IPv6-Adresse</th>
                        <th class="text-center">Node auf Map</th>
                        <th class="text-center">Speicherauslastung</th>
                        <th class="text-center">Load AVG</th>
                    </tr>
                </thead>

                <tfoot>
                    <tr>
                        <th class="text-center">Hostname</th>
                        <th class="text-center"><i class="fa fa-power-off"></i></th>
                        <th class="text-center">Clients</th>
                        <th class="text-center">Uptime (Tage)</th>
                        <th class="text-center">Modell</th>
                        <th class="text-center">IPv6</th>
                        <th class="text-center">Node auf Map</th>
                        <th class="text-center">Speicherauslastung</th>
                        <th class="text-center">Load AVG</th>
                    </tr>
                </tfoot>

                <tbody>          
                    <?php
                        foreach($nodes as $node) {
                            echo "<tr>";
                                echo "<td><a target='_blank' href='index.php?url=statistic-node-clients&nodeID=" . $node->getNodeID() . "'>" . $node->getHostname() . "</a></td>";
                                echo "<td class='text-center'>";
                                    echo "<i class='fa fa-circle icon-";
                                    if($node->getOnline()) {
                                        echo "online' title='Online'></i>";
                                    } else {
                                        echo "offline' title='Offline'></i>";
                                    }
                                echo "</td>";
                                echo "<td class='text-center'>" . $node->getClients() . "</td>";
                                echo "<td class='text-center'>" . number_format($node->getUptime() / 60 / 60 / 24, 0) . "</td>";
                                echo "<td>" . $node->getModel() . "</td>";
                                echo "<td class='text-center'>";
                                    // Nur die längere IPv6 soll angezeigt werden
                                    $ipv6 = "";
                                    foreach ($node->getAddresses() as $address) {
                                        if(strlen($ipv6) < strlen($address)) {
                                            $ipv6 = $address;
                                        }
                                    }
                                    echo "<a target='_blank' href='http://[" . $ipv6 . "]'>" . $ipv6 . "</a><br />";;
                                echo "</td>";
                                echo "<td class='text-center'><a target='_blank' href='http://map.freifunk-moers.de/#!n:" . $node->getNodeID() . "'>" . $node->getNodeID() . "</a></td>";
                                echo "<td class='text-center'>" . number_format($node->getMemoryUsage(), 3) . "</td>";
                                echo "<td class='text-center'>" . $node->getLoadavg() . "</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
            <div class="node-timestamp-info">
                <?php echo "Stand: " . $nodeManager->getTimestamp(); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">   
    var nodesTable;
    $(document).ready(function () {
        
        $('#nodesTable tfoot th').each( function () {
            var title = $('#nodesTable thead th').eq( $(this).index() ).text();
            $(this).html( '<input type="text" placeholder="'+title+'" style="width: 100%" class="text-center text-overflow-ellipsis" />' );
        } );
    
        nodesTable = $('#nodesTable').DataTable({
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": true,
            "stateSave": false,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Alle"]],
            "order": [[ 2, "desc" ]],
            "responsive": true,
            columnDefs: [
                { type: 'numeric-comma-pre', targets: 1 }
            ],
            "dom": '<"top"lit><"clear"><"bottom"p>',
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
                }
            }
        });
        
        nodesTable.columns().every( function () {
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
            var column = nodesTable.column( $(this).attr('data-column') );
            column.visible( ! column.visible() );
        } );
    });
    
    //  Damit die Suche über das eigene Feld funktioniert
    $('#customSearch').keyup(function() {
        nodesTable.columns(0).search($(this).val()).draw();
    });
    
    function resetSearch() {
        $("#customSearch").val('');
        search('');
    }
    
    function search(value) {
        //  Falls value leer sein sollte, soll die Suche erst zurückgesetzt
        // und das ausgeführt werden.
        if(value !=  '') {
            resetSearch();
        }
        
        //  Den gesuchten Text zum Suchfeld hinzufügen, da bessere Usabillity
        $("#customSearch").val(value);
        
        //  Die tatsächliche Suche durchführen
        nodesTable.columns(0).search(value).draw();
    }
</script>