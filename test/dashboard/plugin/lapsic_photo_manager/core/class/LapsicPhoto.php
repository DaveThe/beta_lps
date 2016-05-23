<?php 
namespace Dashboard;
/**
 * La class lapsic_photo contiene le operazioni relative ai dati di lapsic_photo.
 * 
 *
 * @version   1.00
 * @since     2015-05-17
 */
 

use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Adapter\Adapter; 
//use \Secret;
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
                                 
            $operation->where(array('id' => $id));
			
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
                            'name'              => isset($this->name) ? $this->name : 'NULL',
                            'description'       => isset($this->description) ? $this->description : 'NULL',
                            'lat'               => isset($this->lat) ? $this->lat : 'NULL',
                            'lng'               => isset($this->lng) ? $this->lng : 'NULL',
                            'width'             => isset($this->width) ? $this->width : 'NULL',
                            'height'            => isset($this->height) ? $this->height : 'NULL',
                            'id_owner'          => isset($this->id_owner) ? $this->id_owner : 'NULL',
                            'time_left'         => isset($this->time_left) ? $this->time_left : 'NULL',
                            'average_colour'    => isset($this->average_colour) ? $this->average_colour : 'NULL',
                            'source_path'       => isset($this->source_path) ? $this->source_path : 'NULL',
                            'source_name'       => isset($this->source_name) ? $this->source_name : 'NULL',
                            'country'           => isset($this->country) ? $this->country : 'NULL',
                            'city'              => isset($this->city) ? $this->city : 'NULL',
                            'created_by'        => isset($this->created_by) ? $this->created_by : 'NULL',
							'status'            => isset($this->status)?$this->status:'0'	
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
        $operation = $sql->insert(PREFIX.'lapsic_photo');
        $newData = array(                                                      
                            'name'              => isset($this->name) ? $this->name : 'NULL',
                            'description'       => isset($this->description) ? $this->description : 'NULL',
                            'lat'               => isset($this->lat) ? $this->lat : 'NULL',
                            'lng'               => isset($this->lng) ? $this->lng : 'NULL',
                            'width'             => isset($this->width) ? $this->width : 'NULL',
                            'height'            => isset($this->height) ? $this->height : 'NULL',
                            'id_owner'          => isset($this->id_owner) ? $this->id_owner : 'NULL',
                            'time_left'         => isset($this->time_left) ? $this->time_left : 'NULL',
                            'average_colour'    => isset($this->average_colour) ? $this->average_colour : 'NULL',
                            'source_path'       => isset($this->source_path) ? $this->source_path : 'NULL',
                            'source_name'       => isset($this->source_name) ? $this->source_name : 'NULL',
                            'country'           => isset($this->country) ? $this->country : 'NULL',
                            'city'              => isset($this->city) ? $this->city : 'NULL',
                            'ip_address'        => isset($this->ip_address) ? $this->ip_address : 'NULL',
                            'created_by'        => isset($this->created_by) ? $this->created_by : 'NULL',
							'status'            => isset($this->status)?$this->status:'0'
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
                                'time_left',
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
										array( 'user' => 'username' ) 
									);   
        
		if (isset($ParametersList['status'])) 
        {
			switch($ParametersList['status'])
            {
					case 2: $operation->where('A.status = 0'); break;
					case 1: $operation->where('A.status = 1'); break;
						
			}
		}
        
        (isset($ParametersList['own_element']) && ($ParametersList['own_element'] != ''))? $operation->where("created_by = ".$ParametersList['own_element']) : NULL; 
        (isset($ParametersList['text']) && ($ParametersList['text'] != ''))? $operation->where('name LIKE "%'.$ParametersList['text'].'%" OR description LIKE "%'.$ParametersList['text'].'%" OR country LIKE "%'.$ParametersList['text'].'%"') : NULL; 
        $operation->order(array('A.data_creation'));
		
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
	 * Funzione che permette di creare la tabella nel database.
	 *  
	 * @return boolean $ret Esito dell'operazione sui dati
	 */	
	public function CreateTable() 
    {	 
		
		$statement_lapsic_photo = $this->db->query("SHOW TABLES LIKE 'lapsic_photo'");
                                    
        $results_lapsic_photo = $statement_lapsic_photo->execute();
        $results_lapsic_photo->buffer();
        //var_dump($results_lapsic_photo);
		if ($results_lapsic_photo->count() > 0) 
        {
            //echo 'esiste lapsic_photo';
        }
        else
        {
            //echo 'non esiste lapsic_photo';
                                
             $statement_lapsic_photo = $this->db->query("                   
                                                                    
                                    CREATE TABLE `lapsic_photo` (
                                      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                      `name` varchar(100) NOT NULL COMMENT 'nome foto dato da utente',
                                      `description` varchar(255) DEFAULT NULL COMMENT 'descrizione estesa foto',
                                      `lat` varchar(45) DEFAULT NULL COMMENT 'latitudine',
                                      `lng` varchar(45) DEFAULT NULL COMMENT 'longitudine',
                                      `width` varchar(45) DEFAULT NULL COMMENT 'larghezza',
                                      `height` varchar(45) DEFAULT NULL COMMENT 'altezza',
                                      `id_owner` varchar(45) NOT NULL COMMENT 'id utente che ha caricato la foto',
                                      `time_left` DATETIME NOT NULL COMMENT 'tempo rimasto alla foto',
                                      `average_colour` VARCHAR(8) NOT NULL COMMENT 'colore primario',
                                      `source_path` varchar(50) DEFAULT NULL COMMENT 'percorso immagine',
                                      `source_name` varchar(50) DEFAULT NULL COMMENT 'nome immagine originale',
                                      `country` varchar(250) DEFAULT NULL COMMENT 'id nazione di riferimento',
                                      `city` varchar(250) DEFAULT NULL COMMENT 'id città di riferimento',
                                      `ip_address` VARCHAR(45) NOT NULL COMMENT 'Numero di timers aggiornato',
                                      `created_by` int(10) NOT NULL COMMENT 'id di chi ha creato il record',
                                      `data_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'data creazione del record',
                                      `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'attivo = 1, inattivo = 0',
                                      PRIMARY KEY (`id`)
                                    ) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

                                   ");
                                        
            $results_lapsic_photo = $statement_lapsic_photo->execute();
            $results_lapsic_photo->buffer();
        }
        
        
		$statement_lapsic_photo_dat = $this->db->query("SHOW TABLES LIKE 'lapsic_photo_data'");
                                    
        $results_lapsic_photo_data = $statement_lapsic_photo_dat->execute();
        $results_lapsic_photo_data->buffer();
        //var_dump($results_lapsic_photo_data);
        
		if ($results_lapsic_photo_data->count() > 0) 
        {
            //echo 'esiste lapsic_photo_data';
        }
        else
        {
            //echo 'non esistelapsic_photo_data';
                     
            $statement_lapsic_photo_dat = $this->db->query("
                                   CREATE TABLE `lapsic_photo_data` (
                                  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                  `id_photo` varchar(255) NOT NULL COMMENT 'id foto di riferimento',
                                  `description` varchar(40) NOT NULL COMMENT 'descrizione della informazione aggiuntiva',
                                  `value` varchar(100) NOT NULL COMMENT 'valore informazione',
                                  `created_by` int(10) NOT NULL COMMENT 'id di chi ha creato il record',
                                  `data_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'data creazione del record',
                                  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'attivo = 1, inattivo = 0',
                                  PRIMARY KEY (`id`)
                                );");
                                        
            $results_lapsic_photo_data = $statement_lapsic_photo_dat->execute();
            $results_lapsic_photo_data->buffer();
        }
        
        
		$statement_lapsic_group_extra = $this->db->query("SHOW TABLES LIKE 'lapsic_photo_group_extra'");
                                    
        $results_lapsic_group_extra = $statement_lapsic_group_extra->execute();
        $results_lapsic_group_extra->buffer();
        //var_dump($results);
        
		if ($results_lapsic_group_extra->count() > 0) 
        {
            //echo 'esiste lapsic_group_extra';
        }
        else
        {
            //echo 'non esiste lapsic_group_extra';
                     
            $statement_lapsic_group_extra = $this->db->query("
                                  CREATE TABLE `lapsic_photo_group_extra` (
                                      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                      `description` varchar(40) NOT NULL COMMENT 'descrizione del gruppo',
                                      `value` varchar(100) NOT NULL COMMENT 'valore informazione',
                                      `created_by` int(10) NOT NULL COMMENT 'id di chi ha creato il record',
                                      `data_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'data creazione del record',
                                      `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'attivo = 1, inattivo = 0',
                                      PRIMARY KEY (`id`)
                                    );");
                                        
            $results_lapsic_group_extra = $statement_lapsic_group_extra->execute();
            $results_lapsic_group_extra->buffer();
        }
	}
	    
}
?>