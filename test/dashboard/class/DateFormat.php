<?php 

/**
 * La Class DateFormat contiene le operazioni relative alle date usate sia da Front-End che da Back-End.
 * 
 *
 * @version   1.00
 * @since     2014-12-29
 */ 
namespace Dashboard;

class DateFormat {
    
	
	/**
	 * Array nei quali risiedono tutte le stringhe dei mesi e dei giorni in italiano e in inglese
	 *
	 * @var array
     */
    private static $giorni_IT = array('domenica','luned&igrave;','marted&igrave;','mercoled&igrave;', 'gioved&igrave;','venerd&igrave;','sabato');
                    
    private static $mesi_IT   = array(1=>'gennaio','febbraio','marzo','aprile','maggio','giugno','luglio','agosto','settembre','ottobre','novembre','dicembre');
    
    private static $giorni_EN = array('Sunday','Monday','Tuesday','Wednesday', 'Thursday','Friday','Saturday');
                    
    private static $mesi_EN   = array(1=>'January','February','March','April','May','June','July','August','September','October','November','December');
    
    private static $giorni_SH_EN   = array( 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
                                    
    private static $giorni_SH_IT   = array( 'Dom', 'Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab');
                                    
    private static $mesi_SH_IT     = array( 'Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu', 'Lug', 'Ago', 'Set', 'Ott', 'Nov', 'Dic');
                                    
    private static $mesi_SH_EN     = array( 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec');

    
	/**
	 * Funzione che permette di controllare la validità della data passata.
	 * 
	 *
	 * @param string $dateIn
	 * @return boolean Esito del controlla data
	 */
    public static function CheckDates($dateIn){
        
        $date = date_create($dateIn);        
        $date = (isset($date) && $date != NULL) ? $date : false;
        if($date == false) { return false; } else { return true; }
        
    }
    
	/**
	 * Funzione che permette di formattare correttamente la data per il database.
	 * 
	 *
	 * @param string $dateIn
	 * @return string Ritorna la data formattata
	 */
    public static function Form2Db ($dateIn) {
        $datePre = preg_split("/[\/\.\-\s]/", $dateIn); //echo $dateIn; echo ($datePre[2].'/'.$datePre[1].'/'.$datePre[0]); exit;
        $ifminute = (isset($datePre[3]) ? $datePre[3] :'');
        $date = date_create($datePre[2].$datePre[1].$datePre[0].$ifminute); //var_dump($date); echo date_format($date, 'Y-m-d H:i:s'); exit;
        return date_format($date, 'Y-m-d H:i:s');
        
    }
        
	/**
	 * Funzione che permette di formattare correttamente la data da visualizzare.
	 * 
	 *
	 * @param string $dateIn
     * @param string $type
	 * @return string Ritorna la data formattata
	 */
    public static function echoDate ($dateIn, $type) {
        
        $date = date_create($dateIn);
        
        if($type === 0) {
                                
            list($sett,$giorno,$mese,$anno) = explode('-',date_format($date, 'w-d-n-Y'));
            
            return self::$giorni_IT[$sett].' '.$giorno.' '.self::$mesi_IT[$mese].' '.$anno;
        
        } elseif($type === 1) {
            
            list($sett,$giorno,$mese,$anno) = explode('-',date_format($date, 'w-d-n-Y'));
            
            return self::$giorni_EN[$sett].' '.$giorno.' '.self::$mesi_EN[$mese].' '.$anno;
            
        } elseif($type === 2) {
            
            list($sett,$giorno,$mese,$anno) = explode('-',date_format($date, 'w-d-n-Y'));
            
            return self::$giorni_SH_IT[$sett].' '.$giorno.' '.self::$mesi_SH_IT[$mese].' '.$anno;
            
        } elseif($type === 3) {
            
            list($sett,$giorno,$mese,$anno) = explode('-',date_format($date, 'w-d-n-Y'));
            
            return self::$giorni_SH_EN[$sett].' '.$giorno.' '.self::$mesi_SH_EN[$mese].' '.$anno;
            
        } elseif($type === 4) {
                                    
            return date_timestamp_get($date);
            
         } else {
            
            return date_format($date, $type);
            
        }
    }
    
    public static function s_datediff( $str_interval, $dt_menor, $dt_maior, $relative=false)
    {

       if( is_string( $dt_menor)) $dt_menor = date_create( $dt_menor);
       if( is_string( $dt_maior)) $dt_maior = date_create( $dt_maior);

       $diff = date_diff( $dt_menor, $dt_maior, ! $relative);
       
       switch( $str_interval){
           case "y": 
               $total = $diff->y + $diff->m / 12 + $diff->d / 365.25; break;
           case "m":
               $total= $diff->y * 12 + $diff->m + $diff->d/30 + $diff->h / 24;
               break;
           case "d":
               $total = $diff->y * 365.25 + $diff->m * 30 + $diff->d + $diff->h/24 + $diff->i / 60;
               break;
           case "h": 
               $total = ($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h + $diff->i/60;
               break;
           case "i": 
               $total = (($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i + $diff->s/60;
               break;
           case "s": 
               $total = ((($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i)*60 + $diff->s;
               break;
          }
       if( $diff->invert)
               return -1 * $total;
       else    return $total;
   }
   
   public static function dynamic_datediff ($dt_menor, $relative = false)
   {
       if( is_string( $dt_menor)) $dt_menor = date_create( $dt_menor);       
       $dt_maior=date_create( date('Y-m-d H:i:s'));
       
        $diff = date_diff( $dt_menor, $dt_maior, ! $relative);
        
        //accesing days
        $days = $diff->d;
        //accesing months
        $months = $diff->m;
        //accesing years
        $years = $diff->y;
        //accesing hours
        $hours=$diff->h;
        //accesing minutes
        $minutes=$diff->i;
        //accesing seconds
        $seconds=$diff->s;
        
        if($years >0 )
        {
            return $years.' months';            
        }
        elseif($months > 0)
        {
            return $months.' months';            
        }
        elseif($days > 0)
        {
            return $days.' days';            
        }
        elseif($hours > 0)
        {
            return $hours.' hours';            
        }
        elseif($minutes > 0)
        {
            return $minutes.' mins';
        }
        elseif($seconds > 0)
        {
            return 'Now';
        }
        
   }
}

?>