<?php 
namespace Lapsic;
/**
 * La Class Log contiene le funzioni per gestire i log delle operazioni effettuate
 * dagli utenti sui contenuti del backoffice.
 *
 *
 * @version   1.00
 * @since     2015-05-17
 * @author    Davide Tresoldi
 * @company   http://addictify.it/
 */

use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Adapter\Adapter; 

class Log extends OriginAbstract 
{
	
	/**
	 * Id del log (interno al sistema)
	 * @var int
	 */
	
	public $id = NULL;
		
	/**
	 * Eventuali note per l'operazione
	 *
	 * @var string
	 */
	 
	public $error_type = NULL;
    
	/**
	 * Eventuali note per l'operazione
	 *
	 * @var string
	 */
	 
	public $message = NULL;
    
	/**
	 * Eventuali note per l'operazione
	 *
	 * @var string
	 */
	 
	public $sql_string = NULL;
    
	/**
	 * Eventuali note per l'operazione
	 *
	 * @var string
	 */
	 
	public $sql_error = NULL;
    
	/**
	 * Eventuali note per l'operazione
	 *
	 * @var string
	 */
	 
	public $sql_err_descr = NULL;
    
	/**
	 * Eventuali note per l'operazione
	 *
	 * @var string
	 */
	 
	public $method = NULL;
    
	/**
	 * Eventuali note per l'operazione
	 *
	 * @var string
	 */
	 
	public $class = NULL;
    
	/**
	 * Eventuali note per l'operazione
	 *
	 * @var string
	 */
	 
	public $file = NULL;
    
	/**
	 * Eventuali note per l'operazione
	 *
	 * @var string
	 */
	 
	public $error_file = NULL;
    
	/**
	 * Eventuali note per l'operazione
	 *
	 * @var string
	 */
	 
	public $backtrace = NULL;
	
	/**
	 * Data in cui è stata effettuata l'operazione, viene inserita automaticamente
	 *
	 * @var date
	 */
	 
	public $ip_address = NULL;
    
	/**
	 * Id dell'utente che ha effettuato l'operazione
	 *
	 * @var int
	 */
	 
	public $status = NULL;
	
	/**
	 * Id dell'utente che ha effettuato l'operazione
	 *
	 * @var int
	 */
	 
	//public $created_by = NULL;
	
	/**
	 * Data in cui è stata effettuata l'operazione, viene inserita automaticamente
	 *
	 * @var date
	 */
	 
	public $data_creation = NULL;
        
	/**
	 * Risorsa del datbase.
	 * @var mysqli
	 */	
	//private $db = NULL;
	
	/**
	 * Costruttore della Class
	 *
	 * @param mysqli $db Risorsa del database da utilizzare
	 *
	 */
	 
	public function __construct($db,
                                $err_type = NULL,
                                $function = NULL,
                                $class = NULL,
                                $file = NULL,
                                $sql = NULL,
                                $info = NULL,
                                $errno = NULL,
                                $error = NULL,
                                $created_by = NULL
                                ) 
    {
		$this->db = $db;
        $this->ip_address   = @Common::get_client_ip();
        
        $this->error_type    = $err_type;
        $this->method        = $function;
        $this->class         = $class;
        $this->file          = $file;
        $this->error_file    = $info;
        $this->sql_string    = $sql;
        $this->sql_error     = $errno;
        $this->sql_err_descr = $error;   
        $this->created_by    = $created_by; 
	}
	    
	/**
	 * Funzione che recupera un log di un errore dato un determinato Id
	 *
	 * @param int $id Id del log di cui recuperare le informazioni
	 * @return boolean $ret esito del recupero dei dati
	 *
	 */
	
	public function GetElement($id) {
		$ret = false;
		
		if ( isset($id) && ($id != '') ) 
        {       
            $sql = new Sql($this->db);
            $operation = $sql->select();
            $operation->from(  array('S' => PREFIX.'dashboard_logs_errors'),
                            array(  'id',
                                    'error_type',
                                    'message',
                                    'method',
                                    'class',
                                    'file',
                                    'error_file',
                                    'backtrace',
                                    'ip_address',
                                    'created_by',
                                    'data_creation',
                                    'status'
                                 ) );
            $operation->where(array('id' => $id));
			
			/* DEBUG */
			$debug_sql = $sql->getSqlStringForSqlObject($operation); 
      		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
			/* ***** */
			
			$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
			
			if ($row = $resData->current()) 
            {
				$this->id    				= $row['id'];
				$this->error_type 			= $row['error_type'];
				$this->message       		= $row['message'];
				$this->method 			    = $row['method'];
				$this->class 			    = $row['class'];
				$this->file 			    = $row['file'];
				$this->error_file      		= $row['error_file'];
				$this->backtrace      		= $row['backtrace'];
                $this->ip_address           = $row['ip_address'];
				$this->created_by 			= $row['created_by'];
				$this->data_creation 		= $row['data_creation'];
			    $this->status        		= $row['status'];
				$ret                        = true;    				    				
    			
    		}
            else
            {                
    			return false;
            }
        }
	   return $ret;
	}
    
	 /**
	 * Inserisce un log nella tabella dashboard_logs_errors
	 *
	 * @param mysqli risorsa del database da utilizzare
	 * @param int $error_type tipologia di errore (0 = warning, 1 = errore)
	 * @param string $message messaggio di errore
	 * @param string $error_code codice errore (permette di identificare in modo preciso il punto di generazione dell'errore)
	 *
	 * @return void
	 */ 
	 public function Update()
	 {
        
	 }
    	
	 /**
	 * Inserisce un log nella tabella dashboard_logs_errors
	 *
	 * @param mysqli risorsa del database da utilizzare
	 * @param int $error_type tipologia di errore (0 = warning, 1 = errore)
	 * @param string $message messaggio di errore
	 * @param string $error_code codice errore (permette di identificare in modo preciso il punto di generazione dell'errore)
	 *
	 * @return void
	 */ 
	 public function Insert()
	 {
        $message = "Errore durante l'operazione - query String:".$this->sql_string." - Error: ".$this->sql_error." Descrizione: ".$this->sql_err_descr;
        //$compressed = gzdeflate(json_encode($this->error_file),  9);
        //$compressed = gzdeflate($compressed, 9);

        $sql = new Sql($this->db);
        $operation = $sql->insert(PREFIX.'dashboard_logs_errors');
        $newData = array(
                            'error_type'     => $this->error_type,
                            'message'        => $message,
                            'method'         => $this->method,
                            'file'           => $this->file,
                            'class'          => $this->class,
                            'error_file'     => self::stackTrace($this->error_file),
                            'backtrace'      => $this->error_file,
                            'ip_address'     => $this->ip_address,
                            'data_creation'  => gmdate("Y-m-d H:i:s"),
                            'created_by'     => ID_USER_LOG
                        );
                        
        $operation->values($newData);
		
		/* DEBUG */
		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */
		//echo $debug_sql;
        //exit();
	    if(!self::executeQuery($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG))
        {
            echo 'merda';
            return false;
        }
        else
        {
            return true;
        }
	 }
	 
	public static function stackTrace($info){
		
		$exp=explode("/",str_replace("\\","/",$info[0]['file']));
		$output ='File: '.end($exp).' --- Line: '.$info[0]['line'].' nella funzione: '.$info[0]['function'];//.' Da: '.$info[0]['object']->username;
		
		return $output;
		 
	}
	
	public static function stackTraceDebug($info){
		
		$exp=explode("/",str_replace("\\","/",$info[1]['file']));
		$output ='File: '.end($exp).' --- Line: '.$info[1]['line'];
		
		return $output;
		 
	}
    
    

	/**
	 * Funzione che permette di recuperare l'elenco degli utenti che possono accedere al backoffice.
	 * 
	 * @param mysqli $db Risorsa del database da utilizzare
	 * @param int $numxpag Numero di utenti visualizzati in una singola pagina
	 * @param int $pag La pagina visualizzata al momento del richiamo della funzione
	 * @param int $tipo Indica se si vogliono visualizzare gli utenti attivi oppure no
	 * @param string $nome Stringa di ricerca degli utenti
	 * @param int $idproprio Filtra i risultati rendendo visibili solo quelli creati dall'utente passato come parametro
	 *
	 * @return array $ret Array con i dati ottenuti dalla query su database
	 */	
	public static function GetElementsList($ParametersList) //$db, $numxpag, $pag=1, $tipo = NULL, $nome = NULL, $idproprio = NULL) {
    {
	       
        $sql = new Sql($ParametersList['db_adapter']);
        $operation = $sql->select();
        $operation->from(array('A' => PREFIX.'dashboard_logs_errors'),
                        array(   'id',
                                 'error_type', 
                                 'message', 
                                 'method',
                                 'class',
                                 'file', 
                                 'error_file',
                                 'backtrace',
                                 'ip_address',
                                 'created_by',
                                 'data_creation',
                                 'status'));
        
		
		if (isset($tipo)) 
        {
			switch($tipo)
            {
					case 2: $operation->where('error_type = 0'); break;
					case 1: $operation->where('error_type = 1'); break;
						
			}
		}
        
        (isset($ParametersList['status']) && ($ParametersList['status'] != ''))? $operation->where("status = ".$ParametersList['status']) : NULL;
        (isset($ParametersList['own_element']) && ($ParametersList['own_element'] != ''))? $operation->where("created_by = ".$ParametersList['own_element']) : NULL; 
        (isset($ParametersList['text']) && ($ParametersList['text'] != ''))? $operation->where('message LIKE "%'.$ParametersList['text'].'%" OR class LIKE "%'.$ParametersList['text'].'%" OR error_file LIKE "%'.$ParametersList['text'].'%" ') : NULL; 
        $operation->order(array('data_creation'));
			
		/* DEBUG */
		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
  		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */
		
		$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
        
		if ($resData) {
                        				
			return ( ($ParametersList['pagination']) ? self::GetPagination($ParametersList['elements_in_page'], $ParametersList['page'], $resData->toArray()) :$resData );
		}
        else
        {    
			return false;
        }
	}
	    		
	/**
	 * Funzione che permette di approvare un utente.
	 * 
	 * @param mssql $db Risorsa del database da utilizzare
	 * @param mssql $id id dell\'utente da approvare
	 * 
	 * @return array $ret Array con il risultato della query eseguita su database,
	 * contiene le informazioni sulle aree del backoffice
	 */	
	public static function Approve($db, $id) 
    {	   
        return self::ApproveMaster($db, 'dashboard_logs_errors', $id);
	}
	
	/**
	 * Funzione che permette di disapprovare un utente.
	 * 
	 * @param mssql $db Risorsa del database da utilizzare
	 * @param mssql $id id dell\'utente da disapprovare
	 * 
	 * @return array $ret Array con il risultato della query eseguita su database,
	 * contiene le informazioni sulle aree del backoffice
	 */	
	public static function Disapprove($db, $id) 
    {	   
		return self::DisapproveMaster($db, 'dashboard_logs_errors', $id);
	}
	
	/**
	 * Funzione che permette di disapprovare un utente.
	 * 
	 * @param mssql $db Risorsa del database da utilizzare
	 * @param mssql $id id dell\'utente da disapprovare
	 * 
	 * @return array $ret Array con il risultato della query eseguita su database,
	 * contiene le informazioni sulle aree del backoffice
	 */	
	public static function OtherStatus($db, $id, $status) 
    {	   
		return self::ChangeStatus($db, 'dashboard_logs_errors', $id, $status, 'id');
	}
	
}
?>