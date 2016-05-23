<?php 
namespace Dashboard;
/**
 * La class LapsicPhotoData contiene le operazioni relative ai dati aggiuntivi di lapsic_user.
 * 
 *
 * @version   1.00
 * @since     2015-05-17
 */
 

use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Adapter\Adapter; 

class LapsicPhotoData extends OriginAbstract 
{
	
	/**
	* Parametro che indica l'id univoco del record
	*
	* @var int
	*/
	public $id 		        	= NULL;
	
	
	/**
	* Parametro che indica l'id_photo dell'utente
	*
	* @var string
	*/
    public $id_photo 		    = NULL;
	
	
	/**
	* Parametro che indica il description dell'utente
	*
	* @var string
	*/
    public $description 		    = NULL;
	
	
	/**
	* Parametro che indica il cognome del'utente
	*
	* @var string
	*/
    public $value 		    = NULL;
	
	
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
            $operation->from(  array('S' => PREFIX.'lapsic_photo_data'),
                            array(  
                                    'id',
                                    'id_photo',
                                    'description',
                                    'value',
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
                $this->id_photo 		    = $row['id_photo'];
                $this->description 		    = $row['description'];
                $this->value 		        = $row['value'];
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
		$operation = $sql->update(PREFIX.'lapsic_photo_data');
		$newData = array(                            
                            'id_photo'      => isset($this->id_photo) ? $this->id_photo : 'NULL',
                            'description'      => isset($this->description) ? $this->description : 'NULL',
                            'value'       => isset($this->value) ? $this->value : 'NULL',
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
        $operation = $sql->insert(PREFIX.'lapsic_photo_data');
        $newData = array(                                                      
                            'id_photo'       => isset($this->id_photo) ? $this->id_photo : 'NULL',
                            'description'   => isset($this->description) ? $this->description : 'NULL',
                            'value'         => isset($this->value) ? $this->value : 'NULL',
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
        return self::DeleteMaster($db, 'lapsic_photo_data', 'id', $id);
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
        return self::ApproveMaster($db, 'lapsic_photo_data', $id);
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
		return self::DisapproveMaster($db, 'lapsic_photo_data', $id);
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
        $operation->from(array('A' => PREFIX.'lapsic_photo_data'),
                        array(  
                                'id',
                                'id_photo',
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
	public static function GetElementsListByPhoto($ParametersList)
    {
	       
        $sql = new Sql($ParametersList['db_adapter']);
        $operation = $sql->select();
        $operation->from(array('UD' => PREFIX.'lapsic_photo_data'),
                        array(  'id',
                                'description',
                                'value'));
        
		$operation->join(array('GE' => PREFIX.'lapsic_photo_group_extra'),'GE.id = UD.id_group',
										array( 'group_description' => 'description' ) 
									);
		
        (isset($ParametersList['id_photo']) && ($ParametersList['id_photo'] != ''))? $operation->where("id_photo = ".$ParametersList['id_photo']) : NULL;
        (isset($ParametersList['own_element']) && ($ParametersList['own_element'] != ''))? $operation->where("created_by = ".$ParametersList['own_element']) : NULL; 
        (isset($ParametersList['text']) && ($ParametersList['text'] != ''))? $operation->where('description LIKE "%'.$ParametersList['text'].'%" OR value LIKE "%'.$ParametersList['text'].'%"') : NULL; 
        //$operation->order(array('data_creation'));
		$operation->group("UD.id");
		$operation->group("GE.description");
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
                $Arrextra[$res->group_description][] = array('status'           => $res->status,
                                                             'id'               => $res->id, 
                                                             'description'      => $res->description, 
                                                             'value'            => $res->value, 
                                                             'data_creation'    => $res->data_creation
                                                             );
            }            				
			return $Arrextra;//( ($ParametersList['pagination']) ? self::GetPagination($ParametersList['elements_in_page'], $ParametersList['page'], $resData->toArray()) :$resData );
		}
        else
        { 
			return false;
        }
	}		
}
?>