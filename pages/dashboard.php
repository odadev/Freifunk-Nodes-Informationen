<?php    
    // Abfrage wie viele Clients zur Zeit online sind und welcher der neuste Node ist
    $numberOfClients = 0;
    $newestNode = "";
    $newestNodeDate = "";
    $longestUptime = 0;
    $longestUptimeHostname = 0;
    $onlineNodes = 0;
    
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
        
        // Wenn ein Node online, dann immer einen hochzählen
        $onlineNodes += ($node->getOnline()) ? 1 : 0;
    }
?>

<div class="row">
    <!-- Anzahl an Nodes -->
    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-fuchsia-active"><i class="fa fa-globe"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Anzahl Nodes</span>
                <span class="info-box-number text-overflow-ellipsis">
                    <?php echo sizeof($nodes); ?>
                    <br />
                    <span class="info-box-number-extra"><?php echo "Online: " . $onlineNodes . " / Offline: " . (sizeof($nodes) - $onlineNodes) . "</span>"; ?></span>
                </span>
            </div>
        </div>
    </div>
    
    <!-- Clients online -->
    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-purple"><i class="fa fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Clients online</span>
                <span class="info-box-number text-overflow-ellipsis"><?php echo $numberOfClients; ?></span>
            </div>
        </div>
    </div>
    
    <!-- Neuster Node -->
    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-plus"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Neuster Node</span>
                <span class="info-box-number text-overflow-ellipsis"><span class="search-text" onclick="search('<?php echo $newestNode; ?>')"><?php echo $newestNode; ?></span><br /><span class="info-box-number-extra"><?php echo $newestNodeDate; ?></span></span>
            </div>
        </div>
    </div>
    
    <!-- Am längsten online Node -->
    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-orange"><i class="fa fa-arrow-up"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Am längsten online</span>
                <span class="info-box-number text-overflow-ellipsis"><span class="search-text" onclick="search('<?php echo $longestUptimeHostname; ?>')"><?php echo $longestUptimeHostname; ?></span><br /><span class="info-box-number-extra"><?php echo number_format($longestUptime / 60 / 60 / 24, 0); ?> Tage</span></span>
            </div>
        </div>
    </div>
</div>

<?php
    include './tables/nodes.php'
?>