<?php 
/**
 * La Class Permessi gestisce i permessi relativi agli utenti del backoffice e le operazioni di login.
 * 
 *
 * @version   1.00
 * @since     2013-09-17
 */
namespace Dashboard;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
class Permessi {
	
	/**
	 * Array che conterrà i permessi dell'utente
	 *
	 * @var array
	 *
	 */
	public $permessi 	= array();
	
	private $db 		= NULL;
	
	/**
	 * Costruttore della Class
	 *
	 * @param mssql $db Risorsa del database da utilizzare
	 *
	 */
	public function __construct($db) {
		$this->db 		= $db;
	}
	
	/**
	 * Funzione che permette il login dell'utente sulla piattaforma di backoffice
	 *
	 * @param string $user Username dell'utente passato dal form di login
	 * @param string $user Password dell'utente passato dal form di login
	 * @param mssql $db Risorsa del database da utilizzare
	 *
	 * @return array $ret Array con le informazioni dell'utente loggato.
	 */
	public static function Login($user, $pass, $db) {
		
		$sec=new Secret();
		$ret = false;
		//$sec->encript($pass)
        /*
		$sql = 'SELECT id,
                       username,
                       password,
                       nickname,
                       company,
                       email,
                       gender,
                       type_user,
                       img,
                       created_by,
                       data_creation,
                       status  
				FROM '.PREFIX.'dashboard_users 
				WHERE username = \''.$db->real_escape_string($user).'\' AND password = \''.$db->real_escape_string($pass).'\' AND status = 1';*/
		
        $sql = "SELECT 
                       id,
                       username,
                       password,
                       nickname,
                       company,
                       email,
                       gender,
                       type_user,
                       img,
                       created_by,
                       data_creation,
                       status  
				FROM ".PREFIX."dashboard_users 
				WHERE username = ? AND password = ? AND status = ?";
                
        $statement = $db->query($sql);
                                    
        $results = $statement->execute(array(
                                                'username' => $user,
                                                'password' => $pass,
                                                'id' => 1));
                                                
        Debug::ShowDebug(__FUNCTION__, $sql, __Class__);
                     
            
		if($results){
		
			if ($row = $results->current()) {
			 
				$ret = array(   'iduser'    => $row['id'],
                                'username'  => $row['username'],
                                'nickname'  => $row['nickname'],
                                'img'       => $row['img'],
                                'gender'    => $row['gender'],
                                'company'   => $row['company'],
                                'type'      => $row['type_user']);
			}
			
		}
        else
        {					
			//recupero e salvo l'errore sui permessi
			$info=debug_backtrace();
			Log::logsError($this->db, ERROR, "Errore durante il recupero dei permessi dell'utente - mssql_query:".$sql." - mysql_errno: ".$this->db->errno." - mysql_error_description: ".$this->db->error, 2,Log::stackTrace($info));		
		}
		return $ret;
	}
	
    
			
	/**
	 * Funzione che permette di disapprovare un utente.
	 * 
	 * @param mssql $db Risorsa del database da utilizzare
	 * 
	 * @return array $ret Array con il risultato della query eseguita su database,
	 * contiene le informazioni sulle aree del backoffice
	 */	
	public function CheckAPIKey($token)//$headers) 
    {   
    	$ret = false;
		
        if(isset($token) && $token != '')
        {                
            $sql = new Sql($db);
            $operation = $sql->select();
            $operation->from(  array('S' => PREFIX.'dashboard_area_sub'),
                            array(  'id'  ) );
            $operation->where(array('id' => $id));        
            $operation->where('CONCAT("Basic ", TO_BASE64(CONCAT(`username`,":", `password`)),"==") = \''.$token.'\'');
            
            if(isset($status) && $status != "" )
            {
    			$operation->where("status = 1");
    		}
			
			/* DEBUG */
			$debug_sql = $sql->getSqlStringForSqlObject($operation); 
      		Debug::ShowDebug(__FUNCTION__, $debug_sql, __CLASS__, basename(__FILE__));
			/* ***** */
                    
            $resData = self::getRecord($sql,$operation)->current();
            
            if ($row = $resData)
            {					
					$ret   = $row['id'];	
			}
            else
            {
    			$info = debug_backtrace();
                $log  = new Log($this->db, ERROR, __FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, $info, $this->db->errno, $this->db->error, $this->created_by);                            
                $log->Insert();
    			return false;
			}
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
		if( !isset($_SESSION['dashboard_login']) || $_SESSION['dashboard_login'] != true ){
			header('Location: login.php');
			exit ();
		}
	}
	
	/**
	 * Funzione che restituisce i permessi relativi all'utente passato come parametro
	 *
	 * @param int $iduser Id dell'utente 
	 *
	 */
	public function GetElements($iduser) {
		
		$ret = false;
		$sql = 'SELECT  A.id,
                        id_user, 
                        id_area,
                        P.read_p, 
                        P.write_p, 
                        P.delete_p, 
                        P.publish_p, 
                        P.own_only, 
                        P.created_by, 
                        P.status,
                        A.area_name,
                        A.display_name,
                        A.title,
                        A.img,
                        A.page 
                FROM '.PREFIX.'dashboard_permission P 
                JOIN '.PREFIX.'dashboard_area A ON P.id_area=A.id  
                WHERE id_user = ? ';
                
		$statement = $this->db->query($sql);
        
        $results = $statement->execute(array(
                                                'id_user' => $iduser));
                                                
        Debug::ShowDebug(__FUNCTION__, $sql, __Class__);
        
		if ($results instanceof ResultInterface && $results->isQueryResult()) {
            
            $result = new ResultSet();
            $results->buffer();
            $test = $result->initialize($results);
            
            foreach ($test as $row) 
            {
                $this->permessi[$row->area_name] = array( 'read'      => $row->read_p,
                                                            'write'     => $row->write_p,
                                                            'delete'    => $row->delete_p,
                                                            'publish'   => $row->publish_p,
                                                            'own_only'  => $row->own_only);
            }
            
		}
        else
        {					
			//recupero e salvo l'errore sui permessi
			$info=debug_backtrace();
			Log::logsError($this->db, ERROR, "Errore durante il recupero dei permessi dell'utente - mssql_query:".$sql." - mysql_errno: ".$this->db->errno." - mysql_error_description: ".$this->db->error, 2,Log::stackTrace($info));		
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
	public function CheckPermessi($iduser, $area, $action = NULL, $page, $id_element, $img, $mode ) {
		
		//$ret = false; echo $iduser. ' --- '. $area;
        //var_dump($this->permessi); 
		if (isset($this->permessi) && is_array($this->permessi) && array_key_exists($area,$this->permessi)){
			$ret=true;
		}else{
			return false;
		}
		
		switch($action){
			case 1:                
				if($this->permessi[$area]['read']==1){
					$ret = true;
				}else{
					return false;
				}
			break;
			case 2:
				if($this->permessi[$area]['write']==1){
				    if($mode != '')
                    {
    					if($mode == 'button'){
    						$ret = '<a href="'.$page.'-edit.php?id='.$id_element.'" ><span Class=" iconia '.$img.'"></span></a>';
    					} else {
    						$ret = 'Edit';
    					}
                    }
                    else
                    {
                        $ret = true;
                    }
				}else{
					return '';
				}
			break;
			case 3:
				if($this->permessi[$area]['delete']==1){
					if($mode == 'button'){
						$ret = '<a href="#" onclick="deleteP('.$id_element.');" ><span Class=" iconia '.$img.'"></span></a>';
					} else {
						$ret = 'Delete';
					}
				}else{
					return false;
				}
			break;
			case 4:
				if($this->permessi[$area]['publish']==1){						
					if($mode == 'button'){
						if($img == 0){
							$ret = '<a href="#" onclick="approvaP('.$id_element.');" ><span Class="label label-warning">Disapproved</span></a>';
						} else {
							$ret = '<a href="#" onclick="disapprovaP('.$id_element.');" ><span Class="label label-success">Approved</span></a>';
						}
					} 
                    elseif($mode == 'install'){
						if($img == 0){
							$ret = '<a href="#" onclick="install('.$id_element.');" ><span Class="label label-warning">Unistall</span></a>';
						} else {
							$ret = '<a href="#" onclick="uninstall('.$id_element.');" ><span Class="label label-success">Install</span></a>';
						}
					} 
                    elseif($mode == 'selectlog')
                    {
                        $ret = '        
							<!-- select -->
								<select Class="form-control" id="error_type" name="error_type" onchange="changeStatus('.$img.')">
									<option value="0" '.( ( isset($img) && $img == "0" ) ? 'selected="selected"': "" ).' >Irrisolto</option>
									<option value="1" '.( ( isset($img) && $img == "1" ) ? 'selected="selected"': "" ).'>Risolto</option>
									<option value="2" '.( ( isset($img) && $img == "2" ) ? 'selected="selected"': "" ).'>In attesa</option>
								</select>
                        ';
                    }
                    else 
                    {
						$ret = 'Status';
					}
				}else{
					return false;
				}
			break;
			case 5:
				if($this->permessi[$area]['own_only']==1){					
					$ret = true;
				}else{
					return false;
				}
			break;
			
			default:
				return false;
			break;
		}
				
		return $ret;
	}
}
?>