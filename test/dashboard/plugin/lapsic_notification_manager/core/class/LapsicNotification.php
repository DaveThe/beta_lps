<?php 
namespace Dashboard;
/**
 * La class lapsic_user contiene le operazioni relative ai dati di lapsic_user.
 * 
 *
 * @version   1.00
 * @since     2015-05-17
 */
 

use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Adapter\Adapter; 

class LapsicNotification extends OriginAbstract 
{
	
	/**
	* Parametro che indica l'id univoco del record
	*
	* @var int
	*/
	public $id 		        	= NULL;
	
	
	/**
	* Parametro che indica il tipo di notifica
	*
	* @var string
	*/
    public $type     		    = NULL;
	
	
	/**
	* Parametro che indica la password criptata
	*
	* @var string
	*/
    public $id_record 		    = NULL;
	
	/**
	* Parametro che indica quale utente ha innescato la creazione della notifica
    * 
	* @var int
	*/
    public $id_user_source      = NULL;
	
	
	/**
	* Parametro che indica a quale utente è destinata la notifica
    * 
	* @var int
	*/
    public $id_user_dest        = NULL;
    
	
	/**
	* Parametro che indica l'indirizzo ip di iscrizione dell'utente
	*
	* @var string
	*/
    public $ip_address 		    = NULL;
	
	
	/**
	* Parametro che indica chi ha creato o modificato questo record l'ultima volta
	*
	* @var int
	*/
    public $created_by 		    = NULL;
	
	
	/**
	* Parametro che indica la data di creazione del record
	*
	* @var int
	*/
    public $data_creation 		= NULL;
	
	
	/**
	* Parametro che indica lo stato di attivazione del record
	* 1	(Abilitato)
	* 0	(Disabilitato)
	* @var int
	*/
    public $status 		        = NULL;
    
	/**
	 * Costruttore della classe
	 *
	 * @param db_adapter $db Risorsa del database da utilizzare
	 *
	 */
	public function __construct($db) {
		$this->db = $db;
	}
		
	/**
	 * Funzione che recupera i dati di un recordo dato un id
	 *
	 * @param int $id Id del record di cui recuperare le informazioni
	 * @return boolean $ret esito del recupero dei dati
	 *
	 */
	
	public function GetElement($id) 
    {
		$ret = false;
		
		if ( isset($id) && ($id != '') ) {
		  
            $sql = new Sql($this->db);
            $operation = $sql->select();
            $operation->from(  array('H' => PREFIX.'lapsic_notification'),
                            array(  
                                    'id',
                                    'type',
                                    'id_record',
                                    'id_user_source',
                                    'id_user_dest',
                                    'ip_address',
                                    'created_by',
                                    'DATE_FORMAT(data_creation, "%d/%m/%Y %H:%i:%s") AS data_creation',
                                    'status'
                                 ) );
        
    		$operation->join(array('U' => PREFIX.'lapsic_user'),'U.id = H.id_user_source',
    										array( 'user_source' => 'username' ) 
    									);
        
    		$operation->join(array('UD' => PREFIX.'lapsic_user'),'UD.id = H.id_user_dest',
    										array( 'user_dest' => 'username' ) 
    									);
                                 
            $operation->where(array('H.id' => $id));
			
			/* DEBUG */
			$debug_sql = $sql->getSqlStringForSqlObject($operation); 
      		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
			/* ***** */
            
			$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
			
			if ($row = $resData->current()) 
            {
            	$this->id 		        	= $row['id'];
                $this->type      		    = $row['type'];
                $this->id_record 		    = $row['id_record'];
                $this->user_source		    = $row['user_source'];
                $this->user_dest	        = $row['user_dest'];
                $this->ip_address 		    = $row['ip_address'];
                $this->created_by 		    = $row['created_by'];
                $this->data_creation 		= $row['data_creation'];
                $this->status 		        = $row['status'];
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
	 * Funzione che permette l'aggiornamento dei dati dell'utente nel database.
	 * 
	 *
	 * @return boolean $ret Esito dell'aggiornamento dei dati
	 */	
	 public function update()
	 {
		$ret = false;
		
        $sql = new Sql($this->db);
		$operation = $sql->update(PREFIX.'lapsic_notification');
		$newData = array(                            
                            'type'            => isset($this->type) ? $this->type : 'NULL',
                            'id_record'       => isset($this->id_record) ? $this->id_record : 'NULL',
                            'id_user_source'  => isset($this->id_user_source) ? $this->id_user_source : 'NULL',
                            'id_user_dest'    => isset($this->id_user_dest) ? $this->id_user_dest : 'NULL',
                            'created_by'      => isset($this->created_by) ? $this->created_by : 'NULL',
							'status'          => isset($this->status)?$this->status:'0'	
                        );
						
		$operation->set($newData);
		$operation->where('id = '.$this->id);
		
		/* DEBUG */
			$debug_sql = $sql->getSqlStringForSqlObject($operation); 
      		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */

        if(self::executeQuery($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG))
        {
           	$ret= true; 
        }
        else
        {                
			return false;
        }		
		
		return $ret;
	 }
     
     
	
	/**
	 * Funzione che inserisce un nuovo recordo della classe
	 * 
	 * @return boolean $ret esito del recupero dei dati
	 *
	 */
	public function Insert() 
    {		
		$ret = false;

        $sql = new Sql($this->db);        
        $operation = $sql->insert(PREFIX.'lapsic_notification');
        $newData = array(                                                                
                            'type'            => isset($this->type) ? $this->type : 'NULL',
                            'id_record'       => isset($this->id_record) ? $this->id_record : 'NULL',
                            'id_user_source'  => isset($this->id_user_source) ? $this->id_user_source : 'NULL',
                            'id_user_dest'    => isset($this->id_user_dest) ? $this->id_user_dest : 'NULL',
                            'ip_address'    => isset($this->ip_address) ? $this->ip_address : 'NULL',
                            'created_by'    => isset($this->created_by) ? $this->created_by : 'NULL',
							'status'        => isset($this->status)?$this->status:'0'
                        );
                        
        $operation->values($newData);
		
		/* DEBUG */
		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */
		
	    if(self::executeQuery($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG))
        {            		
			$this->id = self::getLastId($this->db);	
			$ret = true;			
		}
        else
        {      
			return false;
		}
		
		
		return $ret;
	}		
     
	
	/**
	 * Funzione che inserisce un nuovo recordo della classe
	 * 
	 * @return boolean $ret esito del recupero dei dati
	 *
	 */
	public function InsertNotify() 
    {		
		$ret = false;

        $sql = new Sql($this->db);        
        $operation = $sql->insert(PREFIX.'lapsic_notify');
        $newData = array(                                                                
                            'icon'            => isset($this->icon) ? $this->icon : 'NULL',
                            'text'            => isset($this->text) ? $this->text : 'NULL',
                            'user_source'     => isset($this->user_source) ? $this->user_source : 'NULL',
                            'id_user_dest'    => isset($this->id_user_dest) ? $this->id_user_dest : 'NULL',
                            'created_by'      => isset($this->created_by) ? $this->created_by : 'NULL',
							'status'          => isset($this->status)?$this->status:'0'
                        );
                        
        $operation->values($newData);
		
		/* DEBUG */
		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */
		
	    if(self::executeQuery($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG))
        {            		
			$this->id = self::getLastId($this->db);	
			$ret = true;			
		}
        else
        {      
			return false;
		}
		
		
		return $ret;
	}
    
    	
	/**
	 * Funzione che permette l'aggiornamento dei dati dell'utente nel database.
	 * 
	 *
	 * @return boolean $ret Esito dell'aggiornamento dei dati
	 */	
	 public function UpdateNotify()
	 {
		$ret = false;
		
        $sql = new Sql($this->db);
		$operation = $sql->update(PREFIX.'lapsic_notify');
		$newData = array(                            
                            'icon'            => isset($this->icon) ? $this->icon : 'NULL',
                            'text'            => isset($this->text) ? $this->text : 'NULL',
                            'user_source'     => isset($this->user_source) ? $this->user_source : 'NULL',
                            'id_user_dest'    => isset($this->id_user_dest) ? $this->id_user_dest : 'NULL',
                            'created_by'      => isset($this->created_by) ? $this->created_by : 'NULL',
							'status'          => isset($this->status)?$this->status:'0'
                        );
						
		$operation->set($newData);
		$operation->where('id = '.$this->id);
		
		/* DEBUG */
			$debug_sql = $sql->getSqlStringForSqlObject($operation); 
      		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */

        if(self::executeQuery($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG))
        {
           	$ret= true; 
        }
        else
        {                
			return false;
        }		
		
		return $ret;
	 }
    
	/**
	 * Funzione che permette l'eliminazione del record.
	 * 
	 * @param db_adapter $db Risorsa del database da utilizzare
	 * @param int $id Id del record da eliminare
	 * @return boolean $ret Esito dell'eliminazione dei dati
	 */	
	public static function Delete($db, $id) 
    {	
        return self::DeleteMaster($db, 'lapsic_notify', 'id', $id);        
	}
    	
			
	/**
	 * Funzione che permette di approvare un utente.
	 * 
	 * @param db_adapter $db Risorsa del database da utilizzare
	 * @param int $id Id del record da da approvare
	 * 
	 * @return boolean $ret Esito dell'operazione sui dati
	 */	
	public static function Approve($db, $id) 
    {	   
        return self::ApproveMaster($db, 'lapsic_notify', $id);
	}
	
	/**
	 * Funzione che permette di disapprovare un utente.
	 * 
	 * @param db_adapter $db Risorsa del database da utilizzare
	 * @param int $id Id del record da disapprovare
	 * 
	 * @return boolean $ret Esito dell'operazione sui dati
	 */	
	public static function Disapprove($db, $id) 
    {	   
		return self::DisapproveMaster($db, 'lapsic_notify', $id);
	}


    
	/**
	 * Funzione che permette di recuperare l'elenco dei record richiesti.
	 * 
	 * @param array $ParametersList Risorsa contenente i filtri da applicare per recuperare i dati richiesti
	 *
	 * @return array $ret Array con i dati ottenuti dalla query su database
	 */	
	public static function GetElementsList($ParametersList)
    {
	       
        $sql = new Sql($ParametersList['db_adapter']);
        $operation = $sql->select();
        $operation->from(array('H' => PREFIX.'lapsic_notify'),
                        array(  
                                'id',
                                'icon',
                                'text',
                                'user_source',
                                'id_user_dest',
                                'DATE_FORMAT(data_creation, "%d/%m/%Y %H:%i:%s") AS data_creation',
                                'status'));         
                                    
		if (isset($ParametersList['status'])) 
        {
			switch($ParametersList['status'])
            {
					case 2: $operation->where('status = 0'); break;
					case 1: $operation->where('status = 1'); break;
						
			}
		}
        
        (isset($ParametersList['own_element']) && ($ParametersList['own_element'] != ''))? $operation->where("created_by = ".$ParametersList['own_element']) : NULL; 
        (isset($ParametersList['text']) && ($ParametersList['text'] != ''))? $operation->where('text LIKE "%'.$ParametersList['text'].'%" OR user_source LIKE "%'.$ParametersList['text'].'%"') : NULL; 
        $operation->order(array('H.data_creation'));
		
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
    
    public function convertHashtags($string_to_hashtags){
    	$regex = "/#+([a-zA-Z0-9_]+)/";
    	//$hashtags = preg_replace($regex, '<a href="hashtag.php?tag=$1">$0</a>', $string_to_hashtags);
        preg_match_all($regex, $string_to_hashtags,$hashtags,PREG_PATTERN_ORDER);
    	return($hashtags);
    }
    
    public function CallNotify()
    {
        $statement = $this->db->query("CALL analyze_notification()");
                                    
        $results = $statement->execute();
        $results->buffer();
        
        if ($results->count() > 0) 
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function CallCounter()
    {
        $statement = $this->db->query("CALL analyze_notification_counter()");
                                    
        $results = $statement->execute();
        $results->buffer();
        
        if ($results->count() > 0) 
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    
	/**
	 * Funzione che permette di creare la tabella nel database.
	 *  
	 * @return boolean $ret Esito dell'operazione sui dati
	 */	
	public function CreateTable() 
    {	 
		
		$statement_lapsic_hashtag = $this->db->query("SHOW TABLES LIKE 'lapsic_notification'");
                                    
        $results_lapsic_hashtag = $statement_lapsic_hashtag->execute();
        $results_lapsic_hashtag->buffer();
        //var_dump($results_lapsic_hashtag);
		if ($results_lapsic_hashtag->count() > 0) 
        {
            //echo 'esiste lapsic_hashtag';
        }
        else
        {
            //echo 'non esiste lapsic_hashtag';
            
             $statement_lapsic_hashtag = $this->db->query("                   
                                                                    
                                    CREATE TABLE `lapsic_notification` (
                                      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                      `type` varchar(255) NOT NULL COMMENT 'id di riferimento al tipo di notifica',
                                      `id_record` int(20) NOT NULL COMMENT 'id di riferimento al record',
                                      `id_user_source` int(10) NOT NULL COMMENT 'id di riferimento utente sorgente',
                                      `id_user_dest` int(10) NOT NULL COMMENT 'id di riferimento utente destinatario',
                                      `ip_address` VARCHAR(45) NOT NULL COMMENT 'indirizzo ip di chi ha inserito il tag',
                                      `created_by` int(10) NOT NULL COMMENT 'id di chi ha creato il record',
                                      `data_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'data creazione del record',
                                      `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'attivo = 1, inattivo = 0',
                                      PRIMARY KEY (`id`)
                                    ) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

                                   ");
                                        
            $results_lapsic_hashtag = $statement_lapsic_hashtag->execute();
            $results_lapsic_hashtag->buffer();
        }
        
        
		$statement_lapsic_hashtag_dat = $this->db->query("SHOW TABLES LIKE 'lapsic_notify'");
                                    
        $results_lapsic_hashtag_data = $statement_lapsic_hashtag_dat->execute();
        $results_lapsic_hashtag_data->buffer();
        //var_dump($results_lapsic_hashtag_data);
        
		if ($results_lapsic_hashtag_data->count() > 0) 
        {
            //echo 'esiste lapsic_hashtag_data';
        }
        else
        {
            //echo 'non esistelapsic_hashtag_data';
                     
            $statement_lapsic_hashtag_dat = $this->db->query("
                                   CREATE TABLE `lapsic_notify` (
                                  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                  `icon` varchar(255) NOT NULL COMMENT 'id record di riferimento',
                                  `text` text NOT NULL COMMENT 'testo descrittivo della notifica',
                                  `user_source` varchar(40) NOT NULL COMMENT 'utente che ha generato la notifica',
                                  `id_user_dest` int(11) NOT NULL COMMENT 'utente che riceve la notifica',
                                  `created_by` int(10) NOT NULL COMMENT 'id di chi ha creato il record',
                                  `data_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'data creazione del record',
                                  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'attivo = 1, inattivo = 0',
                                  PRIMARY KEY (`id`)
                                );");
                                        
            $results_lapsic_hashtag_data = $statement_lapsic_hashtag_dat->execute();
            $results_lapsic_hashtag_data->buffer();
        }
        
	}
	    
}
?>