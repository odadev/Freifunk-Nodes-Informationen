<?php

/**
 * Beinhaltet sämtliche Datumsfunktionen gebündelt.
 * 
 * Nur static-Funktionen, da so von überall direkt darauf zugegriffen werdne kann
 */
abstract class Dater {
            
    /**
     * Gibt das übergeben SQL-Datum im deutschen Zeitformat zurück
     * 
     * Optional mit der Zeit oder ohne
     * $withTime = true     =>      mit Zeit
     * $withTime = false    =>      ohne Zeit
     */
    static function convertSQLDateToGermanDate($date, $withTime = false) {
        if($date == "0000-00-00" || $date == "000-00-00 00:00:00") {
            return "";
        }
        
        $sqlDate = new DateTime($date);
        
        if($withTime) {
            $germanDate = $sqlDate->format("d.m.Y H:i:s");
        } else {
            $germanDate = $sqlDate->format("d.m.Y");
        }
        return $germanDate;
    }
}
