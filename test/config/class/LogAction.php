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

class LogAction extends OriginAbstract 
{
	
	/**
	 * Id del log (interno al sistema)
	 * @var int
	 */
	
	public $id = NULL;
	
	/**
	 * Id del tipo di modifica effettuata
	 * Valori possibili :
	 * 	1	(crea)
	 * 	2 	(modifica)
	 * 	3 	(cancella) 
	 * 	4 	(pubblica)
	 * 	5 	(recupero)
	 *
	 * @var int
	 */
	 
	public $id_action = NULL;
	
	/**
	 * Id del tipo di contenuto modificato, si riferisce all'area di appartenenza
	 * Valori possibili :
	 * 	1	(punto vendita)
	 * 	2	(news)
	 * 	3	(redazionale)
	 * 	4	(promozione)
	 * 	5	(homepage)
	 * 	6	(campagna)
	 * 	7	(report)
	 * 	8	(utenti boffice)
	 *  9	(promozione master)
	 *
	 * @var int
	 */
	 
	public $type_content = NULL;
	
	/**
	 * Tipo da gestire, se Action o Error
	 *
	 * @var String
	 */
	 
	public $type = NULL;
	
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
	 
	public $created_by = NULL;
	
	/**
	 * Id dell'elemento modificato
	 *
	 * @var int
	 */
	 
	public $id_element = NULL;
	
	/**
	 * Data in cui è stata effettuata l'operazione, viene inserita automaticamente
	 *
	 * @var date
	 */
	 
	public $data_creation = NULL;
	
	/**
	 * Eventuali note per l'operazione
	 *
	 * @var string
	 */
	 
	public $note = NULL;
	
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
	 
	public $error_code = NULL;
    
	/**
	 * Eventuali note per l'operazione
	 *
	 * @var string
	 */
	 
	public $error_file = NULL;
        
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
	 
	public function __construct(
                                $db,
                                $id_action,
                                $method,
                                $class,
                                $file,
                                $id_element,
                                $created_by = NULL,
                                $note = NULL
                                ) 
    {
		$this->db = $db;
        $this->ip_address = @Common::get_client_ip();
        
		$this->id_action 			= $id_action;
		$this->method 			    = $method;
		$this->class 			    = $class;
		$this->file 			    = $file;
		$this->id_element 			= $id_element;
		$this->note          		= $note;
        $this->created_by           = ID_USER_LOG; 
	}
	
	
	/**
	 * Funzione che recupera un log di un\'azione dato un determinato Id
	 *
	 * @param int $id Id del log di cui recuperare le informazioni
	 * @return boolean $ret esito del recupero dei dati
	 *
	 */
	
	public function GetElement($id) 
    {
		$ret = false;
		
		if ( isset($id) && ($id != '') ) {
		  
            $sql = new Sql($this->db);
            $operation = $sql->select();
            $operation->from(  array('S' => PREFIX.'dashboard_log_azioni'),
                            array(  'id',                                    
                                    'id_action',
                                    'method',
                                    'class',
                                    'file', 
                                    'id_element',
                                    'note',
                                    'ip_address',
                                    'created_by',
                                    'data_creation',
                                    'status'
                                 ) );
                                 
            $operation->where(array('id' => 1));
			
			/* DEBUG */
			$debug_sql = $sql->getSqlStringForSqlObject($operation); 
      		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
			/* ***** */
			
			$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
			
			if ($row = $resData->current()) 
            {
				$this->id 				    = $row['id'];
				$this->id_action 			= $row['id_action'];
				$this->method 			    = $row['method'];
				$this->class 			    = $row['class'];
				$this->file 			    = $row['file'];
				$this->id_element 			= $row['id_element'];
				$this->note          		= $row['note'];
				$this->ip_address 			= $row['ip_address'];
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
	 * Funzione che inserisce il log dell'operazione compiuta su backoffice
	 *
	 * @param mysqli $db Risorsa del database da utilizzare
	 * @param int $id_action Id del tipo di modifica
	 * @param int $type_content Id del tipo di contenuto modificato
	 * @param int $created_by Id dell'utente che ha effettuato la modifica
	 * @param int $id_element Id dell'elemento modificato
	 * @param string $note Eventuali note per la modifica
	 * 
	 * @return boolean $ret esito del recupero dei dati
	 *
	 */
	public function Insert() 
    {		
		$ret = false;

        $sql = new Sql($this->db);        
        $operation = $sql->insert(PREFIX.'dashboard_log_azioni');
        $newData = array(
                            'id_action'     => $this->id_action,
                            'method'        => $this->method,
                            'class'         => $this->class,
                            'file'          => $this->file,
                            'id_element'    => (isset($this->id_element) ? $this->id_element : 'NULL' ),
                            'note'          => $this->note,
                            'ip_address'    => $this->ip_address,
                            'created_by'    => $this->created_by,
                            'data_creation' => gmdate("Y-m-d H:i:s"),
                            'status'        => 0,
                        );
                        
        $operation->values($newData);
		
		/* DEBUG */
		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */
        
	    if(self::executeQuery($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG))
        {            			
			$ret = true;			
		}
        else
        {      
			return false;
		}
		
		
		return $ret;
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
	public static function GetElementsList($ParametersList) {
	        
        $sql = new Sql($ParametersList['db_adapter']);
        $operation = $sql->select();
        $operation->from(array('A' => PREFIX.'dashboard_log_azioni'),
                        array(  'id',
                                'id_action',
                                'method',
                                'class',
                                'file', 
                                'id_element',
                                'note',
                                'ip_address',
                                'created_by',
                                'data_creation',
                                'status'));
        
		
		if (isset($tipo)) 
        {
			switch($tipo)
            {
					case 2: $operation->where('status = 0'); break;
					case 1: $sql .= $operation->where('status = 1'); break;
						
			}
		}
        
        (isset($ParametersList['own_element']) && ($ParametersList['own_element'] != ''))? $operation->where("created_by = ".$ParametersList['own_element']) : NULL; 
        (isset($ParametersList['text']) && ($ParametersList['text'] != ''))? $operation->where('note LIKE "%'.$ParametersList['text'].'%" OR class LIKE "%'.$ParametersList['text'].'%" OR file LIKE "%'.$ParametersList['text'].'%" OR ip_address LIKE "%'.$ParametersList['text'].'%" OR method LIKE "%'.$ParametersList['text'].'%"') : NULL; 
        (isset($ParametersList['id_action']) && ($ParametersList['id_action'] != ''))? $operation->where("id_action = ".$ParametersList['id_action']) : NULL; 
        $operation->order(array('data_creation'));
        
		
		/* DEBUG */
		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */
                 
        $resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
        
		if ($resData) {
            				
			return $resData; //self::GetPagination($numxpag, $pag, $resData);
            			
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
        return Common::Approve($db, 'dashboard_logs_errors', $id);
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
		return Common::Disapprove($db, 'dashboard_logs_errors', $id);
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
		return Common::OtherStatus($db, 'dashboard_logs_errors', $id, $status);
	}
	
}
?>