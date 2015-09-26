<div class="row">
    <div class="col-xs-12">
        <div id="nodes-table" class="box box-solid box-freifunk-default">
            <div class="box-header with-border">
                <i class="fa fa-list-ul"></i><h3 class="box-title">Nodes</h3>
            </div>
            <div class="box-body">
                <div class="toggle-columns">
                    Spalte ein-/ausblenden: 
                    <a class="toggle-vis" data-column="0">Hostname</a> - 
                    <a class="toggle-vis" data-column="1">Uptime</a> - 
                    <a class="toggle-vis" data-column="2">Load AVG</a> - 
                    <a class="toggle-vis" data-column="3">Speicherauslastung</a> - 
                    <a class="toggle-vis" data-column="4">Clients</a>
                </div>
                <table id="nodesTable" class="display responsive nowrap" width="100%">
                    <thead>
                        <tr>
                            <th>Hostname</th>
                            <th>Uptime (Tage)</th>
                            <th>Load AVG</th>
                            <th>Speicherauslastung</th>
                            <th>Clients</th>
                        </tr>
                    </thead>						
                    <tbody>          
                        <?php
                            foreach($nodes as $node) {
                                echo "<tr>";
                                    echo "<td>" . $node->getHostname() . "</td>";
                                    echo "<td>" . number_format($node->getUptime() / 60 / 60 / 24, 0) . "</td>";
                                    echo "<td>" . $node->getLoadavg() . "</td>";
                                    echo "<td>" . number_format($node->getMemoryUsage(), 3) . "</td>";
                                    echo "<td>" . $node->getClients() . "</td>";
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
    $(document).ready(function () {
        var nodesTable = $('#nodesTable').DataTable({
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": true,
            "stateSave": false,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Alle"]],
            "order": [[ 4, "desc" ]],
            "responsive": true,
            "language":
                {
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
        
        $('a.toggle-vis').on( 'click', function (e) {
            e.preventDefault();

            // Get the column API object
            var column = nodesTable.column( $(this).attr('data-column') );

            // Toggle the visibility
            column.visible( ! column.visible() );
        } );
    });
</script>