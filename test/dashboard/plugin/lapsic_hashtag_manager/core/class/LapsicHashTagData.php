<?php 
namespace Dashboard;
/**
 * La class lapsic_user_data contiene le operazioni relative ai dati aggiuntivi di lapsic_user.
 * 
 *
 * @version   1.00
 * @since     2015-05-17
 */
 

use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Adapter\Adapter; 

class LapsicHashTagData extends OriginAbstract 
{
	
	/**
	* Parametro che indica l'id univoco del record
	*
	* @var int
	*/
	public $id 		        	= NULL;
	
	
	/**
	* Parametro che indica l'id_record a cui è stato associato un tag
	*
	* @var string
	*/
    public $id_record 		    = NULL;
	
	
	/**
	* Parametro che indica l'id dell'hashtag
	*
	* @var string
	*/
    public $id_tag 		    = NULL;
	
	
	/**
	* Parametro che indica un'eventuale descrizione della relazione record->tag
	*
	* @var string
	*/
    public $description 		    = NULL;
	
	
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
            $operation->from(  array('S' => PREFIX.'lapsic_hashtag_relationship'),
                            array(  
                                    'id',
                                    'id_record',
                                    'id_tag',
                                    'description',
                                    'created_by',
                                    'DATE_FORMAT(data_creation, "%d/%m/%Y %H:%i:%s") AS data_creation',
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
            	$this->id 		        	= $row['id'];
                $this->id_record	        = $row['id_record'];
                $this->id_tag 		        = $row['id_tag'];
                $this->description 		    = $row['description'];
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
		$sec = new Secret();
		$ret = false;
		
        $sql = new Sql($this->db);
		$operation = $sql->update(PREFIX.'lapsic_hashtag_relationship');
		$newData = array(                            
                            'id_record'     => isset($this->id_record) ? $this->id_record : 'NULL',
                            'id_tag'        => isset($this->id_tag) ? $this->id_tag : 'NULL',
                            'description'   => isset($this->description) ? $this->description : 'NULL',
                            'created_by'    => isset($this->created_by) ? $this->created_by : 'NULL',
							'status'        => isset($this->status)?$this->status:'0'	
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
        $operation = $sql->insert(PREFIX.'lapsic_hashtag_relationship');
        $newData = array(                                               
                            'id_record'     => isset($this->id_record) ? $this->id_record : 'NULL',
                            'id_tag'        => isset($this->id_tag) ? $this->id_tag : 'NULL',
                            'description'   => isset($this->description) ? $this->description : 'NULL',
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
	 * Funzione che permette l'eliminazione del record.
	 * 
	 * @param db_adapter $db Risorsa del database da utilizzare
	 * @param int $id Id del record da eliminare
	 * @return boolean $ret Esito dell'eliminazione dei dati
	 */	
	public static function Delete($db, $id) 
    {	
        return self::DeleteMaster($db, 'lapsic_hashtag_relationship', 'id', $id);
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
        return self::ApproveMaster($db, 'lapsic_hashtag_relationship', $id);
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
		return self::DisapproveMaster($db, 'lapsic_hashtag_relationship', $id);
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
        $operation->from(array('A' => PREFIX.'lapsic_hashtag_relationship'),
                        array(  
                                'id',
                                'id_record',
                                'id_tag',
                                'description',
                                'created_by',
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
        
        (isset($ParametersList['id_record']) && ($ParametersList['id_record'] != ''))? $operation->where("id_record = ".$ParametersList['id_record']) : NULL;
        (isset($ParametersList['id_tag']) && ($ParametersList['id_tag'] != ''))? $operation->where("id_tag = ".$ParametersList['id_tag']) : NULL; 
        (isset($ParametersList['own_element']) && ($ParametersList['own_element'] != ''))? $operation->where("created_by = ".$ParametersList['own_element']) : NULL;
        (isset($ParametersList['text']) && ($ParametersList['text'] != ''))? $operation->where('description LIKE "%'.$ParametersList['text'].'%"') : NULL; 
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
	 * Funzione che permette di recuperare l'elenco dei record richiesti.
	 * 
	 * @param array $ParametersList Risorsa contenente i filtri da applicare per recuperare i dati richiesti
	 *
	 * @return array $ret Array con i dati ottenuti dalla query su database
	 */	
	public static function GetElementsListGroup($ParametersList)
    {
	       
        $sql = new Sql($ParametersList['db_adapter']);
        $operation = $sql->select();
        $operation->from(array('A' => PREFIX.'lapsic_hashtag_group'),
                        array(  
                                'id',
                                'description',
                                'value',
                                'created_by',
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
        (isset($ParametersList['text']) && ($ParametersList['text'] != ''))? $operation->where('description LIKE "%'.$ParametersList['text'].'%" OR value LIKE "%'.$ParametersList['text'].'%"') : NULL; 
        $operation->order(array('value'));
		
		/* DEBUG */
		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */
        
		$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
        
		if ($resData) 
        {
            $Arrextra = array();
            foreach($resData as $res)
            {
                $Arrextra[] = array(
                                                             'id'               => $res->id, 
                                                             'description'      => $res->description, 
                                                             'value'            => $res->value                                                             
                                                             );
            }            				
			return $Arrextra;
		}
        else
        { 
			return false;
        }
	}		
}
?>