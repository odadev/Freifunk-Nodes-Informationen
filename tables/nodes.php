<?php    
    // Abfrage wie viele Clients zur Zeit online sind und welcher der neuste Node ist
    $numberOfClients = 0;
    $newestNode = "";
    $newestNodeDate = "";
    $longestUptime = 0;
    $longestUptimeHostname = 0;
    
    $first = true;
    foreach($nodes as $node) {
        $numberOfClients += $node->getClients();
     
        if($first == true) {
            $newestNodeDate = $node->getFirstSeen();
            $newestNode = $node->getHostname();
            
            $longestUptime = $node->getUptime();
            $longestUptimeHostname = $node->getHostname();
            $first = false;
        } else {
            // Überprüfung für neuste Node
            if(strtotime($node->getFirstSeen()) > strtotime($newestNodeDate)) {
                $newestNode = $node->getHostname();
                $newestNodeDate = $node->getFirstSeen();
            }
            
            // Überprüfung für längste Uptime
            if($node->getUptime() > $longestUptime) {
                $longestUptime = $node->getUptime();
                $longestUptimeHostname = $node->getHostname();
            }
        }
    }
?>

<div class="row">
    <!-- Anzahl an Nodes -->
    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-fuchsia-active"><i class="fa fa-globe"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Anzahl Nodes</span>
                <span class="info-box-number"><?php echo sizeof($nodes); ?></span>
            </div>
        </div>
    </div>
    
    <!-- Clients online -->
    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-purple"><i class="fa fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Clients online</span>
                <span class="info-box-number"><?php echo $numberOfClients; ?></span>
            </div>
        </div>
    </div>
    
    <!-- Neuster Node -->
    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-plus"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Neuster Node</span>
                <span class="info-box-number"><?php echo $newestNode; ?><br /><span class="info-box-number-extra"><?php echo $newestNodeDate; ?></span></span>
            </div>
        </div>
    </div>
    
    <!-- Am längsten online Node -->
    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-orange"><i class="fa fa-arrow-up"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Am längsten online</span>
                <span class="info-box-number"><?php echo $longestUptimeHostname; ?><br /><span class="info-box-number-extra"><?php echo number_format($longestUptime / 60 / 60 / 24, 0); ?> Tage</span></span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div id="nodes-table" class="box box-solid box-freifunk-default">
            <div class="box-header with-border">
                <i class="fa fa-list-ul"></i><h3 class="box-title">Nodes</h3>
            </div>
            <div class="box-body">
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
            "order": [[ 2, "desc" ]],
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
    });
</script>