<?php
namespace Dashboard;

use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;

class Section extends OriginAbstract
{

	public $id_area				= NULL;
	public $display_name 		= NULL;
	public $area_name 			= NULL;
	public $title 		        = NULL;
	public $img			 		= NULL;
	
	public $sub 				= array();
	public $fields 				= array();
	public $info 				= array();
	public $titolo_sub 			= NULL;
	public $pagina_sub 			= NULL;
	public $sub_area_name      	= NULL;
		
	public $id_user				= NULL;
	
	//GENERAZIONE DB
	
	public $nome_elem			= NULL;
	public $tipo_elem			= NULL;
	
	public $tipo_el 			= array();
	public $nome_el 			= array();
	
	public $database 			= NULL;
	public $tipo_db 			= NULL;
	public $prefisso_database 	= NULL;
	public $default_tbl			= 'false';
	public $allegati			= 'false';
	public $gallery				= 'false';
	public $ordinamento			= 'false';
    public $created_by          = NULL;
		
	/* Costruttore;
	$db : connessione al database aperta esternamente all'istanza della Classe
	*/
	public function __construct($db) {
		$this->db             = $db;
	}
		
	public function GetElement($id) {
		$ret = false;
		
		if ( isset($id) && ($id != '') ) {
				
        $sql = new Sql($this->db);
        $operation = $sql->select();
        $operation->from(  array('S' => PREFIX.'dashboard_area'),
                        array(  'id',
                                'display_name',
                                'area_name',
                                'title',
                                'img'
                             ) );
        $operation->where(array('status' => 1, 'id' => $id));
		
		/* DEBUG */
		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */
		
		$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
        
        if ($row = $resData->current()) 
        {
				
				$this->id_area 			= $row['id'];
				$this->display_name		= $row['display_name'];
				$this->area_name 		= $row['area_name'];
				$this->title    		= $row['title'];
				$this->img 				= $row['img'];
				$ret 					= true;					
											
				$sql = new Sql($this->db);
                $operation = $sqls->select();
                $operation->from(  array('S' => PREFIX.'dashboard_area_sub'),
                                array(  'id',
                                        'id_section',
                                        'name',
                                        'page',
                                        'img'
                                     ) );
                $operation->where(array('status' => 1, 'id_section' => $id)); 
		
        		/* DEBUG */
        		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
        		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
        		/* ***** */
        		
        		$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
                
        		if ($resData) 
                {                        				
                    
                    foreach($resData as $row)
                    {                        
						$this->sub[] = array(   'id'    => $row['id_area'],
                                                'name'  => $row['name'],
                                                'img'   => $row['img']);					
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
		return $ret;
	}
	
	public function insert(){		
		$ret = false;
		
        $sql = new Sql($this->db);
        $operation = $sql->insert(PREFIX.'dashboard_area');
        $newData = array(
                            'display_name'     => $this->display_name,
                            'area_name'        => strtoupper ( $this->area_name ),
                            'title'            => $this->title,
                            'img'              => isset($this->img)  ? $this->img : "fa fa-cube", 
                            'page'             => $this->pagina_sub,
                            'created_by'       => isset($this->created_by) 	? $this->created_by : "NULL",
                            'status'           => 1
                        );
                        
        $operation->values($newData);
		
		/* DEBUG */
			$debug_sql = $sql->getSqlStringForSqlObject($operation); 
      		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */

        if(self::executeQuery($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG))
        {			
			$this->id_area = self::getLastId($this->db);
			$ret = true;
					
		}
        else
        {
            return false;		 	
		}
	
		return $ret;
	}
	
    
	
	public function Update(){
	
		$ret = false;
        $sql = new Sql($this->db);
		$operation = $sql->update(PREFIX.'backoffice_area');
		$newData = array(
                            'display_name'=> isset($this->display_name)?$this->display_name:'NULL',
                            'area_name'=> isset($this->area_name)? $this->area_name :'NULL',
                            'title'=> isset($this->title)?$this->title:'NULL',
                            'img'=> isset($this->img)?$this->img:'NULL',
							'page'=> isset($this->page)?$this->page:'NULL'	
                        );
						
		$operation->set($newData);
		$operation->where('id = '.$this->id_area);
		
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
    
	public function insertPermission(){
		
		$ret = false;
        
        $sql = new Sql($this->db);
        $operation = $sql->insert(PREFIX.'dashboard_permission');
        $newData = array(
                            'id_user_area'      => $this->id_user_area,
                            'read_p'            => 1,
                            'write_p'           => 1,
                            'delete_p'          => 1,
                            'publish_p'         => 1,
                            'owned_p'          => 0,
                            'created_by'        => isset($this->created_by) ? $this->created_by : "NULL",
                            'status'            => 1
                        );
                        
        $operation->values($newData);
		
		/* DEBUG */
			$debug_sql = $sql->getSqlStringForSqlObject($operation); 
      		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */

        if(self::executeQuery($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG))
        {
			$ret = true;
		}else
        {
            return false;
		}
		
		return $ret;
		
	}
    
    
    
	public function insertUserArea(){
		
		$ret = false;
        
        $sql = new Sql($this->db);
        $operation = $sql->insert(PREFIX.'dashboard_user_area');
        $newData = array(
                            'id_user'      => $this->created_by,
                            'id_area'      => $this->id_area,
                            'id_sub_area'  => $this->id_sub_area
                        );
                        
        $operation->values($newData);
		
		/* DEBUG */
			$debug_sql = $sql->getSqlStringForSqlObject($operation); 
      		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */

        if(self::executeQuery($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG))
        {
			$this->id_user_area = self::getLastId($this->db);
			$ret = true;
		}
        else
        {
            return false;
		}
		
		return $ret;
		
	}
    
	public function insertSub(){		
		$ret = false;
        
        $sql = new Sql($this->db);
        $operation = $sql->insert(PREFIX.'dashboard_area_sub');
        $newData = array(
                            'id_section'        => $this->id_area,
                            'name'              => $this->titolo_sub,
                            'sub_area_name'     => strtoupper ( $this->sub_area_name ),
                            'page'              => $this->pagina_sub,
                            'img'               => isset($this->img) ? $this->img : 'fa fa-cube',
                            'created_by'        => isset($this->created_by) ? $this->created_by : "NULL",
                            'status'            => 1
                        );
                        
        $operation->values($newData);
		
		/* DEBUG */
			$debug_sql = $sql->getSqlStringForSqlObject($operation); 
      		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */

        if(self::executeQuery($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG))
        {
			$this->id_sub_area = self::getLastId($this->db);
			$ret = true;
		}
        else
        {
            return false;			
		}
	
		return $ret;
	}
	
	
	public function UpdateSub(){
	
		$ret = false;
        $sql = new Sql($this->db);
		$operation = $sql->update(PREFIX.'backoffice_area');
		$newData = array(
                            'id_section'=> isset($this->id_area)?$this->id_area:'NULL',
                            'name'=> isset($this->titolo_sub)? $this->titolo_sub :'NULL',
                            'sub_area_name'=> isset($this->sub_area_name)? $this->sub_area_name :'NULL',
                            'img'=> isset($this->img)?$this->img:'NULL',
							'page'=> isset($this->pagina_sub)?$this->pagina_sub:'NULL'	
                        );
						
		$operation->set($newData);
		$operation->where('id = '.$this->id_area);
		
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
	 * Funzione che permette di approvare un utente.
	 * 
	 * @param mssql $db Risorsa del database da utilizzare
	 * @param mssql $id id dell\'utente da approvare
	 * 
	 * @return array $ret Array con il risultato della query eseguita su database,
	 * contiene le informazioni sulle aree del backoffice
	 */		
	public static function DeleteSubSection($db, $id) 
    {        
        return self::DeleteMaster($db, 'dashboard_area_sub', 'id', $id);
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
	public static function ApproveSubSection($db, $id) 
    {
        return self::ApproveMaster($db, 'dashboard_area_sub', $id);       
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
	public static function DisapproveSubSection($db, $id) 
    {
        return self::DisapproveMaster($db, 'dashboard_area_sub', $id);
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
	public static function Delete($db, $id) 
    {	   
        if( self::DeleteMaster($db, 'dashboard_area', 'id', $id) )
        {
            if(self::DeleteMaster($db, 'dashboard_area_sub', 'id_section', $id))
            {
                return self::DeleteMaster($db, 'dashboard_permission', 'id_user_area', $id);
            }
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
	public static function DeleteFromPlugin($db, $id) 
    {	   //echo $id.'<br>';
        if( self::DeleteMaster($db, 'dashboard_area', 'id', $id) )
        {
            if(self::DeleteMaster($db, 'dashboard_area_sub', 'id_section', $id))
            {
                return self::DeleteMaster($db, 'dashboard_permission', 'id_user_area', $id);
            }
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
        return self::ApproveMaster($db, 'dashboard_area', $id);
        /*
        if(self::ApproveMaster($db, 'dashboard_area', $id))
        {
            return self::ApproveMaster($db, 'dashboard_area_sub', $id);
        }
        */
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
    {	return self::DisapproveMaster($db, 'dashboard_area', $id);
        /*           
        if(self::DisapproveMaster($db, 'dashboard_area', $id))
        {
            return self::DisapproveMaster($db, 'dashboard_area_sub', $id);
        }
        */
	}
	    
	public static function getSub($db, $id, $sel = NULL){
		$sub = array();
        
        $sqls = new Sql($db);
        $operation = $sqls->select();
        $operation->from(  array('S' => PREFIX.'dashboard_area_sub'),
                        array(  'id',
                                'id_section',
                                'name',
                                'page',
                                'img',
                                'created_by',
                                'status' 
                             ) );
        $operation->where(array('status' => 1, 'id_section' => $id));        
        
        if(isset($sel) && ($sel != "" && $sel != "menu")){
			$operation->where("page LIKE '%".$sel."%'");
		}elseif(isset($sel) && $sel == ""){
			$operation->where("page NOT LIKE '%edit%'");			
		}
        
        $operation->order('name');
		
		/* DEBUG */
		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */
		
		$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
        
		if ($resData) 
        {                        				
            return $resData;
		}
        else
        {
            return false;
        }
		
		return $sub;				
	}
    
	public static function GetAreaData($db, $nome = NULL)
    {        
        $sql = new Sql($db);
        $operation = $sql->select();
        $operation->from(  array('A' => PREFIX.'dashboard_area'),
                        array('id', 'display_name', 'area_name', 'title', 'img', 'page', 'status'));
        $operation->where(array('status' => 1));
        (isset($nome) && ($nome != ''))? $operation->where("A.page LIKE '%".$nome."%'") : NULL; 
		
		/* DEBUG */
		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */
		
		$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
        
		if ($resData) 
        {                        				
		  
            if($resData->current())
            {
                return $resData;
            }
            else
            {
                 return self::getSubs($db, $nome);
            }
            
		}
		else
		{
            return false;			
		}
    }	
    
    public static function getSubs($db, $nome = NULL)
    {        
        $sql = new Sql($db);
        $operation = $sql->select();
        $operation->from(array('S' => PREFIX.'dashboard_area_sub'));
        $operation->columns(array('section' => 'id', 'id' => 'id_section','page','img','name','status'))
                ->join(array('A' => PREFIX.'dashboard_area'),
                                'A.id = S.id_section',
                                array('area_name', 'title'));
        $operation->where('S.status = 1');
        (isset($nome) && ($nome != ''))? $operation->where("S.page LIKE '%".$nome."%'") : NULL; 
        $operation->order(array('S.id'));
		
		/* DEBUG */
		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */
		
		$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
        
		if ($resData) 
        {
                        				
			return $resData;
		}
		else
		{
		  return false;			
		}
    }  
    
    public static function GetAllSections($db, $nome = NULL)
    {
        $sql = new Sql($db);
        $operation = $sql->select();
        $operation->from(array('A' => PREFIX.'dashboard_area'),
                        array('id', 'display_name','area_name','title','img','status'))
                ->join(array('S' => PREFIX.'dashboard_area_sub'),
                                array('id_section', 'page', 'img', 'name'));
        $operation->where("area_name != 'INDEX' AND A.status = 1");
        (isset($nome) && ($nome != ''))? $operation->where("S.page LIKE '%".$nome."%'") : NULL; 
        $operation->order(array('A.id'));
		
		/* DEBUG */
		$debug_sql = $sql->getSqlStringForSqlObject($operation); 
		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
		/* ***** */
		
		$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
        
		if ($resData) 
        {                        				
			return $resData;	
		}
		else
		{
			return false;			
		}
    }    
        
    		
	/**
	 * Funzione che permette di prelevare tutte le sezioni e i loro permessi dal db.
	 * 
	 * @param adapter $db Risorsa del database da utilizzare
	 * @param int $numxpag Numero massimo di elementi da mostrare nella pagina
	 * @param int $pag La pagina visualizzata al momento del richiamo della funzione
	 * @param int $status Indica se si vogliono visualizzare gli elementi attivi oppure no
	 * @param string $text Stringa di ricerca degli utenti
	 * @param int $idproprio Filtra i risultati rendendo visibili solo quelli creati dall'utente passato come parametro
	 * 
	 * @return array $ret Array con il risultato della query eseguita su database,
	 * contiene le informazioni sulle aree del backoffice
	 */		
	public static function GetElementsList($ParametersList){ //$db, $numxpag, $pag=1, $text = NULL, $user = NULL, $menu = FALSE) {
        
        $sql = new Sql($ParametersList['db_adapter']);
        $operation = $sql->select();
        $operation->from(array('A' => PREFIX.'dashboard_area'),
                        array(  'id',
                                'display_name',
        						'area_name',
        						'title',
        						'img',
                                'page',
                                'status'));
        
        if (isset($ParametersList['user']) && ($ParametersList['user'] != '')) {                
            $operation->join(array('P' => PREFIX.'dashboard_permission'),
                                'P.id_area = A.id',
                                array( 'id_area',
                                    'read_p',
                                    'write_p',
                                    'delete_p',
                                    'publish_p',
                                    'own_only',
                                    'id_user'));
            
        }
        
        //($ParametersList['menu'])? $operation->where('A.status = 1')->where("A.area_name != 'DEBUGGER'") : NULL; 
        (isset($ParametersList['user']) && ($ParametersList['user'] != ''))? $operation->where("P.id_user = ".$ParametersList['user']) : NULL; 
        (isset($ParametersList['text']) && ($ParametersList['text'] != ''))? $operation->where("A.page LIKE '%".$ParametersList['text']."%'") : NULL; 
        $operation->order(array('A.id'));
		
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
	
}
?>