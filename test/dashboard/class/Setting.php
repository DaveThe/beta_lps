<?php
namespace Dashboard;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
/**
 * La Class Setting contiene le operazioni relative alla configurazione del backoffice.
 * 
 *
 * @version   1.00
 * @since     2014-12-28
 */ 

class Setting extends OriginAbstract
{
	/* VAR Classe */
	
	
	/**
	 * Id della configurazione (interno al sistema)
	 *
	 * @var int
	 */
	public $id 					= NULL;
    
	/**
	 * Titolo progetto
	 *
	 * @var string
	 */
	public $titolo 				= NULL;
    
	/**
	 * Sottotitolo progetto 
	 *
	 * @var string
	 */
	public $sottotitolo			= NULL;
    
	/**
	 * Descrizione progetto 
	 *
	 * @var string
	 */
	public $testo 				= NULL;
    
	/**
	 * Stato Google analytics 
	 *
	 * @var boolean
	 */
	public $stato_GA 			= NULL;	
    
	/**
	 * Favicon sito
	 *
	 * @var string
	 */
	public $favicon				= NULL;
    
	/**
	 * Versione del database primario
	 *
	 * @var string
	 */
	public $db_version			= NULL;
    
	/**
	 * Versione della dashboard base 
	 *
	 * @var string
	 */
	public $dashboard_version	= NULL;
    
	/**
	 * Logo progetto
	 *
	 * @var string
	 */
	public $logo	 			= NULL;
    
	/**
	 * Data creazione del progetto 
	 *
	 * @var datetime
	 */
	public $data_creazione 		= NULL;
    
	/**
	 * Utente che ha creato il progetto 
	 *
	 * @var int
	 */
	public $created_by 			= NULL;
    
	/**
	 * Data della pubblicazione prevista 
	 *
	 * @var datetime
	 */
	public $data_pubblicazione 	= NULL;
    
	/**
	 * Stato della configurazione
	 *
	 * @var string
	 */
	public $status 				= NULL;
	
	/* DATABASE */
	//private $db;
	
	
	/** Costruttore;
	 *  $db : connessione al database aperta esternamente all'istanza della Classe
     */
	public function __construct($db)
	{
		$this->db 				= $db;
	}
	
	public function getElement($id = NULL)
	{
		$ret = false;
        	
        $sql = new Sql($this->db);
        $operation = $sql->select();
        $operation->from(  array('S' => PREFIX.'dashboard_settings'));
        $operation->where(array('status = 1'));
		
		/* DEBUG */
		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
  		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */
		
		$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
		//echo $debug_sql; exit ();
		if ($row = $resData->current()) 
        {
			$this->id                  = $row['id'];
			$this->titolo	 		   = $row['titolo'];
			$this->testo 			   = $row['testo'];
			$this->sottotitolo		   = $row['sottotitolo'];
			$this->stato_GA 		   = $row['stato_GA'];
			$this->favicon	 		   = $row['favicon'];
			$this->db_version 		   = $row['db_version'];
			$this->dashboard_version   = $row['dashboard_version'];
			$this->logo		 		   = $row['logo'];
			$this->data_pubblicazione  = $row['data_pubblicazione'];
			$this->created_by          = $row['created_by'];
			$this->status              = $row['status'];
			
			$ret                      = true;			
		} 
        else 
        {
            return false;
		}
		return $ret;
	}
		
	public function Insert()
	{
		$ret = false;
		$sql = 'INSERT INTO   '.PREFIX.'dashboard_settings  ( 
	 	 	 	 	 	 	 	 	 	 	titolo,
	 	 	 	 	 	 	 	 	 	 	testo, 
											sottotitolo,
											stato_GA,
											favicon,
											db_version,
                                            dashboard_version,
											logo,
											data_pubblicazione,
											created_by,
											status
										) VALUES (';
										
		$sql .= isset($this->titolo) 			? "'" .$this->db->real_escape_string($this->titolo) 	 		. "'," : 'NULL,';
	 	$sql .= isset($this->testo) 			? "'" .$this->db->real_escape_string($this->testo)	 			. "'," : 'NULL,';
	 	$sql .= isset($this->sottotitolo) 		? "'" .$this->db->real_escape_string($this->sottotitolo) 	 	. "'," : 'NULL,';
	 	$sql .= isset($this->stato_GA)			? "'" .$this->db->real_escape_string($this->stato_GA)			. "'," : 'NULL,';
	 	$sql .= isset($this->favicon)			? "'" .$this->db->real_escape_string($this->favicon)			. "'," : 'NULL,';
	 	$sql .= isset($this->db_version)		? "'" .$this->db->real_escape_string($this->db_version)			. "'," : 'NULL,';
	 	$sql .= isset($this->dashboard_version)	? "'" .$this->db->real_escape_string($this->dashboard_version)	. "'," : 'NULL,';
	 	$sql .= isset($this->logo) 				? "'" .$this->db->real_escape_string($this->logo) 				. "'," : "'logo.png',";
	 	$sql .= isset($this->data_pubblicazione)? "'" .$this->db->real_escape_string($this->data_pubblicazione)	. "'," : 'NULL,';
		$sql .= isset($this->created_by) 		? "'" .$this->db->real_escape_string($this->created_by) 			. "'," : 'NULL,';
		$sql .= isset($this->status) 			? "'" .$this->db->real_escape_string($this->status) 				. "')" : '1)';
		
		Debug::ShowDebug(__FUNCTION__, $sql, __Class__);
		
		if($this->db->query($sql)) 
        {		
			$this->id	 = $this->db->insert_id;
			$ret		 = true;								
		} 
        else 
        {			
			$info = debug_backtrace();
			Log::logsError($this->db, 1, "Errore durante in ". __FUNCTION__ ." - mssql_query:".$sql." - mysql_errno: ".$this->db->errno." - mysql_error_description: ".$this->db->error, 2,Log::stackTrace($info));
		}
		
		return $ret;
		
	}
	
	public function Update()
	{
		$ret = false;		
		
        $sql = new Sql($this->db);
		$operation = $sql->update(PREFIX.'dashboard_settings');
		$newData = array(
                            'titolo'=> isset($this->titolo)?$this->titolo:'NULL',
                            'testo'=> isset($this->testo)?$this->testo:'NULL',
                            'sottotitolo'=> isset($this->sottotitolo)?$this->sottotitolo:'NULL',
                            'stato_GA'=> isset($this->stato_GA)?$this->stato_GA:'NULL',
							'favicon'=> isset($this->favicon)?$this->favicon:'NULL',
                            'db_version'=> isset($this->db_version)?$this->db_version:'NULL',
                            'dashboard_version'=> isset($this->dashboard_version)?$this->dashboard_version:'NULL',
							'logo'=> isset($this->logo)?$this->logo:'NULL',
							'data_pubblicazione'=> isset($this->data_pubblicazione)?$this->data_pubblicazione:'NULL',
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
			$ret = true;
		} 
        else
        {
			$info = debug_backtrace();
			Log::logsError($this->db, 1, "Errore durante in ". __FUNCTION__ ." - mssql_query:".$sql." - mysql_errno: ".$this->db->errno." - mysql_error_description: ".$this->db->error, 2,Log::stackTrace($info));
		}
		
		return $ret;
	}
	
}
?>