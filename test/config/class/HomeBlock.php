<?php 
namespace Lapsic;
/**
 * La class HomeBlock contiene le operazioni relative alla home del sito.
 * 
 *
 * @version   1.00
 * @since     2013-09-17
 */
 

use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Adapter\Adapter; 
class HomeBlock extends OriginAbstract 
{
	
	/**
	 * Id dell'utente (interno al sistema)
	 *
	 * @var int
	 */
	 
	public $id 				= NULL;
	
	/**
	 * title dell'utente 
	 *
	 * @var string
	 */
	 
	public $title 				= NULL;
	
	/**
	 * Avatar dell'utente
	 *
	 * @var string
	 */
	 
	public $subtitle 			= NULL;
	
	/**
	 * E-mail dell'utente
	 *
	 * @var string
	 */
	 
	public $abstract 				= NULL;
	
	/**
	 * Sesso dell'utente
	 *
	 * @var int
	 */
	 
	public $text 				= NULL;
	
	/**
	 * abstract dell'utente
	 *
	 * @var string
	 */
	 
	public $date_begin 			= NULL;
	
	/**
	 * img_big che servirà all'utente per accedere al backoffice
	 *
	 * @var string
	 */
	 
	public $date_end 			= NULL;
	
	/**
	 * Password che servirà all'utente per accedere al backoffice
	 *
	 * @var string
	 */
	 
	public $img_small 			= NULL;
	
	/**
	 * Colore della skin del tema scelto dall\'utente
	 *
	 * @var string
	 */
	 
	public $img_big 			= NULL;
	
	/**
	 * Colore della skin del tema scelto dall\'utente
	 *
	 * @var string
	 */
	 
	public $position 			= NULL;
	
	/**
	 * Parametro che indica quale utente ha creato l'accesso
	 *
	 * @var int
	 */
	 
	public $created_by 			= NULL;
	
	/**
	 * Parametro che identifica a livello di sistema la tipologia di utente 
	 * 0	(Admin)
	 * 1	(User)
	 *
	 * @var int
	 */
	 
	public $data_creation 				= NULL;
		
	/**
	 * Parametro che identifica a livello di sistema lo status di utente
	 * 1	(Abilitato)
	 * 0	(Disabilitato)
	 *
	 */
	 
	public $status 				= NULL;
		
	/**
	 * Costruttore della class
	 *
	 * @param mssql $db Risorsa del database da utilizzare
	 *
	 */
	public function __construct($db) {
		$this->db = $db;
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
            $operation->from(  array('S' => PREFIX.'home_block'),
                            array(  'id',                                    
                                    'title',
                                    'subtitle',
                                    'abstract',
                                    'text',
                                    'img_small',
                                    'img_big',
                                    'DATE_FORMAT(date_begin, "%d/%m/%Y %H:%i:%s") AS date_begin',
                                    'DATE_FORMAT(date_end, "%d/%m/%Y %H:%i:%s") AS date_end',
                                    'position',
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
				$this->id 		        = $row['id'];
				$this->title 		    = $row['title'];
				$this->subtitle 		= $row['subtitle'];
				$this->abstract 		= $row['abstract'];
				$this->text 	        = $row['text'];
				$this->img_small 	    = $row['img_small'];
                $this->img_big          = $row['img_big'];
				$this->date_begin 		= $row['date_begin'];
				$this->date_end  		= $row['date_end'];
				$this->position  		= $row['position'];
				$this->created_by 	    = $row['created_by'];
				$this->data_creation 	= $row['data_creation'];
				$this->status    	    = $row['status'];
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
	 * Funzione che recupera la posizione max tra i record
	 *
	 * @param int $id Id del log di cui recuperare le informazioni
	 * @return boolean $ret esito del recupero dei dati
	 *
	 */
	
	public function GetMaxElement() 
    {
		$ret = false;
		  
        $sql = new Sql($this->db);
        $operation = $sql->select();
        $operation->from(  array('S' => PREFIX.'home_block'),
                        array(  'MAX(position) AS mx'
                             ) );
                             			
		/* DEBUG */
		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
  		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */
		
		$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
		
		if ($row = $resData->current()) 
        {
			$ret                        = $row['mx'];				
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
	 public function update()
	 {
		$sec = new Secret();
		$ret = false;
		
        $sql = new Sql($this->db);
		$operation = $sql->update(PREFIX.'news');
		$newData = array(
                            'title'=> isset($this->title)?$this->title:'NULL',
                            'subtitle'=> isset($this->subtitle)?$this->subtitle:'NULL',
                            'abstract'=> isset($this->abstract)?$this->abstract:'NULL',
                            'text'=> isset($this->text)?$this->text:'NULL',
							'img_small'=> isset($this->img_small)?$this->img_small:'NULL',
                            'img_big'=> isset($this->img_big)?$this->img_big:'NULL',
                            'date_begin'=> isset($this->date_begin)?DateFormat::Form2Db($this->date_begin):'NULL',
                            'date_end'=> isset($this->date_end)?DateFormat::Form2Db($this->date_end):'NULL',
                            'position'=> isset($this->position)?$this->position:'NULL',
							'created_by'=> isset($this->created_by)?$this->created_by:'NULL',
							'status'=> isset($this->status)?$this->status:'0'	
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
        $operation = $sql->insert(PREFIX.'home_block');
        $newData = array(
                            'title'         => $this->title,
                            'subtitle'      => $this->subtitle,
                            'abstract'      => $this->abstract,
                            'text'          => $this->text,
                            'img_small'     => $this->img_small,
                            'img_big'       => $this->img_big,
                            'date_begin'    => (isset($this->date_begin))?DateFormat::Form2Db($this->date_begin):'NULL',
                            'date_end'      => (isset($this->date_end)) ? DateFormat::Form2Db($this->date_end):'NULL',
                            'position'      => ($this->GetMaxElement())+1,
                            'created_by'    => $this->created_by,
                            'status'        => 0,
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
	 * Funzione che permette l'eliminazione di un utente dal database.
	 * 
	 * @param mysql $db Risorsa del database da utilizzare
	 * @param int $id Id dell'utente da eliminare
	 * @return boolean $ret Esito dell'eliminazione dei dati
	 */	
	public static function Delete($db, $id) 
    {		
		 return self::DeleteMaster($db, 'home_block', 'id', $id);
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
        return self::ApproveMaster($db, 'home_block', $id);
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
		return self::DisapproveMaster($db, 'home_block', $id);
	}


    
	/**
	 * Funzione che permette di recuperare l'elenco degli utenti che possono accedere al backoffice.
	 * 
	 * @param mysqli $db Risorsa del database da utilizzare
	 * @param int $numxpag Numero di utenti visualizzati in una singola pagina
	 * @param int $pag La pagina visualizzata al momento del richiamo della funzione
	 * @param int $tipo Indica se si vogliono visualizzare gli utenti attivi oppure no
	 * @param string $nickname Stringa di ricerca degli utenti
	 * @param int $idproprio Filtra i risultati rendendo visibili solo quelli creati dall'utente passato come parametro
	 *
	 * @return array $ret Array con i dati ottenuti dalla query su database
	 */	
	public static function GetElementsList($ParametersList) //$db, $numxpag, $pag=1, $tipo = NULL, $nome = NULL, $idproprio = NULL, $gender = NULL) 
    {
	       
        $sql = new Sql($ParametersList['db_adapter']);
        $operation = $sql->select();
        $operation->from(array('A' => PREFIX.'home_block'),
                        array(  'id',
                                'title',
                                'subtitle',
                                'abstract',
                                'text',
                                'img_small',
                                'img_big',
                                'DATE_FORMAT(date_begin, "%d/%m/%Y %H:%i:%s") AS date_begin',
                                'DATE_FORMAT(date_end, "%d/%m/%Y %H:%i:%s") AS date_end',
                                'position',
                                'created_by',
                                'DATE_FORMAT(data_creation, "%d/%m/%Y %H:%i:%s") AS data_creation',
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
        (isset($ParametersList['text']) && ($ParametersList['text'] != ''))? $operation->where('title LIKE "%'.$ParametersList['text'].'%" OR subtitle LIKE "%'.$ParametersList['text'].'%" OR text LIKE "%'.$ParametersList['text'].'%"') : NULL; 
        $operation->order(array('position'));
		
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
	 * @param mssql $db Risorsa del database da utilizzare
	 * @param mssql $id id dell\'utente da disapprovare
	 * 
	 * @return array $ret Array con il risultato della query eseguita su database,
	 * contiene le informazioni sulle aree del backoffice
	 */	
	public function CreateTable() 
    {	 
		
		$statement = $this->db->query("SHOW TABLES LIKE 'home_block'");
                                    
        $results = $statement->execute();
        $results->buffer();
        
		if ($results->count() > 0) 
        {
            //echo 'esiste';
        }
        else
        {
            //echo 'non esiste';
            $statement = $this->db->query("
                                    CREATE TABLE `home_block` (
                                  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                  `title` varchar(255) NOT NULL COMMENT 'titolo della news da visualizzare',
                                  `subtitle` varchar(40) NOT NULL COMMENT 'sotto titolo news',
                                  `abstract` varchar(100) NOT NULL COMMENT 'piccolo spezzone del test',
                                  `text` text NOT NULL COMMENT 'testo intero',
                                  `img_small` varchar(255) NOT NULL COMMENT 'immagine piccola',
                                  `img_big` varchar(255) NOT NULL COMMENT 'immagine grande',
                                  `date_begin` datetime NOT NULL COMMENT 'data inizio visibilità news',
                                  `date_end` datetime NOT NULL COMMENT 'data fine visibilità news',
                                  `position` int(11) NOT NULL COMMENT 'posizione del blocco',
                                  `created_by` int(10) NOT NULL COMMENT 'id di chi ha creato il record',
                                  `data_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'data creazione del record',
                                  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'attivo = 1, inattivo = 0',
                                  PRIMARY KEY (`id`)
                                );");
                                        
            $results = $statement->execute();
            $results->buffer();
        }
	}
	    
}
?>