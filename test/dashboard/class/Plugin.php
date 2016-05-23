<?php
 /**
 * La Class Debug contiene i metodi per crittografare e decirare le chiavi di debug, visualizzare la finestra di Debug.
 * 
 *
 * @version   1.00
 * @since     2014-12-29
 */
namespace Dashboard;

use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Adapter\Adapter;

class Plugin extends OriginAbstract
{
	
	/**
	 * Id dell'utente (interno al sistema)
	 *
	 * @var int
	 */
	 
	public $id  				= NULL;
	
	/**
	 * nickname dell'utente 
	 *
	 * @var string
	 */
	 
	public $token 				= NULL;
	
	/**
	 * Avatar dell'utente
	 *
	 * @var string
	 */
	 
	public $img     			= NULL;
	
	/**
	 * E-mail dell'utente
	 *
	 * @var string
	 */
	 
	public $name 				= NULL;
	
	/**
	 * Sesso dell'utente
	 *
	 * @var int
	 */
	 
	public $author 				= NULL;
	
	/**
	 * company dell'utente
	 *
	 * @var string
	 */
	 
	public $version 			= NULL;
	
	/**
	 * Username che servirà all'utente per accedere al backoffice
	 *
	 * @var string
	 */
	 
	public $description			= NULL;
	
	/**
	 * Password che servirà all'utente per accedere al backoffice
	 *
	 * @var string
	 */
	 
	public $site    			= NULL;
	
	/**
	 * Colore della skin del tema scelto dall\'utente
	 *
	 * @var string
	 */
	 
	public $type_plugin			= NULL;
	
	/**
	 * Colore della skin del tema scelto dall\'utente
	 *
	 * @var string
	 */
	 
	public $display_name		= NULL;
	
	/**
	 * Parametro che indica quale utente ha creato l'accesso
	 *
	 * @var int
	 */
	 
	public $created_by 			= NULL;
	
	/**
	 * Parametro che identifica a livello di sistema lo stato di utente
	 * 1	(Abilitato)
	 * 0	(Disabilitato)
	 *
	 */
	 
	public $status				= NULL;
	
	/**
	 * Parametro che identifica a livello di sistema lo stato di utente
	 * 1	(Abilitato)
	 * 0	(Disabilitato)
	 *
	 */
	 
	public $plugin_status				= TRUE;
	
	/**
	 * Parametro che identifica in quali aree è attivo il plugin
	 *
	 */
	 
	public $plugin_area				= array();
	
	/**
	 * Parametro che identifica in quali aree è attivo il plugin
	 *
	 */
	 
	public $id_area_sub				= NULL;
	
	/**
	 * Parametro che identifica in quali aree è attivo il plugin
	 *
	 */
	 
	public $id_area    				= NULL;
	
	/**
	 * Risorsa del datbase.
	 * @var mssql
	 */	
	 
	//private $db 				= NULL;
	
    
	/**
	 *
	 *	Variabili che vengono usate per la creazione della chiave
	 *
	**/
	
	private 		$encryption_key 	= 	NULL;
	private 		$string_key			= 	" - Shufflesoft plugin - ";
	public 			$private_key		= 	NULL;
	public static	$debug_state		=	false;
	
    
	/**
	 * Costruttore della Class
	 *
	 * @param mssql $db Risorsa del database da utilizzare
	 *
	 */
	public function __construct($username, $mail, $db) 
	{		
		$this->db = $db;
		$this->encryption_key = date('d/m/y').$username.'/'.$mail.'/'.date('h:m:s');
		$this->private_key = self::encrypt($this->string_key.date('d/m/y h:m:s'), $this->encryption_key);
        $dir_plugin = $this->GetAllPlugin();                
        
        $this->plugin_status = $this->CheckPlugin($dir_plugin);		
	}
	
	public function getKey()
	{
		return $this->private_key;
	}
	
	public static function encrypt($pure_string, $encryption_key) 
	{
    	$encrypted_string= hash_hmac('md5',$pure_string, $encryption_key); //echo $pure_string .' - '.$encryption_key;
    	return $encrypted_string;
	}

	public function check_Key($key)
	{
		$ret=false;
		if(strcmp($key,$this->private_key)==0)
		{

			$ret=true;
			self::$debug_state	=	true;
		}
		return $ret;
	}
    
    
	/**
	 * Funzione che permette di recuperare i temi a disposizione'.
	 * 
	 * @return array $ret Array con i dati ottenuti
	 */	
	public function GetAllPlugin() {
	
        $root = scandir(PLUGIN_PATH, 1);       
        $data = array();
        
        for($i = 0; $i < count($root); $i++)
        {
            if($root[$i] != "." && $root[$i] != "..")
            {
                if(file_exists(PLUGIN_PATH.$root[$i]."/info/readme.txt"))
                {
                    $data[]              = $this->ParseReadMe(PLUGIN_PATH.$root[$i]."/info/", $root[$i]);
                }
            }
        }
        
        return $data;
	}
    
    public function ParseReadMe($path, $tema)
    {
        $file = file_get_contents($path.'readme.txt');
        $data = explode("\n", $file);
        
        $data_return = array();
        foreach($data as $a)
        {
            $data_return['name']        = $tema;
            $data_return['img']         = 'icon.png';
            
            if(strpos($a, "Name:") !== false)
            {
                $data_return['display_name']    = trim(str_replace('Name:','', $a));
            }
            elseif(strpos($a, "Author:") !== false)
            {
                $data_return['author']          = trim(str_replace('Author:','', $a));
            }
            elseif(strpos($a, "Version:") !== false)
            {
                $data_return['version']         = trim(str_replace('Version:','', $a));    
            }
            elseif(strpos($a, "Description:") !== false)
            {
                $data_return['description']     = trim(str_replace('Description:','', $a));    
            }
            elseif(strpos($a, "Site:") !== false)
            {
                $data_return['site']          = trim(str_replace('Site:','', $a));
            }
            elseif(strpos($a, "Type:") !== false)
            {
                $data_return['type_plugin']   = trim(str_replace('Type:','', $a));
            }
            elseif(strpos($a, "Token:") !== false)
            {
                $data_return['token']         = trim(str_replace('Token:','', $a));
            }
            
                //$data_return['carousel']       = self::GetCarousel($path, $data_return['name']);
        }
        if($data_return['token'] != '')
        {    
            $this->checkInsert($data_return);
            /*
            set_include_path(
        		str_replace("/info/", "",$path) . PATH_SEPARATOR .
        		get_include_path()
        	);*/
        }
        
        return $data_return;
    }
    
    public static function GetCarousel($path, $tema)
    {
        $root = scandir($path, 1);
        $data = array();
        for($i = 0; $i < count($root); $i++)
        {
            if(($root[$i] != "." && $root[$i] != "..") && getimagesize($path.$root[$i]))
            {
                $data[] = PLUGIN_MEDIA_PATH.$tema.'/info/'.$root[$i];
            }
        }
        
        return $data;
    }
    
    public function checkInsert($data)
    {   //var_dump($data);
        if( $this->CheckElement( $data['token'] ) )
        {   
            $this->token                = $data['token'];
            $this->author               = $data['author'];
            $this->name                 = $data['name'];
            $this->version              = $data['version'];
            $this->description          = $data['description'];
            $this->site                 = $data['site'];
            $this->type_plugin          = $data['type_plugin'];
            $this->display_name         = $data['display_name'];
            $this->img                  = $data['img'];
            
            $this->Insert();
        }
        else
        {
            if( $this->CheckElement( $data['token'], $data['version'] ) )
            {
                $this->token                = $data['token'];
                $this->author               = $data['author'];
                $this->name                 = $data['name'];
                $this->version              = $data['version'];
                $this->description          = $data['description'];
                $this->site                 = $data['site'];
                $this->type_plugin          = $data['type_plugin'];
                $this->display_name         = $data['display_name'];
                $this->img                  = $data['img'];
                
                $this->Update();
            }
        }
    }
    
    
    public function CheckElement($token, $version = NULL) 
    {
		$ret = false;
                
		$sql = new Sql($this->db);
        $operation = $sql->select();
        $operation->from(  array('P' => PREFIX.'dashboard_plugin'),
                        array( 'id' ) );
        if(isset($token))$operation->where(array('token' => $token)); 
        if(isset($version)) $operation->where(array('version' => $version));
		
		/* DEBUG */
		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
  		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */
		
		$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
		
		if ($row = $resData->current()) {
            $this->id                   = $row['id'];                
        }
        else
        {
            $ret = true;
        }
        
        /*
        if ( $row->count() == 0 ) 
        {
            $ret = true;
        }*/
        
        return $ret;
    }
    
    public function CheckPlugin ($array)
    {
        $now = '';
        foreach($array as $a)
        {
            $now .= ' token != \''.$a['token'].'\' AND ';
        }
        if($now != '')
        {
            $aa = $this->matchPlugin(preg_replace('/\W\w+\s*(\W*)$/', '$1', $now), true);
            if( sizeof($aa)>0 )
            {
                foreach($aa as $a)
                {
                    echo 'trovato da eliminare il plugin '.$a['id_plugin'];
                    if(self::Delete($this->db, $a['id_plugin']))
                    {
                        if($a['type_plugin'] == 'section')
                        {
                            //echo 'delete section';
                            return Section::DeleteFromPlugin($this->db, $a['id_area']);
                        }
                    }
                    else
                    {
                        return false; //echo ' plugin non eliminato correttamente';
                    }
                }
                
            }
            else
            {
                //tento di cercare plugin senza area abilitata
                $aa = $this->matchPlugin(preg_replace('/\W\w+\s*(\W*)$/', '$1', $now));
                if( sizeof($aa)>0 )
                {
                    foreach($aa as $a)
                    {
                        echo 'trovato da eliminare il plugin '.$a['id_plugin'];
                        if(self::Delete($this->db, $a['id_plugin']))
                        {
                            if($a['type_plugin'] == 'section')
                            {
                                //echo 'delete section';
                                return Section::DeleteFromPlugin($this->db, $a['id_area']);
                            }
                        }
                        else
                        {
                            return false; //echo ' plugin non eliminato correttamente';
                        }
                    }
                    
                }
                else
                {
                    return true;
                }
            }
        }
        else
        {
            return true;
        }
    }
    
	/**
	 * Funzione che permette di recuperare tutti i plugin dell'area.
	 * 
	 *
	 * @param int $id
	 * @return boolean $ret Esito del recupero dei dati
	 */
 
	public function matchPlugin($id, $area = false) 
    {
		$ret = false;
		$plugin_area = array();
        
		if ( isset($id) && ($id != '') ) 
        {
			$sql = new Sql($this->db);
            $operation = $sql->select();
            $operation->from(  array('S' => PREFIX.'dashboard_plugin') );                
    		if($area)
            {
                $operation->join(array('A' => PREFIX.'dashboard_plugin_area'),'S.id = A.id_plugin',
    										array( 'id_area'
    											 ) 
    									);  
    		}
            
            $operation->where($id); 
		
    		/* DEBUG */
    		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
      		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
    		/* ***** */
    		//echo $debug_sql;
    		$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
    		
    		if ($row = $resData) 
            {    
                $ret = true;
                foreach($resData as $row)
                {			
					$plugin_area[] = array( 'id_plugin'   => $row->id, 'id_area' => ($area) ? $row->id_area :'' , 'type_plugin' => $row->type_plugin );					
				}				
			}
            else
            {					
                return false;
    		}
		}

		return $plugin_area;

	}
    
	/**
	 * Funzione che permette di recuperare l'elenco dei plugin presenti.
	 * 
	 * @param mysqli $db Risorsa del database da utilizzare
	 * @param int $numxpag Numero di elementi visualizzati in una singola pagina
	 * @param int $pag La pagina visualizzata al momento del richiamo della funzione
	 * @param int $tipo Indica se si vogliono visualizzare gli utenti attivi oppure no
	 * @param string $nickname Stringa di ricerca degli utenti
	 * @param int $idproprio Filtra i risultati rendendo visibili solo quelli creati dall'utente passato come parametro
	 *
	 * @return array $ret Array con i dati ottenuti dalla query su database
	 */	
	public static function GetElementsList($ParametersList) //$db, $numxpag, $pag=1, $tipo = NULL, $nome = NULL, $tipologia = NULL) 
    {        
        $sql = new Sql($ParametersList['db_adapter']);
        $operation = $sql->select();
        $operation->from(array('A' => PREFIX.'dashboard_plugin'),
                        array(   'id',
                                 'token',
                                 'author',
                                 'name',
                                 'version',
                                 'description',
                                 'site',
                                 'type_plugin',
                                 'display_name',
                                 'img',
                                 'created_by',
                                 'status'));
        
        
        (isset($ParametersList['status']) && ($ParametersList['status'] != '0'))? $operation->where('A.status = '.$ParametersList['status']) : NULL; 
        (isset($ParametersList['text']) && ($ParametersList['text'] != ''))? $operation->where('name LIKE "%'.$ParametersList['text'].'%" OR token LIKE "%'.$ParametersList['text'].'%" OR description LIKE "%'.$ParametersList['text'].'%" OR site LIKE "%'.$ParametersList['text'].'%"') : NULL; 
        (isset($ParametersList['type']) && ($ParametersList['type'] != ''))? $operation->where("type_plugin = ".$ParametersList['type']) : NULL; 
        $operation->order(array('name'));
			
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
	 * Funzione che permette l'inserimento dei dati anagrafici dell'utente nel database.
	 * 
	 *
	 * @return boolean $ret Esito dell'inserimento dei dati
	 */	
	public function Insert() 
    {		
		$ret = false;
        
        $sql = new Sql($this->db);
        $operation = $sql->insert(PREFIX.'dashboard_plugin');
        $newData = array(
                            'token'         => $this->token,
                            'name'          => $this->name,
                            'author'        => $this->author,
                            'version'       => $this->version,
                            'description'   => $this->description,
                            'site'          => $this->site,
                            'type_plugin'   => $this->type_plugin,
                            'display_name'  => $this->display_name,
                            'img'           => $this->img,
                            'created_by'    => isset($this->created_by) ? $this->created_by	: '0',
                            'status'        => isset($this->status) ? $this->status	        : '0'
                        );
        $operation->values($newData);
		
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
		 if( self::DeleteMaster($db, 'dashboard_plugin', 'id', $id) )
        {
			 return self::DeleteMaster($db, 'dashboard_plugin_area', 'id_plugin', $id);
        }
	}
	
	/**
	 * Funzione che permette l'inserimento/aggiornamento delle aree abilitate per il plugin.
	 * 
	 *
	 * @return boolean $ret Esito dell'inserimento dei permessi
	 */	
	public function InsertAreaPlugin() 
    {
		$ret = false;
		$aree=NULL;
		
		//$sql = 'DELETE FROM '.PREFIX.'dashboard_plugin_area where id_plugin = '.$this->id.'';
		
		//Debug::ShowDebug(__FUNCTION__, $sql, __Class__);
        if(self::DeleteMaster($this->db, PREFIX.'dashboard_plugin_area', 'id_plugin', $this->id))
        {
            //echo 'eliminato tutto ok';
            foreach($this->plugin_area as $key=>$value){
                //echo ' -- id_area '.$key.' => ';
                    //$this->id_area       = $key;
                foreach($this->plugin_area[$key] as $key2=>$value2){
                    //echo ' -- id_sub '.$key2.' => ';
                    //$this->id_sub_area   = $key2;                    
                   // $this->read_p       = $value2['read'];
                    
                    //if($value2['enable'] == 1)
                    //{            
                        $sql = new Sql($this->db);
                        $operation = $sql->insert(PREFIX.'dashboard_plugin_area');
                        $newData = array(
                                            'id_plugin'     => $this->id,
                                            'id_area'       => $key,
                                            'id_area_sub'   => isset($key2) ? $key2 : 'NULL',
                                            'enable'        => $value2['enable'],
                                            'created_by'    => ID_USER_LOG,
                                            'status'        => 1
                                        );
                                        
                        $operation->values($newData);
                
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
                            return false;
                		}
                    //}
                }
            }    
        }
        else
        {
            return false;
            //echo 'elimina ko';
        } 
        
        /*
		$delete = self::DeleteMaster($this->db, PREFIX.'dashboard_plugin_area', 'id_plugin', $this->id);
        
		if ($delete) 
        {			
			foreach($this->plugin_area as $perm) 
            {
				if( $perm['enable'] == 0) 
                {
					$aree++;
				}
                else
                {
					$aree--;
                    
                    $sql = new Sql($this->db);
                    $operation = $sql->insert(PREFIX.'dashboard_plugin_area');
                    $newData = array(
                                        'id_plugin'     => $this->id,
                                        'id_area'       => $perm['id_area'],
                                        'id_area_sub'   => $perm['id_area_sub'],
                                        'created_by'    =>  $this->created_by,
                                        'status'        => 1
                                    );
                                    
                    $operation->values($newData);
		
            		
            	    if(self::executeQuery($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG))        
                    {
						$ret = true;
					}
                    else
                    {
                        return false;
					}
				}
			}
            
		}
        else
        {
            return false;
        }
		
		if($aree==count($this->plugin_area)){$ret=true;}
		*/
        
		return $ret;
	}	
	/**
	 * Funzione che permette di recuperare tutti i plugin dell'area.
	 * 
	 *
	 * @param int $id
	 * @return boolean $ret Esito del recupero dei dati
	 */
 
	public function insertArea($id_area) 
    {
		$ret = false;
        $sql = new Sql($this->db);
        $operation = $sql->insert(PREFIX.'dashboard_plugin_area');
        $newData = array(
                            'id_plugin'     => $this->id,
                            'id_area'       => $id_area,
                            'id_area_sub'   => 'NULL',
                            'enable'        => 1,
                            'created_by'    => ID_USER_LOG,
                            'status'        => 1
                        );
                        
        $operation->values($newData);

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
            return false;
		}
		

		return $ret;

	}
    
	/**
	 * Funzione che permette di recuperare tutti i plugin dell'area.
	 * 
	 *
	 * @param int $id
	 * @return boolean $ret Esito del recupero dei dati
	 */
 
	public function GetPluginFromArea($id, $id_sub) 
    {
		$ret = false;
		$plugin_area = array();
        
		if ( (isset($id) && ($id != '')) ) 
        {
            /*(isset($id_sub) && ($id_sub != ''))*/
			$sql = new Sql($this->db);
            $operation = $sql->select();
            $operation->from(  array('PA' => PREFIX.'dashboard_plugin_area'),
                            array(  'id',
                                    'id_plugin',
                                    'id_area',
                                    'id_area_sub',
                                    'enable',
                                    'created_by',
                                    'data_creation',
                                    'status'
                                 ) );
            $operation->join(array('P' => PREFIX.'dashboard_plugin'),'P.id = PA.id_plugin', NULL);
            $operation->where(array('PA.status' => 1, 'P.status' => 1, 'id_area' => $id, 'enable' => 1)); 
            if(isset($id_sub) && ($id_sub != '')){ $operation->where(array('id_area_sub' => $id_sub) );  } 
		
    		/* DEBUG */
    		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
      		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
    		/* ***** */
    		//echo $debug_sql;
    		$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
    		
    		if ($row = $resData) 
            {    
                foreach($resData as $row)
                {			
					$plugin_area[] = array( 'id_plugin'   => $row->id_plugin );					
				}
				
			}
            else
            {					
                return false;
    		}
		}

		return $plugin_area;

	}
    
	/**
	 * Funzione che permette di recuperare tutti le aree su cui abilitare il plugin.
	 * 
	 *
	 * @param int $id
	 * @return boolean $ret Esito del recupero dei dati
	 */
 
	public function GetPluginArea($id, $status = NULL) 
    {
		$ret = false;
		
		if ( isset($id) && ($id != '') ) 
        {   
			
            $sql = new Sql($this->db);
            $operation = $sql->select();
            $operation->from(  array('S' => PREFIX.'dashboard_plugin_area'),
                            array(  'id',
                                    'id_plugin',
                                    'id_area',
                                    'enable',
                                    'created_by',
                                    'data_creation',
                                    'status' 
                                 ) );
            $operation->where(array('id_plugin' => $id));        
            
            if(isset($status) && $status != "" ){
    			$operation->where("status = ".$status);
    		}
		
    		/* DEBUG */
    		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
      		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
    		/* ***** */
    		
    		$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
            
            if ($resData) {
                
                /*
				while ($row = $result->fetch_assoc()) 
                {*/
                foreach($resData as $row)
                {
					// ORIGINAL $this->plugin_area[$row->id_area] = array( 'id_area'   => $row->id_area );
					
					//$this->plugin_area[$row->id_area][0] = array( 'id_area'   => $row->id_area, 'enable'   => $row->enable);
                    //$this->plugin_area[$row->id_area][$row->id_area_sub] = array( 'id_area_sub'   => $row->id_area_sub, 'enable'   => $row->enable );
					if((isset($status) && $status != NULL))
                    {
                        $this->plugin_area[$row->id_area] = array( 'id_area'   => $row->id_area );
                    }
                    else
                    {
                        $this->plugin_area[$row->id_area][$row->id_area_sub] = array( 'enable'         => $row->enable );                        
                    }
				}
				$ret 				    = true;
				
			}
            else
            {					
                return false;
    		}
		}

		return $ret;

	}
	
	/**
	 * Funzione che permette di recuperare le informazioni di un plugin.
	 * 
	 *
	 * @param int $id
	 * @return boolean $ret Esito del recupero dei dati
	 */
 
	public function GetElement($id, $status = NULL) 
    {
		$ret = false;
		
		if ( isset($id) && ($id != '') ) 
        {
            $sql = new Sql($this->db);
            $operation = $sql->select();
            $operation->from(  array('S' => PREFIX.'dashboard_plugin'),
                            array(   'id',
                                     'token',
                                     'author',
                                     'name',
                                     'version',
                                     'description',
                                     'site',
                                     'type_plugin',
                                     'display_name',
                                     'img',
                                     'created_by',
                                     'status' 
                                 ) );
            $operation->where(array('id' => $id));        
            
            if(isset($status) && $status != "" ){
    			$operation->where("status = ".$status);
    		}
		
    		/* DEBUG */
    		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
      		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
    		/* ***** */
    		
    		$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
            
            if ($row = $resData->current()) {
                    $this->id                   = $row['id'];
                    $this->token                = $row['token'];
                    $this->author               = $row['author'];
                    $this->name                 = $row['name'];
                    $this->version              = $row['version'];
                    $this->description          = $row['description'];
                    $this->site                 = $row['site'];
                    $this->type_plugin          = $row['type_plugin'];
                    $this->display_name         = $row['display_name'];
                    $this->img                  = $row['img'];
                    $this->status               = $row['status'];
					
                    $ret = $this->GetPluginArea($id, $status);
				
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
	public function Update() 
    {		
        /*
		$ret = false;
		
		$sql = 'UPDATE '.PREFIX.'dashboard_plugin SET ';
		$sql .= 'token	        = '. (isset($this->token) 	        ? "'".$this->db->real_escape_string($this->token)."'"				    :'NULL');
		$sql .= ',name     	    = '. (isset($this->name) 	        ? "'".$this->db->real_escape_string($this->name)."'"	      			:'NULL');
		$sql .= ',author	    = '. (isset($this->author) 	        ? "'".$this->db->real_escape_string($this->author)."'"					:'NULL');
		$sql .= ',version	    = '. (isset($this->version) 		? "'".$this->db->real_escape_string($this->version)."'"					:'NULL');
		$sql .= ',description   = '. (isset($this->description) 	? "'".$this->db->real_escape_string($this->description)."'"				:'NULL');
		$sql .= ',site    	    = '. (isset($this->site) 	        ? "'".$this->db->real_escape_string($this->site)."'"				    :'NULL');
		$sql .= ',type_plugin   = '. (isset($this->type_plugin) 	? "'".$this->db->real_escape_string($this->type_plugin)."'"				:'NULL');
		$sql .= ',display_name  = '. (isset($this->display_name) 	? "'".$this->db->real_escape_string($this->display_name)."'"			:'NULL');
		$sql .= ',img           = '. (isset($this->img) 	        ? "'".$this->db->real_escape_string($this->img)."'"			            :'NULL');
		$sql .= ',created_by    = '. (isset($this->created_by) 	    ? ''.$this->created_by.''												:'NULL');
		$sql .= ',status 	    = '. (isset($this->stato) 		    ? ''.$this->stato.''													:'0');
		$sql .= ' WHERE id	    = '. $this->id;
		
		Debug::ShowDebug(__FUNCTION__, $sql, __Class__);
		
		if ($this->db->query($sql)) 
        {						
			$ret = true;			
		}
        else
        {					
            return false;
		}
        */
        
		$ret = false;
		
        $sql = new Sql($this->db);
		$operation = $sql->update(PREFIX.'dashboard_plugin');
		$newData = array(
                            'token'=> isset($this->token)?$this->token:'NULL',
                            'name'=> isset($this->name)?$this->name:'NULL',
                            'author'=> isset($this->author)?$this->author:'NULL',
							'version'=> isset($this->version)?$this->version:'NULL',
                            'description'=> isset($this->description)?$this->description:'NULL',
                            'site'=> isset($this->site)?$this->site:'NULL',
							'type_plugin'=> isset($this->type_plugin)?$this->type_plugin:'NULL',
							'display_name'=> isset($this->display_name)?$this->display_name:'NULL',
							'img'=> isset($this->img)?$this->img:'NULL',
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
	 * Funzione che permette di approvare un utente.
	 * 
	 * @param mssql $db Risorsa del database da utilizzare
	 * @param mssql $id id dell\'utente da approvare
	 * 
	 * @return array $ret Array con il risultato della query eseguita su database,
	 * 
	 */	
	public static function Approve($db, $id) 
    {   
        if(self::ApproveMaster($db, 'dashboard_plugin', $id))
        {
            return self::ChangeStatus($db, 'dashboard_plugin_area', $id, ENABLE, 'id_plugin');
        }
        else
        {
            return false;
        }
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
		if( self::DisapproveMaster($db, 'dashboard_plugin', $id) )
        {
            return self::ChangeStatus($db, 'dashboard_plugin_area', $id, DISABLE, 'id_plugin');
        }
        else
        {
            return false;
        }
	}
				
	/**
	 * Funzione che permette di installare un plugin che necessita di una sezione nel menu.
	 * 
	 * @param mssql $db Risorsa del database da utilizzare
	 * @param mssql $id id dell\'utente da approvare
	 * 
	 * @return array $ret Array con il risultato della query eseguita su database,
	 * 
	 */	
	public function Install($id) 
    {   
        //echo ($id);
        self::GetElement($id);
        if($this->type_plugin == 'section')
        {
            $section = new Section($this->db);
            $section->display_name  = $this->display_name;
            $section->area_name     = $this->name;
            $section->title         = $this->display_name;
            $section->created_by     = ID_USER_LOG;
            $section->pagina_sub    = $this->name;
            
            $ret = $section->insert();
            
            if($ret)
            {
                if(self::ApproveMaster($this->db, 'dashboard_plugin', $id))
                {
                    if(!$this->insertArea($section->id_area)){ echo 'insetArea 0 error'; return false;}
                    
                    $retS = self::ChangeStatus($this->db, 'dashboard_plugin_area', $id, ENABLE, 'id_plugin');
                    if($retS)
                    {
                        $section::Approve($this->db, $section->id_area);
                        
                        $section->titolo_sub    = 'Elenco';
                        $section->pagina_sub    = 'plugs.php?plug='.$this->name.'&p_page=List';
                        $section->img           = 'fa fa-cube';
                        $section->created_by     = '1';
                        
                        $section->sub_area_name = $this->name.'_list';
                        $retIS = $section->insertSub();
                        if(!$this->insertArea($section->id_sub_area)){ echo 'insetArea 1 error'; return false;}
                        
                        if($retIS)
                        {       
                            if( $section->insertUserArea())
                            {
                                if( $section->insertPermission() )
                                {
                                  
                            
                                    $section->titolo_sub    = 'Inserisci';
                                    $section->pagina_sub    = 'plugs.php?plug='.$this->name.'&p_page=Edit';
                                    $section->img           = 'icomoon-list2';
                                    $section->created_by     = '1';
                                    
                                    $section->sub_area_name = $this->name.'_edit';
                                    $retIS2 = $section->insertSub();
                                    if(!$this->insertArea($section->id_sub_area)){ echo 'insetArea 2 error'; return false;}
                                    
                                    if($retIS2)
                                    {
                                        if( $section->insertUserArea())
                                        {
                                            return $section->insertPermission();
                                        }
                                        //return true;
                                    }
                                    else
                                    {
                                        //echo ('1--'); exit();
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
                                return false;
                            }
                        }
                        else
                        {
                            //echo ('2--'); exit();
                            return false;
                        }
                    }
                }
                else
                {
                    //echo ('3--'); exit();
                    return false;
                }  
            }
        }
        else
        {
            if(self::ApproveMaster($this->db, 'dashboard_plugin', $id))
            {   //echo ('4'); exit();
                return self::ChangeStatus($this->db, 'dashboard_plugin_area', $id, ENABLE, 'id_plugin');
            }
            else
            {
                //echo ('5'); exit();
                return false;
            }
        }
	}
    
}



?>