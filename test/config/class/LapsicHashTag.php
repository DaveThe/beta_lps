<?php 
namespace Lapsic;
/**
 * La class lapsic_user contiene le operazioni relative ai dati di lapsic_user.
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

class LapsicHashTag extends OriginAbstract 
{
	
	/**
	* Parametro che indica l'id univoco del record
	*
	* @var int
	*/
	public $id 		        	= NULL;
	
	
	/**
	* Parametro che indica l'username dell'utente
	*
	* @var string
	*/
    public $id_group 		    = NULL;
	
	
	/**
	* Parametro che indica la password criptata
	*
	* @var string
	*/
    public $tag_name 		    = NULL;
	
	
	/**
	* Parametro che indica il nickname dell'utente
	*
	* @var string
	*/
    public $tag_original	    = NULL;
	
	
	/**
	* Parametro che indica lo stato di attivazione del record
	* 1	(Abilitato)
	* 0	(Disabilitato)
	* @var int
	*/
    public $user 		        = NULL;
	
	
	/**
	* Parametro che indica lo stato di attivazione del record
	* 1	(Abilitato)
	* 0	(Disabilitato)
	* @var int
	*/
    public $description 		        = NULL;
    
	
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
	* Parametro che indica la data di creazione del record
	*
	* @var int
	*/
    public $frequency 		= NULL;
	
	
	/**
	* Parametro che indica lo stato di attivazione del record
	* 1	(Abilitato)
	* 0	(Disabilitato)
	* @var int
	*/
    public $type_record 		        = NULL;
    
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
            $operation->from(  array('H' => PREFIX.'lapsic_hashtag'),
                            array(  
                                    'id',
                                    'id_group',
                                    'tag_name',
                                    'tag_original',
                                    'ip_address',
                                    'created_by',
                                    'DATE_FORMAT(data_creation, "%d/%m/%Y %H:%i:%s") AS data_creation',
                                    'duplicate',
                                    'frequency',
                                    'status'
                                 ) );
        /*
    		$operation->join(array('U' => PREFIX.'lapsic_user'),'U.id = H.created_by',
    										array( 'user' => 'username' ) 
    									);   
          */  /*
    		$operation->join(array('G' => PREFIX.'lapsic_hashtag_group'),'G.id = H.id_group',
    										array( 'value' ) 
    									);*/
                                 
            $operation->where(array('H.id' => $id));
			
			/* DEBUG */
			$debug_sql = $sql->getSqlStringForSqlObject($operation); 
      		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
			/* ***** */
            //echo $debug_sql;
			$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
			
			if ($row = $resData->current()) 
            {
            	$this->id 		        	= $row['id'];
                $this->id_group 		    = $row['id_group'];
                $this->tag_name 		    = $row['tag_name'];
                $this->tag_original		    = $row['tag_original'];
                //$this->user 		        = $row['user'];
                //$this->description 		    = $row['value'];
                $this->ip_address 		    = $row['ip_address'];
                $this->created_by 		    = $row['created_by'];
                $this->data_creation 		= $row['data_creation'];
                $this->duplicate	        = $row['duplicate'];
                $this->frequency	        = $row['frequency'];
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
		$operation = $sql->update(PREFIX.'lapsic_hashtag');
		$newData = array(                            
                            'id_group'      => isset($this->id_group) ? $this->id_group : 'NULL',
                            'tag_name'      => isset($this->tag_name) ? $this->tag_name : 'NULL',
                            'tag_original'  => isset($this->tag_original) ? $this->tag_original : 'NULL',
                            'created_by'    => isset($this->created_by) ? $this->created_by : 'NULL',
                            'duplicate'    => isset($this->duplicate) ? $this->duplicate : 'NULL',
                            'frequency'    => isset($this->frequency) ? $this->frequency : '0',
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
        $duplucate = false;
        
        if(!($tagName = self::GetElementByTag($this->tag_name)))
        {
            $sql = new Sql($this->db);        
            $operation = $sql->insert(PREFIX.'lapsic_hashtag');
            $newData = array(                                                      
                                'id_group'      => isset($this->id_group) ? $this->id_group : '1',
                                'tag_name'      => isset($this->tag_name) ? $this->tag_name : 'NULL',
                                'tag_original'  => isset($this->tag_original) ? $this->tag_original : 'NULL',
                                'ip_address'    => isset($this->ip_address) ? $this->ip_address : 'NULL',
                                'created_by'    => isset($this->created_by) ? $this->created_by : 'NULL',
                                'duplicate'     => isset($this->duplicate) ? $this->duplicate : 'NULL',
                                'frequency'     => isset($this->frequency) ? $this->frequency : '0',
                                'data_creation' => gmdate("Y-m-d H:i:s"),
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
                
                
                $operation_r = $sql->insert(PREFIX.'lapsic_hashtag_relationship');
                $newData_r = array(                                               
                                    'id_record'     => isset($this->id_record) ? $this->id_record : 'NULL',
                                    'type_record'   => isset($this->type_record) ? $this->type_record : 'NULL',
                                    'id_tag'        => isset($this->id) ? $this->id : 'NULL',
                                    'created_by'    => isset($this->created_by) ? $this->created_by : '0',
                                    'data_creation' => gmdate("Y-m-d H:i:s"),
        							'status'        => isset($this->status)?$this->status:'1'
                                );
                                
                $operation_r->values($newData_r);
                    	
    			/* DEBUG */
    			$debug_sql = $sql->getSqlStringForSqlObject($operation); 
          		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
    			/* ***** */
                
        	    if(self::executeQuery($sql,$operation_r,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG))
                {            		
        			//$this->id = self::getLastId($this->db);	
        			$ret = true;			
        		}
                else
                {      
        			return false;
        		}		
                
    		}
            else
            {      
    			return false;
    		}
            
		}
        else
        {
            /**
            *   2 per le foto
            *   1 per gli utenti
            */
            if(isset($this->type_record) && $this->type_record != '')
            {
                $sql = new Sql($this->db);        
                $operation_r = $sql->insert(PREFIX.'lapsic_hashtag_relationship');
                $newData_r = array(                                               
                                    'id_record'     => isset($this->id_record) ? $this->id_record : 'NULL',
                                    'type_record'   => isset($this->type_record) ? $this->type_record : 'NULL',
                                    'id_tag'        => isset($tagName) ? $tagName : 'NULL',
                                    'created_by'    => isset($this->created_by) ? $this->created_by : 'NULL',
                                    'data_creation'    => isset($this->data_creation) ? gmdate("Y-m-d H:i:s") : '',
        							'status'        => isset($this->status)?$this->status:'0'
                                );
                                
                $operation_r->values($newData_r);
            }
            else
            {
                $duplucate = true;
            }            
        }
        //echo $tagName;
        /*
        var_dump($duplucate);
        if(!$duplucate)
        {
            echo 'entrato';
    	
    		echo $debug_sql;
    	    if(self::executeQuery($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG))
            {            		
    			$this->id = self::getLastId($this->db);	
    			$ret = true;
                	
        		echo $debug_sql;
        	    if(self::executeQuery($sql,$operation_r,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG))
                {            		
        			//$this->id = self::getLastId($this->db);	
        			$ret = true;			
        		}
                else
                {      
        			return false;
        		}		
                
    		}
            else
            {      
    			return false;
    		}
		}
        else
        {
            return 'duplicate';
        }*/
		
		return $ret;
	}	
		
	/**
	 * Funzione che recupera i dati di un record dato un tag
	 *
	 * @param int $tag tag del record di cui recuperare le informazioni
	 * @return int $ret Id del record di cui recuperare le informazioni
	 *
	 */
	
	public function GetElementByTag($tag) 
    {
		$ret = false;
        
		if ( isset($tag) && ($tag != '') ) {
		  
            $sql = new Sql($this->db);
            $operation = $sql->select();
            $operation->from(  array('H' => PREFIX.'lapsic_hashtag'),
                            array(  
                                    'id'
                                 ) );
                                 
            $operation->where("tag_name LIKE '%".$tag."%'");
			
			/* DEBUG */
			$debug_sql = $sql->getSqlStringForSqlObject($operation); 
      		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
			/* ***** */
            
			$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
			
			if ($row = $resData->current()) 
            {
            	$ret 		        	= $row['id'];				
			}
            else
            {      
    			return false;
            }
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
        if(self::DeleteMaster($db, 'lapsic_hashtag_relationship', 'id_tag', $id))
        {
            return self::DeleteMaster($db, 'lapsic_hashtag', 'id', $id);
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
        return self::ApproveMaster($db, 'lapsic_hashtag', $id);
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
		return self::DisapproveMaster($db, 'lapsic_hashtag', $id);
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
        $operation->from(array('H' => PREFIX.'lapsic_hashtag'),
                        array(  
                                'id',
                                'id_group',
                                'tag_name',
                                'tag_original',
                                'ip_address',
                                'created_by',
                                'DATE_FORMAT(data_creation, "%d/%m/%Y %H:%i:%s") AS data_creation',
                                'duplicate',
                                'frequency',
                                'status'));        
        
		$operation->join(array('U' => PREFIX.'lapsic_user'),'U.id = H.created_by',
										array( 'user' => 'username' ) 
									);   
        
		$operation->join(array('G' => PREFIX.'lapsic_hashtag_group'),'G.id = H.id_group',
										array( 'value' ) 
									);
        
		if (isset($ParametersList['status'])) 
        {
			switch($ParametersList['status'])
            {
					case 2: $operation->where('status = 0'); break;
					case 1: $operation->where('status = 1'); break;
						
			}
		}
        
		if (isset($ParametersList['duplicate'])) 
        {
			switch($ParametersList['duplicate'])
            {
					case 2: $operation->where('duplicate = 0'); break;
					case 1: $operation->where('duplicate = 1'); break;
						
			}
		}
        
        (isset($ParametersList['own_element']) && ($ParametersList['own_element'] != ''))? $operation->where("created_by = ".$ParametersList['own_element']) : NULL; 
        (isset($ParametersList['text']) && ($ParametersList['text'] != ''))? $operation->where('tag_name LIKE "%'.$ParametersList['text'].'%" OR tag_original LIKE "%'.$ParametersList['text'].'%" OR description LIKE "%'.$ParametersList['text'].'%"') : NULL; 
        (isset($ParametersList['order']) && ($ParametersList['order'] != ''))? $operation->order(array('frequency DESC')) : $operation->order(array('data_creation'));;
        
		
		/* DEBUG */
		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */
        
		$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
        
		if ($resData) 
        {		  
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
	public static function SearchIndex($ParametersList)
    {
	    $statement_lapsic_hashtag = $ParametersList['db_adapter']->query("
                                                        SELECT V.text, V.component, V.component_id,  SUM(MATCH(text) AGAINST('*".$ParametersList['text']."*' IN BOOLEAN MODE)) AS score, idtag
                                                        FROM (SELECT h.tag_original AS text, r.id_record AS component_id, r.type_record AS component, h.id AS idtag FROM lapsic_hashtag h JOIN lapsic_hashtag_relationship r WHERE h.id = r.id_tag) AS `V` 
                                                        WHERE MATCH(text) AGAINST('*".$ParametersList['text']."*' IN BOOLEAN MODE) 
                                                        GROUP BY component, component_id 
                                                        ORDER BY `score` DESC
                                                        LIMIT 0, 10
                                                     ");
                                    
        $results_lapsic_hashtag = $statement_lapsic_hashtag->execute();
        $results_lapsic_hashtag->buffer();
        if(false)
        {
		      echo "
                    SELECT V.text, V.component, V.component_id,  SUM(MATCH(text) AGAINST('*".$ParametersList['text']."*' IN BOOLEAN MODE)) AS score, idtag
                    FROM (SELECT h.tag_original AS text, r.id_record AS component_id, r.type_record AS component, h.id AS idtag FROM lapsic_hashtag h JOIN lapsic_hashtag_relationship r WHERE h.id = r.id_tag) AS `V` 
                    WHERE MATCH(text) AGAINST('*".$ParametersList['text']."*' IN BOOLEAN MODE) 
                    GROUP BY component, component_id 
                    ORDER BY `score` DESC
                    LIMIT 0, 10";
        }
           /*
           echo "
                                                        SELECT V.text, V.component, V.component_id,  SUM(MATCH(text) AGAINST('*".$ParametersList['text']."*' IN BOOLEAN MODE)) AS score, idtag
                                                        FROM (SELECT h.tag_original AS text, r.id_record AS component_id, r.type_record AS component, h.id AS idtag FROM lapsic_hashtag h JOIN lapsic_hashtag_relationship r WHERE h.id = r.id_tag) AS `V` 
                                                        WHERE MATCH(text) AGAINST('*".$ParametersList['text']."*' IN BOOLEAN MODE) 
                                                        GROUP BY component, component_id 
                                                        ORDER BY `score` DESC
                                                        LIMIT 0, 10";*/
        /*$sql = new Sql($ParametersList['db_adapter']);
        $operation = $sql->select();
        $operation->from(array('V' => '(SELECT h.tag_original AS text, r.id_record AS component_id, r.type_record AS component
  FROM lapsic_hashtag h
  JOIN lapsic_hashtag_relationship r
  WHERE h.id = r.id_tag)'),//array('V' => PREFIX.'search_index'),
                        array(  
                                'id',
                                'id_group',
                                'tag_name',
                                'tag_original',
                                'ip_address',
                                'created_by',
                                'DATE_FORMAT(data_creation, "%d/%m/%Y %H:%i:%s") AS data_creation',
                                'duplicate',
                                'status',
                                'SUM(MATCH(text) AGAINST(\''.$ParametersList['text'].'\' IN BOOLEAN MODE)) AS score'));        
                
		if (isset($ParametersList['status'])) 
        {
			switch($ParametersList['status'])
            {
					case 2: $operation->where('status = 0'); break;
					case 1: $operation->where('status = 1'); break;
						
			}
		}
             
        $operation->where("MATCH(text) AGAINST('".$ParametersList['text']."' IN BOOLEAN MODE)");
       
        $operation->order(array('score DESC'));
        $operation->group(array('component, component_id'));
        $operation->limit(10); // always takes an integer/numeric
        //$operation->offset(10); // similarly takes an integer/numeric
		
        
		echo $debug_sql;
		$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
        */
        //var_dump($results_lapsic_hashtag->current());
        //$resData = false;
		if ($results_lapsic_hashtag->count()) {
                        				
            $results_lapsic_hashtag = array_values(iterator_to_array($results_lapsic_hashtag));
			return $results_lapsic_hashtag; 
            //( ($ParametersList['pagination']) ? self::GetPagination($ParametersList['elements_in_page'], $ParametersList['page'], $resData->toArray()) :$resData );
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
    
	/**
	 * Funzione che permette di creare la tabella nel database.
	 *  
	 * @return boolean $ret Esito dell'operazione sui dati
	 */	
	public function CreateTable() 
    {	 
		
		$statement_lapsic_hashtag = $this->db->query("SHOW TABLES LIKE 'lapsic_hashtag'");
                                    
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
                                                                    
                                    CREATE TABLE `lapsic_hashtag` (
                                      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                      `id_group` varchar(255) NOT NULL COMMENT 'id gruppo di riferimento',
                                      `tag_name` varchar(20) NOT NULL COMMENT 'tag trasformato secondo le regole prestabilite',
                                      `tag_original` text NOT NULL COMMENT 'tag originale',
                                      `ip_address` VARCHAR(45) NOT NULL COMMENT 'indirizzo ip di chi ha inserito il tag',
                                      `created_by` int(10) NOT NULL COMMENT 'id di chi ha creato il record',
                                      `data_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'data creazione del record',
                                      `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'attivo = 1, inattivo = 0',
                                      `duplicate` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'duplicato = 1, non duplicato = 0',
                                      `frequency` int(11) NOT NULL DEFAULT '0' COMMENT 'frequenza di richiesta record',
                                      PRIMARY KEY (`id`)
                                    ) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

                                   ");
                                        
            $results_lapsic_hashtag = $statement_lapsic_hashtag->execute();
            $results_lapsic_hashtag->buffer();
        }
        
        
		$statement_lapsic_hashtag_dat = $this->db->query("SHOW TABLES LIKE 'lapsic_hashtag_relationship'");
                                    
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
                                   CREATE TABLE `lapsic_hashtag_relationship` (
                                  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                  `id_record` varchar(255) NOT NULL COMMENT 'id record di riferimento',
                                  `type_record` varchar(255) NOT NULL COMMENT 'identifica il tipo di record',
                                  `id_tag` varchar(255) NOT NULL COMMENT 'id tag di riferimento',
                                  `description` varchar(40) NOT NULL COMMENT 'descrizione della informazione aggiuntiva',
                                  `created_by` int(10) NOT NULL COMMENT 'id di chi ha creato il record',
                                  `data_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'data creazione del record',
                                  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'attivo = 1, inattivo = 0',
                                  PRIMARY KEY (`id`)
                                );");
                                        
            $results_lapsic_hashtag_data = $statement_lapsic_hashtag_dat->execute();
            $results_lapsic_hashtag_data->buffer();
        }
        
        
		$statement_lapsic_group_extra = $this->db->query("SHOW TABLES LIKE 'lapsic_hashtag_group'");
                                    
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
                                  CREATE TABLE `lapsic_hashtag_group` (
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