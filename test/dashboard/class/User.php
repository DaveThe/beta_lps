<?php 
/**
 * La Class BoUser contiene le operazioni relative agli utenti di backoffice.
 * 
 *
 * @version   1.00
 * @since     2013-09-17
 */
namespace Dashboard;

use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;

class User extends OriginAbstract{
	
	/**
	 * Id dell'utente (interno al sistema)
	 *
	 * @var int
	 */
	 
	public $id 				= NULL;
	
	/**
	 * nickname dell'utente 
	 *
	 * @var string
	 */
	 
	public $nickname 				= NULL;
	
	/**
	 * Avatar dell'utente
	 *
	 * @var string
	 */
	 
	public $img 			= NULL;
	
	/**
	 * E-mail dell'utente
	 *
	 * @var string
	 */
	 
	public $email 				= NULL;
	
	/**
	 * Sesso dell'utente
	 *
	 * @var int
	 */
	 
	public $gender 				= NULL;
	
	/**
	 * company dell'utente
	 *
	 * @var string
	 */
	 
	public $company 			= NULL;
	
	/**
	 * Username che servirà all'utente per accedere al backoffice
	 *
	 * @var string
	 */
	 
	public $username 			= NULL;
	
	/**
	 * Password che servirà all'utente per accedere al backoffice
	 *
	 * @var string
	 */
	 
	public $password 			= NULL;
	
	/**
	 * Colore della skin del tema scelto dall\'utente
	 *
	 * @var string
	 */
	 
	public $prj_color 			= NULL;
	
	/**
	 * Parametro che indica il ruolo dell'utente
	 *
	 * @var int
	 */
	 
	public $role 			= NULL;
	
	/**
	 * Parametro che indica se l'utente ha dei permessi custom
	 *
	 * @var boolean
	 */
	 
	public $custom_role 			= NULL;
	
	/**
	 * Parametro che indica quale utente ha creato l'accesso
	 *
	 * @var int
	 */
	 
	public $created_by			= NULL;
	
	/**
	 * Array nel quale verrano salvati tutti i permessi relativi all'utente
	 *
	 * @var array
	 */
	 
	public $permissions			= array();
	
	/**
	 * Parametro che identifica a livello di sistema lo stato di utente
	 * 1	(Abilitato)
	 * 0	(Disabilitato)
	 *
	 */
	 
	public $status 				= NULL;
	
	/**
	 * Risorsa del datbase.
	 * @var mssql
	 */	
	 
	//private $db 				= NULL;
    	
    public $id_user_area	= NULL;
    public $read_p			= NULL;
    public $write_p			= NULL;
    public $delete_p		= NULL;
    public $publish_p		= NULL;
    public $owned_p			= NULL;
    public $id_area			= NULL;
    public $id_sub_area		= NULL;

	/**
	 * Costruttore della Class
	 *
	 * @param mssql $db Risorsa del database da utilizzare
	 *
	 */
	public function __construct($db) {
		$this->db             = $db;
	}
	
        
	
	/**
	 * Funzione che permette di recuperare tutti i dati dell'utente passato come parametro.
	 * 
	 *
	 * @param int $id
	 * @return boolean $ret Esito del recupero dei dati
	 */
	 
	public function getElement($id) 
    {
		$ret = false;
		
		if ( isset($id) && ($id != '') ) 
        {
            
    		$sql = new Sql($this->db);
            $operation = $sql->select();
            $operation->from(  array('U' => PREFIX.'dashboard_users'));
			$operation->columns(
                            array( 'id',
                                   'username',
                                   'password',
                                   'nickname',
                                   'company',
                                   'email',
                                   'gender',
                                   'img',
                                   'prj_color',
								   'role',
								   'custom_role',
                                   'created_by',
                                   'data_creation',
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
					$this->id			    = $row['id'];
					$this->nickname 		= $row['nickname'];
					$this->email 		    = $row['email'];
					$this->company 		    = $row['company'];
					$this->username 	    = $row['username'];
					$this->password 	    = $row['password'];
                    $this->gender           = $row['gender'];
					$this->img  		    = $row['img'];
					$this->prj_color	    = $row['prj_color'];
					$this->role			    = $row['role'];
					$this->custom_role	    = $row['custom_role'];
					$this->created_by	    = $row['created_by'];
					$this->data_creation 	= $row['data_creation'];
					$this->status    	    = $row['status'];
					$ret 				    = true;
					                    
                    /*
						Recuperare permessi
					*/
					
					/*
                    $operation->from(array('U' => PREFIX.'dashboard_users'));
					$operation->columns(
									array( 'id',
										   'username',
										   'password',
										   'nickname',
										   'company',
										   'email',
										   'gender',
										   'img',
										   'prj_color',
										   'role',
										   'custom_role',
										   'created_by',
										   'data_creation',
										   'status'
										 ) ); */
                                         
                    /*
					$operation->join(array('ASUB' => PREFIX.'dashboard_area_sub'),'UA.id_sub_area = ASUB.id',
										array( 'name',
											   'page',
											   'img',
                                               'sub_area_name'
											 ) 
									);*/
                    
                    /*
                                            
                        SELECT A.area_name, ASUB.name, `P`.`read_p` AS `read_area`, `P`.`write_p` AS `write_area`, `P`.`delete_p` AS `delete_area`, `P`.`publish_p` AS `publish_area`, `P`.`owned_p` AS `owned_area`,
                        `PS`.`read_p` AS `read_area_sub`, `PS`.`write_p` AS `write_area_sub`, `PS`.`delete_p` AS `delete_area_sub`, `PS`.`publish_p` AS `publish_area_sub`, `PS`.`owned_p` AS `owned_area_sub`
                        FROM dashboard_users AS U
                        RIGHT JOIN dashboard_user_area AS UA ON UA.id_user = U.id
                        JOIN dashboard_area AS A ON A.id = UA.id_area
                        JOIN dashboard_area_sub AS ASUB ON ASUB.id = UA.id_sub_area
                        LEFT JOIN dashboard_permission AS P ON P.id_user_area = UA.id_area
                        LEFT JOIN dashboard_permission AS PS ON PS.id_user_area = UA.id_sub_area
                        WHERE U.id = '1'
                    */
                    
			}
            else
            {   
    			return false;
            }
		}
        
        return $ret;
        
	}

	 /**
	 * Funzione che permette l'inserimento dei dati anagrafici dell'utente nel database.
	 * 
	 *
	 * @return boolean $ret Esito dell'inserimento dei dati
	 */	
	 public function insert()
	 {
		$sec = new Secret();
		$ret = false;
	
        $sql = new Sql($this->db);
        $operation = $sql->insert(PREFIX.'dashboard_users');
        $newData = array(
                            'username'=> isset($this->username)?$this->username:'NULL',
                            'password'=> isset($this->password)?base64_encode($sec->encript($this->password)):'NULL',
                            'nickname'=> isset($this->nickname)?$this->nickname:'NULL',
                            'company'=> isset($this->company)?$this->company:'NULL',
							'email'=> isset($this->email)?$this->email:'NULL',
                            'gender'=> isset($this->gender)?$this->gender:'NULL',
                            'img'=> isset($this->img)?$this->img:'NULL',
							'prj_color'=> isset($this->prj_color)?$this->prj_color:'NULL',
							'role'=> isset($this->role)?$this->role:'NULL',
							'custom_role'=> isset($this->custom_role)?$this->custom_role:'NULL',
							'created_by'=> isset($this->created_by)?$this->created_by:'NULL',
							'status'=> isset($this->status)?$this->status:'0'	
                        );
                        
        $operation->values($newData);
		
		/* DEBUG */
		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */
		
	    if(self::executeQuery($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG))
        {
			$this->id = self::getLastId($this->db);
           	$ret= true; 
        }
        else
        {                
			return false;
        }		
		
		return $ret;
	 }
    
	 /**
	 * Funzione che permette l'inserimento dei dati anagrafici dell'utente nel database.
	 * 
	 *
	 * @return boolean $ret Esito dell'inserimento dei dati
	 */	
	 public function insertUserArea()
	 {
		$ret = false;

        $sql = new Sql($this->db);
        $operation = $sql->insert(PREFIX.'dashboard_user_area');
        $newData = array(
                            'id_user'=> isset($this->id)?$this->id:'NULL',
                            'id_area'=> isset($this->id_area)?$this->id_area:'NULL',
                            'id_sub_area'=> isset($this->id_sub_area)?$this->id_sub_area:'NULL'
                        );
                        
        $operation->values($newData);
		
		/* DEBUG */
		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */
	    if(self::executeQuery($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG))
        {
			$this->id_user_area = self::getLastId($this->db);
           	$ret= true; 
            //echo '<br>'.$debug_sql.' -- inserito id user area = ('.$this->id_user_area.')<br>';
        }
        else
        {                
			return false;
        }		
		
		return $ret;
	 }
     
     
	 /**
	 * Funzione che permette l'inserimento dei dati anagrafici dell'utente nel database.
	 * 
	 *
	 * @return boolean $ret Esito dell'inserimento dei dati
	 */	
	 public function insertPerm()
	 {
		$ret = false;

        $sql = new Sql($this->db);
        $operation = $sql->insert(PREFIX.'dashboard_permission');
        $newData = array(
                            'id_user_area'=> isset($this->id_user_area)?$this->id_user_area:'NULL',
                            'read_p'=> isset($this->read_p)?$this->read_p:'NULL',
                            'write_p'=> isset($this->write_p)?$this->write_p:'NULL',
							'delete_p'=> isset($this->delete_p)?$this->delete_p:'NULL',
                            'publish_p'=> isset($this->publish_p)?$this->publish_p:'NULL',
                            'owned_p'=> isset($this->owned_p)?$this->owned_p:'NULL',
							'created_by'=> isset($this->created_by)?$this->created_by:'NULL',
							'status'=> '1'	
                        );
                        
        $operation->values($newData);
		
		/* DEBUG */
		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */
		//echo '<br>'.$debug_sql.'<br>';
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
		$operation = $sql->update(PREFIX.'dashboard_users');
		$newData = array(
                            'username'=> isset($this->username)?$this->username:'NULL',
                            'password'=> isset($this->password)?base64_encode($sec->encript($this->password)):'NULL',
                            'nickname'=> isset($this->nickname)?$this->nickname:'NULL',
                            'company'=> isset($this->company)?$this->company:'NULL',
							'email'=> isset($this->email)?$this->email:'NULL',
                            'gender'=> isset($this->gender)?$this->gender:'NULL',
                            'img'=> isset($this->img)?$this->img:'NULL',
							'prj_color'=> isset($this->prj_color)?$this->prj_color:'NULL',
							'role'=> isset($this->role)?$this->role:'NULL',
							'custom_role'=> isset($this->custom_role)?$this->custom_role:'NULL',
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
	 * Funzione che recupera i ruoli possibili.
	 * 
	 *
	 * @return array $ret Esito del recupero dei dati
	 */	
	 public function getRoles()
	 {
		$ret = false; 
		$sql = new Sql($this->db);
		$operation = $sql->select();
		$operation->from(  array('U' => PREFIX.'dashboard_users_roles'));
		$operation->columns(
						array( 'id',
							   'role'
							 ) );
		/* DEBUG */
		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */
		
		$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
			
		if($resData) 
		{
				$ret = $resData;
		}
        else
        {                
			$info = debug_backtrace();
            $log  = new Log($this->db, ERROR, __FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, $info, $this->db->errno, $this->db->error, $this->created_by);                            
            $log->Insert();
			return false;
        }	
		
		return $ret;
	 }	
	 
	public function getAllPermissions($id)
	{
		/*RECUPERIAMO LE AREE*/
		$sql = new Sql($this->db);
		
        $operation = $sql->select();
        
		$operation->from(  array('UA' => PREFIX.'dashboard_user_area') );
        $operation->columns(
						      array( 'user_area' => 'id' )
                            );
        $operation->join(array('P' => PREFIX.'dashboard_permission'),'P.id_user_area = UA.id', array(  'read_p_area'     => 'read_p',
                                                                                                            'write_p_area'    => 'write_p',
                                                                                                            'delete_p_area'   => 'delete_p', 
                                                                                                            'publish_p_area'  => 'publish_p', 
                                                                                                            'owned_p_area'    => 'owned_p'));
                                                                                                            
		$operation->join(array('U' => PREFIX.'dashboard_users'),'U.id = UA.id_user',NULL);
		$operation->join(array('A' => PREFIX.'dashboard_area'),'A.id = UA.id_area', array('area_name', 'id_area' => 'id'));
		$operation->join(array('ASUB' => PREFIX.'dashboard_area_sub'),'ASUB.id = UA.id_sub_area', array('sub_area_name' => 'name', 'id_sub' => 'id'), "left");
				
        
		$operation->where(array('U.id' => $id));
        
       	/*
        SELECT `UA`.`id` AS `user_area`, NULL AS ``, `A`.`area_name` AS `area_name`, `A`.`id` AS `id_area`, `ASUB`.`name` AS `sub_area_name`, `ASUB`.`id` AS `id_sub`, `P`.`read_p` AS `read_p_area`, `P`.`write_p` AS `write_p_area`, `P`.`delete_p` AS `delete_p_area`, `P`.`publish_p` AS `publish_p_area`, `P`.`owned_p` AS `owned_p_area`
        FROM `dashboard_user_area` AS `UA`
        JOIN dashboard_permission AS P ON P.id_user_area = UA.id
        JOIN `dashboard_users` AS `U` ON U.id = UA.id_user
        JOIN `dashboard_area` AS `A` ON `A`.`id` = `UA`.`id_area` 
        LEFT JOIN `dashboard_area_sub` AS `ASUB` ON `ASUB`.`id` = `UA`.`id_sub_area` 
        WHERE U.id = 1; 
         */	
		/* DEBUG */
		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */
		$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
		
		/*ARRAY PERMESSI*/
		$perms = array();
        
        /*
        
                                        'read_p_area_sub'       => $row->read_p_area_sub, 
                                        'write_p_area_sub'      => $row->write_p_area_sub, 
                                        'delete_p_area_sub'     => $row->delete_p_area_sub, 
                                        'publish_p_area_sub'    => $row->publish_p_area_sub, 
                                        'owned_p_area_sub'      => $row->owned_p_area_sub,
        */
        
		if($resData) 
		{
				/*RECUPERO LE SOTTOAREE*/
				foreach($resData as $row)
				{
				    
					$perms[] = array(   
                                        'id_area'               => $row->id_area,
                                        'id_sub'                => $row->id_sub,
                                        'display_name'          => $row->area_name, 
                                        'sub_area'              => $row->sub_area_name, 
                                        'read_p_area'           => $row->read_p_area, 
                                        'write_p_area'          => $row->write_p_area, 
                                        'delete_p_area'         => $row->delete_p_area, 
                                        'publish_p_area'        => $row->publish_p_area, 
                                        'owned_p_area'          => $row->owned_p_area, 
                                    );
                }
				
				return $perms;
		}
        else
        {   
			return false;
        }	
	}
	 
	public function getUserArea()
	{
		/*RECUPERIAMO LE AREE*/
		$sql = new Sql($this->db);
		$operation = $sql->select();
		$operation->from(  array('UA' => PREFIX.'dashboard_user_area'));
		$operation->columns(
						array( 'id_area'
							 ) );
		$operation->join(array('A' => PREFIX.'dashboard_area'),'UA.id_area = A.id',
										array( 'id',
											   'display_name',
											   'area_name',
											   'img',
											   'page',
											   'title'
											 ) 
									);
		$operation->where('UA.id_user = '.$this->id)
		->where('A.status = 1')
        ->group('id_area');
		
		/* DEBUG */
		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */
		$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
		
		/*ARRAY SEZIONI*/
		
		unset($operation);

		if($resData) 
		{
		      $master = array();
				/*RECUPERO LE SOTTOAREE*/
				foreach($resData as $row)
				{
					
				    //$sqlS = new Sql($this->db);
					$operation = $sql->select();
					$operation->from(  array('UA' => PREFIX.'dashboard_user_area'));
					$operation->join(array('A' => PREFIX.'dashboard_area'),'UA.id_area = A.id');
					$operation->join(array('ASUB' => PREFIX.'dashboard_area_sub'),'UA.id_sub_area = ASUB.id',
										array( 
                                               'id',
                                               'name',
											   'page',
											   'img',
                                               'sub_area_name'
											 ) 
									);
					$operation->where('UA.id_user = '.$this->id)
					->where('A.status = 1')
					->where('ASUB.status = 1')
                    ->where('UA.id_area = '.$row->id_area)
                    ->order('ASUB.name');
					
					/* DEBUG */
					$debug_sql = $sql->getSqlStringForSqlObject($operation); 
					Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
					/* ***** */
                    
					$resDataSub = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
					$section = array();
					foreach($resDataSub as $rowSub)
					{
						$section[$rowSub->sub_area_name]=array('id'=>$rowSub->id,'name'=>$rowSub->name,'page'=>$rowSub->page,'img'=>$rowSub->img, 'sub_area_name'=>$rowSub->sub_area_name);
					}
					$master[$row->area_name] = array('id'=>$row->id,'title'=>$row->title,'display_name'=>$row->display_name,'page'=>$row->page,'img'=>$row->img,'area_name'=>$row->area_name,'sub_area'=>$section);
				}
				//var_dump($section);
				return $master;
		}
        else
        {   
			return false;
        }	
	}
	 
	/**
	 * Funzione che permette il login dell'utente sulla piattaforma di backoffice
	 *
	 * @param string $user Username dell'utente passato dal form di login
	 * @param string $user Password dell'utente passato dal form di login
	 *
	 * @return array $ret Array con le informazioni dell'utente loggato.
	 */
	public function Login($user, $pass) 
	{
		$sec = new Secret();
		$ret = false; 
		$sql = new Sql($this->db);
		$operation = $sql->select();
		$operation->from(  array('U' => PREFIX.'dashboard_users'));
		$operation->columns(
						array( 'id',
							   'username',
							   'password',
							   'nickname',
							   'company',
							   'email',
							   'gender',
							   'img',
							   'prj_color',
							   'role',
							   'custom_role',
							   'created_by',
							   'data_creation',
							   'status'
							 ) );
		$operation->where("username = '".$user."' AND password = '".base64_encode($sec->encript($pass))."' AND status = 1");
		/* DEBUG */
		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */
		//echo $debug_sql;
		$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG)->current();
		if($resData) 
		{
				$ret = $resData['id'];
		}
        else
        {  
			return false;
        }	
		
		return $ret;
	}
	 
	/**
	 * Funzione che controlla se l'utente è loggato correttamente,
	 * in caso negativo esegue un redirect alla pagina di login.
	 * 
	 */
	public static function CheckLogin() 
    {
		if( !isset($_SESSION['dashboard_login']) || $_SESSION['dashboard_login'] != true){
			header('Location: login.php');
			exit ();
		}
	}
	 
	/**
	 * Funzione che controlla i permessi dell'utente
	 *
	 * @param int $iduser Id dell'utente 
	 * @param string $area Nome dell'area di backoffice per cui controllo i permessi
	 * @param int $visualizza Indica se l'utente può visualizzare i contenuti
	 * @param int $crea Indica se l'utente può creare dei contenuti
	 * @param int $cancella Indica se l'utente può cancellare dei contenuti
	 * @param int $pubblica Indica se l'utente può pubblicare dei contenuti
	 * 
	 * @return boolean $ret Esito del controllo dei permessi
	 *
	 */
	public function checkPermission($iduser, $area, $sub_area = NULL) 
	{
		/*********** VAR PERMESSI **************
		READ		1
		WRITE 		2
		DELETE 		3
		PUBLISH 	4
		OWN_ONLY 	5
    	*********** END VAR PERMESSI **************/
		
		$permission = array('READ' => false,
							'WRITE' => false,
							'DELETE' => false,
							'PUBLISH' => false,
							'OWN_ONLY' => false);
		
		$ret = false; 
		
		if($this->custom_role == 0)
		{
			switch($this->role)
			{
				case 1:
				
				$permission = array('READ' => true,
									'WRITE' => true,
									'DELETE' => true,
									'PUBLISH' => true,
									'OWN_ONLY' => false); 
				
				break; //Admin
				
				case 2:
				$permission = array('READ' => true,
									'WRITE' => false,
									'DELETE' => false,
									'PUBLISH' => true,
									'OWN_ONLY' => false); 
				
				break; //Mod
				
				case 3: 
				$permission = array('READ' => true,
									'WRITE' => true,
									'DELETE' => false,
									'PUBLISH' => false,
									'OWN_ONLY' => true);
				break; //Editor
				
				case 4:  
				$permission = array('READ' => true,
									'WRITE' => false,
									'DELETE' => false,
									'PUBLISH' => false,
									'OWN_ONLY' => true);
				default: break; //User
			}
		}
		else
		{
			if(isset($area) && trim($area)!='')
			{
				$sql = new Sql($this->db);
				$operation = $sql->select();
				$operation->from(  array('P' => PREFIX.'dashboard_permission'));
				$operation->columns(
								array( 'id',
									   'read_p',
									   'write_p',
									   'delete_p',
									   'publish_p',
									   'owned_p'
									 ) );
				$operation->join(array('UA' => PREFIX.'dashboard_user_area'),'UA.id = P.id_user_area');
				$operation->join(array('A' => PREFIX.'dashboard_area'),'A.id = UA.id_area',array('area_name'));
				if(isset($sub_area) && trim($sub_area)!='')  $operation->join(array('ASUB' => PREFIX.'dashboard_area_sub'),'ASUB.id = UA.id_sub_area',array('sub_area_name'));
				$operation->where(array('UA.id_user = \''.$iduser.'\''));
				if(!isset($sub_area) || !trim($sub_area)!='')$operation->where(array('A.area_name = \''.$area.'\''));
				
				if(isset($sub_area) && trim($sub_area)!='')
				{
					$operation->where(array('ASUB.sub_area_name = \''.trim($sub_area).'\''));
				}

				$operation->group('UA.id_user');
				/* DEBUG */
				$debug_sql = $sql->getSqlStringForSqlObject($operation); 
				Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
				/* ***** */     
                //echo $debug_sql;
				$resData = self::getRecord($sql, $operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), $this->created_by)->current();
			     
                
				if($resData) 
				{
					$permission = array('READ' => $resData->read_p,
										'WRITE' => $resData->write_p,
										'DELETE' => $resData->delete_p,
										'PUBLISH' => $resData->publish_p,
										'OWN_ONLY' => $resData->owned_p);	
				}
                	
			}
		}
		
		return $permission;
	}
	
	
	/**
	 * Funzione che permette l'inserimento/aggiornamento dei permessi dell'utente nel database.
	 * 
	 *
	 * @return boolean $ret Esito dell'inserimento dei permessi
	 */	
	public function InsertPermissions() 
    {
        //echo 'entro nella funzione Insertpermissions';
		$ret = false;
        //echo 'user'. $this->id;
        //var_dump (self::DeletePermission($this->db, $this->id));
        if(self::DeletePermission($this->db, $this->id))
        {
            //echo 'eliminato tutto ok';
            foreach($this->permissions as $key=>$value){
                //echo ' -- id_area '.$key.' => ';
                    $this->id_area       = $key;
                foreach($this->permissions[$key] as $key2=>$value2){
                    //echo ' -- id_sub '.$key2.' => ';
                    $this->id_sub_area   = $key2;
                    if($this->insertUserArea())
                    {   //echo 'user area ok';
                        $this->read_p       = $value2['read'];
                        $this->write_p      = $value2['write'];
                        $this->delete_p     = $value2['delete'];
                        $this->publish_p    = $value2['publish'];
                        $this->owned_p      = $value2['owned'];
                        
                        if($this->insertPerm())
                        {
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
                        //echo 'user area ko';
                    }
                }
            }    
        }
        else
        {
            return false;
            //echo 'elimina ko';
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
	public static function DeletePermission($db, $id) 
    {	        
        $ret = false;
        $statement = $db->query(" DELETE UA, P
                                        FROM ".PREFIX."dashboard_user_area AS UA
                                        JOIN ".PREFIX."dashboard_permission AS P ON P.id_user_area = UA.id
                                        WHERE UA.id_user = ".$id);
                                    
        $results = $statement->execute();
        $results->buffer();
        
		if ($results)// instanceof ResultInterface && $results->isQueryResult())
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
	 * Funzione che permette l'eliminazione di un utente dal database.
	 * 
	 * @param mysql $db Risorsa del database da utilizzare
	 * @param int $id Id dell'utente da eliminare
	 * @return boolean $ret Esito dell'eliminazione dei dati
	 */	
	public static function Delete($db, $id) 
    {		
		 if( self::DeleteMaster($db, 'dashboard_users', 'id', $id) )
        {
			 if( self::DeleteMaster($db, 'dashboard_permission', 'id_user', $id))
			{
				return self::DeleteMaster($db, 'dashboard_user_area', 'id_user', $id);
			}
        }
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
        $operation->from(array('A' => PREFIX.'dashboard_users'),
                        array(   'id',
                                 'username',
                                 'password',
                                 'nickname',
                                 'company',
                                 'email',
                                 'gender',
                                 'type_user',
                                 'img',
                                 'prj_color',
                                 'created_by',
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
        (isset($ParametersList['gender']))? $operation->where("gender = ".$ParametersList['gender']) : NULL;
        (isset($ParametersList['text']) && ($ParametersList['text'] != ''))? $operation->where('username LIKE "%'.$ParametersList['text'].'%" OR nickname LIKE "%'.$ParametersList['text'].'%" OR email LIKE "%'.$ParametersList['text'].'%" OR company LIKE "%'.$ParametersList['text'].'%"') : NULL; 
        $operation->order(array('username'));
		
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
        return self::ApproveMaster($db, 'dashboard_users', $id);
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
		return self::DisapproveMaster($db, 'dashboard_users', $id);
	}
	
    
	/**
	 * Funzione che ritorna il nickname o lo username dell\'utente.
	 * 
	 *
	 * @return string nome utente
	 */	
	public function GetUsername() 
    {
        return ( ( isset($this->nickname) && $this->nickname != '') ? $this->nickname : $this->username );
    }
	
    
	/**
	 * Funzione che ritorna il colore del tema.
	 * 
	 *
	 * @return string nome utente
	 */	
	public function GetSkin() 
    {
        return ( (isset($this->prj_color) && $this->prj_color != "") ? $this->prj_color : "blue" );
    }
}
?>