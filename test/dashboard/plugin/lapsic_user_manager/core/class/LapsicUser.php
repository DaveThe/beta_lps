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
//use \Secret;
class LapsicUser extends OriginAbstract 
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
    public $username 		    = NULL;
	
	
	/**
	* Parametro che indica la password criptata
	*
	* @var string
	*/
    public $password 		    = NULL;
	
	
	/**
	* Parametro che indica il nickname dell'utente
	*
	* @var string
	*/
    public $nickname 		    = NULL;
	
	
	/**
	* Parametro che indica il nome utente
	*
	* @var string
	*/
    public $name 		        = NULL;
	
	
	/**
	* Parametro che indica il cognome del'utente
	*
	* @var string
	*/
    public $surname 		    = NULL;
	
	
	/**
	* Parametro che indica la mail di registrazione
	*
	* @var string
	*/
    public $email 		        = NULL;
	
	
	/**
	* Parametro che indica il sesso dell'utente
	*
	* @var int
	*/
    public $gender 		        = NULL;
	
	
	/**
	* Parametro che indica l'immagine di profilo
	*
	* @var string
	*/
    public $img 		        = NULL;
	
	
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
	* Parametro che indica il ruolo per i permessi
	*
	* @var smallint
	*/
    public $role 		        = NULL;
	
	
	/**
	* Parametro che indica il ruolo personalizzato
	*
	* @var tinyint
	*/
    public $custom_role 		= NULL;
	
	
	/**
	* Parametro che indica il numero di timing aggiornato dell'utente
	*
	* @var int
	*/
    public $timing 		        = NULL;
	
	
	/**
	* Parametro che indica il numero di timers aggiornato dell'utente
	*
	* @var int
	*/
    public $timers 		        = NULL;
	
	
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
            $operation->from(  array('S' => PREFIX.'lapsic_user'),
                            array(  
                                    'id',
                                    'username',
                                    'password',
                                    'nickname',
                                    'name',
                                    'surname',
                                    'email',
                                    'gender',
                                    'img',
                                    'country',
                                    'city',
                                    'role',
                                    'custom_role',
                                    'timing',
                                    'timers',
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
                $this->username 		    = $row['username'];
                $this->password 		    = $row['password'];
                $this->nickname 		    = $row['nickname'];
                $this->name 		        = $row['name'];
                $this->surname 		        = $row['surname'];
                $this->email 		        = $row['email'];
                $this->gender 		        = $row['gender'];
                $this->img 		        	= $row['img'];
                $this->country 		        = $row['country'];
                $this->city 		        = $row['city'];
                $this->role 		        = $row['role'];
                $this->custom_role 		    = $row['custom_role'];
                $this->timing 		        = $row['timing'];
                $this->timers 		        = $row['timers'];
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
		$sec = new \Dashboard\Secret();
		$ret = false;
		
        $sql = new Sql($this->db);
		$operation = $sql->update(PREFIX.'lapsic_user');
		$newData = array(                            
                            'username'      => isset($this->username) ? $this->username : 'NULL',
                            'password'      => isset($this->password) ? base64_encode($sec->encript($this->password)) : 'NULL',
                            'nickname'      => isset($this->nickname) ? $this->nickname : 'NULL',
                            'name'          => isset($this->name) ? $this->name : 'NULL',
                            'surname'       => isset($this->surname) ? $this->surname : 'NULL',
                            'email'         => isset($this->email) ? $this->email : 'NULL',
                            'gender'        => isset($this->gender) ? $this->gender : 'NULL',
                            'img'           => isset($this->img) ? $this->img : 'NULL',
                            'country'       => isset($this->country) ? $this->country : 'NULL',
                            'city'          => isset($this->city) ? $this->city : 'NULL',
                            'role'          => isset($this->role) ? $this->role : 'NULL',
                            'custom_role'   => isset($this->custom_role) ? $this->custom_role : 'NULL',
                            'timing'        => isset($this->timing) ? $this->timing : 'NULL',
                            'timers'        => isset($this->timers) ? $this->timers : 'NULL',
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
		$sec = new \Dashboard\Secret();
		$ret = false;

        $sql = new Sql($this->db);        
        $operation = $sql->insert(PREFIX.'lapsic_user');
        $newData = array(                                                      
                            'username'      => isset($this->username) ? $this->username : 'NULL',
                            'password'      => isset($this->password) ? base64_encode($sec->encript($this->password)) : 'NULL',
                            'nickname'      => isset($this->nickname) ? $this->nickname : 'NULL',
                            'name'          => isset($this->name) ? $this->name : 'NULL',
                            'surname'       => isset($this->surname) ? $this->surname : 'NULL',
                            'email'         => isset($this->email) ? $this->email : 'NULL',
                            'gender'        => isset($this->gender) ? $this->gender : 'NULL',
                            'img'           => isset($this->img) ? $this->img : 'NULL',
                            'country'       => isset($this->country) ? $this->country : 'NULL',
                            'city'          => isset($this->city) ? $this->city : 'NULL',
                            'role'          => isset($this->role) ? $this->role : 'NULL',
                            'custom_role'   => isset($this->custom_role) ? $this->custom_role : 'NULL',
                            'timing'        => isset($this->timing) ? $this->timing : 'NULL',
                            'timers'        => isset($this->timers) ? $this->timers : 'NULL',
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
        if(self::DeleteMaster($db, 'lapsic_user_data', 'id_user', $id))
        {
            return self::DeleteMaster($db, 'lapsic_user', 'id', $id);
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
        return self::ApproveMaster($db, 'lapsic_user', $id);
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
		return self::DisapproveMaster($db, 'lapsic_user', $id);
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
        $operation->from(array('A' => PREFIX.'lapsic_user'),
                        array(  
                                'id',
                                'username',
                                'password',
                                'nickname',
                                'name',
                                'surname',
                                'email',
                                'gender',
                                'img',
                                'country',
                                'city',
                                'role',
                                'custom_role',
                                'timing',
                                'timers',
                                'ip_address',
                                'created_by',
                                'DATE_FORMAT(data_creation, "%d/%m/%Y %H:%i:%s") AS data_creation',
                                'status'));
        
		
		if (isset($ParametersList['gender'])) 
        {
			switch($ParametersList['gender'])
            {
					case 2: $operation->where('status = 0'); break;
					case 1: $operation->where('status = 1'); break;
						
			}
		}
        
		if (isset($ParametersList['status'])) 
        {
			switch($ParametersList['status'])
            {
					case 2: $operation->where('status = 0'); break;
					case 1: $operation->where('status = 1'); break;
						
			}
		}
        
        (isset($ParametersList['own_element']) && ($ParametersList['own_element'] != ''))? $operation->where("created_by = ".$ParametersList['own_element']) : NULL; 
        (isset($ParametersList['text']) && ($ParametersList['text'] != ''))? $operation->where('username LIKE "%'.$ParametersList['text'].'%" OR nickname LIKE "%'.$ParametersList['text'].'%" OR name LIKE "%'.$ParametersList['text'].'%"') : NULL; 
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
	 * Funzione che permette di creare la tabella nel database.
	 *  
	 * @return boolean $ret Esito dell'operazione sui dati
	 */	
	public function CreateTable() 
    {	 
		
		$statement_lapsic_user = $this->db->query("SHOW TABLES LIKE 'lapsic_user'");
                                    
        $results_lapsic_user = $statement_lapsic_user->execute();
        $results_lapsic_user->buffer();
        //var_dump($results_lapsic_user);
		if ($results_lapsic_user->count() > 0) 
        {
            //echo 'esiste lapsic_user';
        }
        else
        {
            //echo 'non esiste lapsic_user';
                                
             $statement_lapsic_user = $this->db->query("                   
                                                                    
                                    CREATE TABLE `lapsic_user` (
                                      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                      `username` varchar(20) NOT NULL COMMENT 'username utente',
                                      `password` varchar(40) NOT NULL COMMENT 'password utente criptata',
                                      `nickname` varchar(45) DEFAULT NULL COMMENT 'nickname',
                                      `name` varchar(45) DEFAULT NULL COMMENT 'Nome reale utente',
                                      `surname` varchar(45) DEFAULT NULL COMMENT 'Cognome reale utente',
                                      `email` varchar(50) DEFAULT NULL COMMENT 'email',
                                      `gender` int(2) NOT NULL COMMENT 'sesso dell''utente',
                                      `img` varchar(50) DEFAULT NULL COMMENT 'avatar utente',
                                      `country` varchar(250) DEFAULT NULL COMMENT 'id nazione di riferimento',
                                      `city` varchar(250) DEFAULT NULL COMMENT 'id città di riferimento',
                                      `role` smallint(6) DEFAULT '4',
                                      `custom_role` tinyint(1) DEFAULT NULL,
                                      `timing` int(10) NOT NULL COMMENT 'Numero totale di timing aggiornato',
                                      `timers` int(10) NOT NULL COMMENT 'Numero di timers aggiornato',
                                      `ip_address` VARCHAR(45) NOT NULL COMMENT 'Numero di timers aggiornato',
                                      `created_by` int(10) NOT NULL COMMENT 'id di chi ha creato il record',
                                      `data_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'data creazione del record',
                                      `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'attivo = 1, inattivo = 0',
                                      PRIMARY KEY (`id`)
                                    ) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

                                   ");
                                        
            $results_lapsic_user = $statement_lapsic_user->execute();
            $results_lapsic_user->buffer();
        }
        
        
		$statement_lapsic_user_dat = $this->db->query("SHOW TABLES LIKE 'lapsic_user_data'");
                                    
        $results_lapsic_user_data = $statement_lapsic_user_dat->execute();
        $results_lapsic_user_data->buffer();
        //var_dump($results_lapsic_user_data);
        
		if ($results_lapsic_user_data->count() > 0) 
        {
            //echo 'esiste lapsic_user_data';
        }
        else
        {
            //echo 'non esistelapsic_user_data';
                     
            $statement_lapsic_user_dat = $this->db->query("
                                   CREATE TABLE `lapsic_user_data` (
                                  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                  `id_user` varchar(255) NOT NULL COMMENT 'id utente di riferimento',
                                  `description` varchar(40) NOT NULL COMMENT 'descrizione della informazione aggiuntiva',
                                  `value` varchar(100) NOT NULL COMMENT 'valore informazione',
                                  `created_by` int(10) NOT NULL COMMENT 'id di chi ha creato il record',
                                  `data_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'data creazione del record',
                                  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'attivo = 1, inattivo = 0',
                                  PRIMARY KEY (`id`)
                                );");
                                        
            $results_lapsic_user_data = $statement_lapsic_user_dat->execute();
            $results_lapsic_user_data->buffer();
        }
        
        
		$statement_lapsic_group_extra = $this->db->query("SHOW TABLES LIKE 'lapsic_group_extra'");
                                    
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
                                  CREATE TABLE `lapsic_group_extra` (
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