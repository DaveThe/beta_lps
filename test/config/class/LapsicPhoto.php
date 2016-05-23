<?php 
namespace Lapsic;
/**
 * La class lapsic_photo contiene le operazioni relative ai dati di lapsic_photo.
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

class LapsicPhoto extends OriginAbstract 
{
	
	/**
	* Parametro che indica l'id univoco del record
	*
	* @var int
	*/
	public $id 		        	= NULL;
	
	
	/**
	* Parametro che indica il nome della foto
	*
	* @var string
	*/
    public $name 		        = NULL;
	
	
	/**
	* Parametro che indica la descrizione della foto
	*
	* @var string
	*/
    public $description		    = NULL;
	
	
	/**
	* Parametro che indica la latitudine dello scatto
	*
	* @var string
	*/
    public $lat      		    = NULL;
	
	
	/**
	* Parametro che indica la longitudine dello scatto
	*
	* @var string
	*/
    public $lng 		        = NULL;
	
	
	/**
	* Parametro che indica la latitudine dello scatto
	*
	* @var string
	*/
    public $width      		    = NULL;
	
	
	/**
	* Parametro che indica la longitudine dello scatto
	*
	* @var string
	*/
    public $height 		        = NULL;
	
	
	/**
	* Parametro che indica il cognome del'utente
	*
	* @var string
	*/
    public $id_owner 		    = NULL;
	
	
	/**
	* Parametro che indica il tempo rimasto
	*
	* @var string
	*/
    public $time_left	        = NULL;
	
	
	/**
	* Parametro che indica il colore primario
	*
	* @var int
	*/
    public $average_colour      = NULL;
	
	
	/**
	* Parametro che indica il nome del file dell'immagine
	*
	* @var string
	*/
    public $source_path 		= NULL;
	
	
	/**
	* Parametro che indica il nome del file dell'immagine orginale
	*
	* @var string
	*/
    public $source_name 		        = NULL;
	
	
	/**
	* Parametro che indica la nazione dell'utente
	*
	* @var int
	*/
    public $country 		    = NULL;
	
	
	/**
	* Parametro che indica la città dell'utente
	*
	* @var int
	*/
    public $city 		        = NULL;
	
    
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
        $this->ip_address = @Common::get_client_ip();
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
            $operation->from(  array('S' => PREFIX.'lapsic_photo'),
                            array(  
                                    'id',
                                    'name',
                                    'description',
                                    'lat',
                                    'lng',
                                    'width',
                                    'height',
                                    'id_owner',
                                    'time_left',
                                    'average_colour',
                                    'source_path',
                                    'source_name',
                                    'country',
                                    'city',
                                    'ip_address',
                                    'created_by',
                                    'DATE_FORMAT(data_creation, "%d/%m/%Y %H:%i:%s") AS data_creation',
                                    'status'
                                 ) );        
        
            $operation->join(array('U' => PREFIX.'lapsic_user'),'U.id = S.id_owner',
										array( 'user' => 'username' ) 
									);   
                                 
            $operation->where(array('S.id' => $id));
			
			/* DEBUG */
			$debug_sql = $sql->getSqlStringForSqlObject($operation); 
      		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
			/* ***** */
			
			$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
			
			if ($row = $resData->current()) 
            {
            	$this->id 		        	= $row['id'];
            	$this->name 		        = $row['name'];
                $this->description 		    = $row['description'];
                $this->lat 		            = $row['lat'];
                $this->lng 		            = $row['lng'];
                $this->width	            = $row['width'];
                $this->height	            = $row['height'];
                $this->id_owner 		    = $row['id_owner'];
                $this->user      		    = $row['user'];
                $this->time_left 		    = $row['time_left'];
                $this->average_colour 		= $row['average_colour'];
                $this->source_path 		    = $row['source_path'];
                $this->source_name 		    = $row['source_name'];
                $this->country 		        = $row['country'];
                $this->city 		        = $row['city'];
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
		$operation = $sql->update(PREFIX.'lapsic_photo');
		$newData = array(                            
                            'name'              =>  $this->name,
                            'description'       =>  $this->description,
                            'lat'               =>  $this->lat,
                            'lng'               =>  $this->lng,
                            'width'             =>  $this->width,
                            'height'            =>  $this->height,
                            'id_owner'          =>  $this->id_owner,
                            'time_left'         =>  $this->time_left,
                            'average_colour'    =>  $this->average_colour,
                            'source_path'       =>  $this->source_path,
                            'source_name'       =>  $this->source_name,
                            'country'           =>  $this->country,
                            'city'              =>  $this->city,
                            'created_by'        =>  $this->created_by,
							'status'            => $this->status	
                        );
						
		$operation->set($newData);
		$operation->where('id = '.$this->id);
		
		/* DEBUG */
			$debug_sql = $sql->getSqlStringForSqlObject($operation); 
      		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */
        //echo $debug_sql;
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
        $operation = $sql->insert(PREFIX.'lapsic_photo');
        $newData = array(                                                      
                            'name'              =>  $this->name,
                            'description'       =>  $this->description,
                            'lat'               =>  $this->lat,
                            'lng'               =>  $this->lng,
                            'width'             =>  $this->width,
                            'height'            =>  $this->height,
                            'id_owner'          =>  $this->id_owner,
                            'time_left'         =>  $this->time_left,
                            'average_colour'    =>  $this->average_colour,
                            'source_path'       =>  $this->source_path,
                            'source_name'       =>  $this->source_name,
                            'country'           =>  $this->country,
                            'city'              =>  $this->city,
                            'ip_address'        =>  $this->ip_address,
                            'created_by'        =>  $this->created_by,
                            'data_creation'     => gmdate("Y-m-d H:i:s"),
							'status'            => $this->status
                        );
                        
        $operation->values($newData);
		
		/* DEBUG */
		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */
		//echo $debug_sql;
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
        if(self::DeleteMaster($db, 'lapsic_photo_data', 'id_photo', $id))
        {
            return self::DeleteMaster($db, 'lapsic_photo', 'id', $id);
        }
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
        return self::ApproveMaster($db, 'lapsic_photo', $id);
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
		return self::DisapproveMaster($db, 'lapsic_photo', $id);
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
        $operation->from(array('A' => PREFIX.'lapsic_photo'),
                        array(  
                                'id',
                                'name',
                                'description',
                                'lat',
                                'lng',
                                'width',
                                'height',
                                'id_owner',
                                'A.time_left',
                                'U.time_left AS time_left_user',
                                'average_colour',
                                'source_path',
                                'source_name',
                                'country',
                                'city',
                                'ip_address',
                                'created_by',
                                'DATE_FORMAT(data_creation, "%d/%m/%Y %H:%i:%s") AS data_creation',
                                'status'));           
        
		$operation->join(array('U' => PREFIX.'lapsic_user'),'U.id = A.id_owner',
										array( 'user' => 'username',
                                               'rank' ) 
									);   
                                    
        if(isset($ParametersList['order']))
        {
            if($ParametersList['order'] == 'timers')
            {
                $operation->join(array('H' => PREFIX.'lapsic_notification'),'H.id_user_dest = U.id',
                                array(  
                                        'id_user_dest',
                                        'status'));      
            }
        }

        (isset($ParametersList['status']) && ($ParametersList['status'] != ''))? $operation->where("A.status = ".$ParametersList['status']) : NULL; 
        $operation->where("A.status <> 2");
                
        $date_formt = new   \DateTime('NOW');
                //echo $date_formt->format('Y-m-d H:i:su');
        $current_date = $date_formt->format('Y-m-d H:i:s');
        
        (isset($ParametersList['own_element']) && ($ParametersList['own_element'] != ''))? $operation->where("id_owner = ".$ParametersList['own_element']) : NULL; 
        (isset($ParametersList['text']) && ($ParametersList['text'] != ''))? $operation->where('name LIKE "%'.$ParametersList['text'].'%" OR description LIKE "%'.$ParametersList['text'].'%" OR country LIKE "%'.$ParametersList['text'].'%"') : NULL; 
        //(isset($ParametersList['order']) && ($ParametersList['order'] != 'rank'))? $operation->order(array('A.rank')) : $operation->order(array('A.time_left'));
        //(isset($ParametersList['order']) && ($ParametersList['order'] != 'new'))? $operation->order(array('A.data_creation')) : $operation->order(array('A.time_left'));
        
        $operation->where("A.time_left > UTC_TIMESTAMP");
        (isset($ParametersList['order']) && ($ParametersList['order'] == 'timers')) ? $operation->where(" H.id_user_source = ".$ParametersList['source']." AND H.type = 'image' ") : NULL;
        //$operation->where("A.time_left >= '".$current_date."'");
        if(isset($ParametersList['order']))
        {
            if($ParametersList['order'] == 'rank')
            {
                $operation->order(array('U.rank ASC'));
            }
            elseif($ParametersList['order'] == 'new')
            {
                $operation->order(array('A.data_creation DESC'));
            }
            elseif($ParametersList['order'] == 'timers')
            {
                $operation->group('A.id');
                $operation->order(array('A.time_left DESC'));
            }
            else
            {
                $operation->order(array('A.time_left DESC'));
            }
        }
        /*
        else
        {
            $operation->order(array('A.time_left'));
        }
        */
        if(isset($ParametersList['search']) && $ParametersList['search'] != '') $operation->where("A.id IN (".implode( ',', $ParametersList['search'] ).")");
        
        //(isset($ParametersList['rank']) && ($ParametersList['rank'] != ''))? $operation->order(array('A.rank')) : $operation->order(array('A.time_left'));
		
		/* DEBUG */
		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */
        //echo $debug_sql;
		$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
        
		if ($resData) {
                        				
			return ( ($ParametersList['pagination']) ? self::GetPagination($ParametersList['elements_in_page'], $ParametersList['page'], $resData->toArray()) :$resData );
		}
        else
        { 
			return false;
        }
	}		
    
    public static function getContestElements($ParametersList) //$contest)
    {
        /**
         * ALTERNATIVA 1
         * 
         */
         /* 
        $res = $ParametersList['db_adapter']->query(
                                                "SELECT *, u.nickname AS user
                                                FROM lapsic_photo AS p
                                                JOIN (
                                                		SELECT id_record 
                                                		FROM lapsic_development.lapsic_hashtag_relationship AS hr
                                                		JOIN lapsic_hashtag AS h ON h.id = hr.id_tag
                                                		WHERE h.tag_name LIKE '".$ParametersList['contest']."' OR h.tag_name LIKE '#".$ParametersList['contest']."'
                                                	 ) AS x ON x.id_record = p.id
                                                JOIN lapsic_user AS u ON u.id = p.id_owner;"
                                               );
         */
         $res = $ParametersList['db_adapter']->query(
                                                "SELECT *, u.nickname AS user
                                                FROM lapsic_photo AS p
                                                JOIN lapsic_hashtag_relationship AS hr ON hr.id_record = p.id
                                                JOIN lapsic_hashtag AS h ON h.id = hr.id_tag AND h.tag_name = '".$ParametersList['contest']."'
                                                JOIN lapsic_user AS u ON u.id = p.id_owner;");          
        
        $results = $res->execute();
        if ($results instanceof ResultInterface && $results->isQueryResult()) 
        {                
            $result = new ResultSet();
            $results->buffer();
            $resData = $result->initialize($results);
            return ( ($ParametersList['pagination']) ? self::GetPagination($ParametersList['elements_in_page'], $ParametersList['page'], $resData->toArray()) :$resData ); 
        }
        else
        {
            return false;
        }
    }
		
    public static function GetMosaicList($ParametersList)
    {
         $res = $ParametersList['db_adapter']->query("
                                                     SELECT source_path 
                                                     FROM lapsic_photo
                                                     WHERE id_owner = '".$ParametersList['id']."'
                                                     ORDER BY RAND()
                                                     LIMIT 4;");
         $results = $res->execute();
         
        $returnArray = array();
        
        foreach ($results as $result) {
            $returnArray[] = $result;
        }
        
        return $returnArray;
    }
    
	/**
	 * Funzione che recupera i dati di un recordo dato un id
	 *
	 * @param int $id Id del record di cui recuperare le informazioni
	 * @return boolean $ret esito del recupero dei dati
	 *
	 */	
	public function GetElementCount($id) 
    {
		$ret = false;
		
		if ( isset($id) && ($id != '') ) {
		  
            $sql = new Sql($this->db);
            $operation = $sql->select();
            $operation->from(PREFIX.'lapsic_photo', 's' );//array(', DATE_FORMAT(data_creation, "%d/%m/%Y") AS data_creation', 'CURDATE() AS TODAY', "CONCAT(DAY(CURDATE()),'/',LPAD(MONTH(CURDATE()),2,'0'),'/',YEAR(CURDATE())) AS TODY")); 
            $operation->where(array('id_owner' => $id));
			$operation->where('DATE_FORMAT(data_creation, "%d/%m/%Y") = CONCAT(DAY(CURDATE()),"/",LPAD(MONTH(CURDATE()),2,"0"),"/",YEAR(CURDATE()))');
            
			/* DEBUG */
			$debug_sql = $sql->getSqlStringForSqlObject($operation); 
      		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
			/* ***** */
            
			$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
		
			if ($row = $resData) 
            {
                $ret 		        = $resData->count();				
			}
            else
            {      
    			return false;
            }
		}
		return $ret;
	}
    
    
    /**
	 * Funzione che recupera i dati di un recordo dato un id
	 *
	 * @param int $id Id del record di cui recuperare le informazioni
	 * @return boolean $ret esito del recupero dei dati
	 *
	 */	
	public function ElabHashtag($string) 
    {
        $regex = "/#+([a-zA-Z0-9_]+)/";
        
        preg_match_all($regex, $string,$hashtags,PREG_PATTERN_ORDER);
        //var_dump($hashtags);
        
        foreach($hashtags[0] as $value)
        {
           $string = str_replace($value, '<a class="nounderline fancybox.ajax" style="color:#96cbf3" href="/box-cerca.php?text='.str_replace('#','',$value).'" data-fancybox-type="ajax">'.$value."</a>", $string);
        }
        
        return $string;
    }
}
?>