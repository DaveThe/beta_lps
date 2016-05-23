<?php 
/**
 * La Class Update contiene le operazioni per aggiornare il sistema e il database.
 * 
 *
 * @version   1.00
 * @since     2013-09-17
 */
class Update extends OriginAbstract
{
	
	/**
	 * Risorsa del datbase.
	 * @var mssql
	 */	
	 
	private $db 				= NULL;
	
	/**
	 * Costruttore della Class
	 *
	 * @param mssql $db Risorsa del database da utilizzare
	 *
	 */
	public function __construct($db) {
		$this->db = $db;
	}	
	
	
	/**
	 * Funzione che permette di controllare e recuperare l'aggiornamento del sistema'.
	 * 
	 * @param mysqli $db Risorsa del database da utilizzare
	 * @param int $numxpag Numero di utenti visualizzati in una singola pagina
	 * @param int $pag La pagina visualizzata al momento del richiamo della funzione
	 *
	 * @return array $ret Array con i dati ottenuti dalla query su database
	 */	
	public static function GetSystemUpdate() {
	
        $Destination = "";
        $file = fopen ($url, "rb");
        if($file)
        {
            $newf = fopen($newfname, "wb");
            
            if($newf)
            {
                while(!eof($file))
                {
                    fwrite($newf, fread($file, 1024*8), 1024*8);
                }
            }
        }
        
        if($file)
        {
            fclose($file);
        }
        
        if($newf)
        {
            fclose($newf);
        }
               
        
	}
    
    public static function GetDatabaseUpdate()
    {
        $ret = false;
        
        $sql = file_get_contents('http://shufflesoft.no-ip.org/include/DB_Default.sql');
                
        if ($this->db->mysqli_multi_query($sql)) 
        {			
			$ret = true;			
		}
        else
        {			
			//recupero e salvo l'errore sui dati utente
			$info=debug_backtrace();
			Log::logsError($this->db, ERROR, "Errore durante l'aggiornamento del db - mssql_query:".$sql." - mysql_errno: ".$this->db->errno." - mysql_error_description: ".$this->db->error, 4,Log::stackTrace($info));
		}
        
        return $ret;
    } 
			
	/**
	 * Funzione che permette di disapprovare un utente.
	 * 
	 * @param mssql $db Risorsa del database da utilizzare
	 * 
	 * @return array $ret Array con il risultato della query eseguita su database,
	 * contiene le informazioni sulle aree del backoffice
	 */	
	public static function CheckUpdate($Current) 
    {	
        $newVersion = 0;
        try
        {
            //$db_sql = file_get_contents('http://shufflesoft.altervista.org/include/DB_Default.sql');
            $lines = @file('http://shufflesoft.altervista.org/include/DB_Default.sql');
            if(isset($lines) && $lines != '' )
            {
                $lines = preg_grep('/^-- Version : /', $lines);
            
                $file = explode('-- Version : ',trim(implode($lines)));
            }
            
            $newVersion = ( ( isset($file[1]) && $file[1] != '' ) ? $file[1] : 0 );
            
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
        
		return (($newVersion > $Current) ? true : false );
	}

}
?>