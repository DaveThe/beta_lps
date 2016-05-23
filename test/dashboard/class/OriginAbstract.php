<?php
namespace Dashboard;

use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Helper\PaginationControl;
use Zend\View\Resolver;    //necessary 

abstract class OriginAbstract
{
    protected $db         = NULL;
    //public $created_by    = NULL;
    // Force Extending class to define this method
    abstract protected function GetElement($id);     // Recupero singolo Record
    
    abstract protected function Insert();           // Inserisco un Record
    
    abstract protected function Update();           // Aggiorno un Record
    
    // Elimino Record
    public static function Delete($db, $id){}            
    
    public static function GetElementsList($ParametersList){}  // Recupero tutti gli elementi paginati
    
    public static function Approve($db, $id){}          // Cambio stato a 1
    
    public static function Disapprove($db, $id){}       // Cambio stato a 0
    
    //abstract protected function Order();            // Cambio posizione record, porto su o giù
    
    	
	/**
	 * Funzione magico per gestire l'overloading dei metodi.
	 * 
	 * @param mssql $name nome della funzione chiamata
	 * @param mssql $args argomenti della funzione chiamata
	 * 
	 * @return array $ret Array con il risultato della query eseguita su database,
	 * contiene le informazioni sulle aree del backoffice
	 *	
    public function __call($name, $args) {

        switch ($name) {
            case 'Approve':
                switch (count($args)) {
                    case 2:
                        return call_user_func_array(array($this, 'ApproveMaster'), $args);
                    case 3:
                        return call_user_func_array(array($this, 'SetApproved'), $args);
                 }
            case 'Disapprove':
                switch (count($args)) {
                    case 0:
                        return call_user_func_array(array($this, 'DisapproveMaster'), $args);
                    case 5:
                        return call_user_func_array(array($this, 'SetDisapproved'), $args);
                }
        }
    }*/
	
	/**
	 * Funzione che permette di eseguire le select su Database.
	 * 
	 * @param mssql $sql Risorsa del database da utilizzare
	 * @param mssql $select Risorsa della selezione
	 * 
	 * @return array $ret Array con il risultato della query eseguita su database,
	 * contiene le informazioni sulle aree del backoffice
	 */	
    public static function getRecord($sql, $operation, $function = NULL, $class = NULL, $file = NULL, $debug_sql = NULL, $info = NULL, $created_by = NULL)
    {
        try
        {   
            $results = self::executeQuery($sql,$operation, $function, $class, $file, $debug_sql, $info, $created_by);
		     
            if ($results instanceof ResultInterface && $results->isQueryResult()) {
                
                $result = new ResultSet();
                $results->buffer();
                $resData = $result->initialize($results);
                return $resData; 
            }
            else
            {
                return false;
            }
                        
        }
        catch(\Exception $e)
        {           
			$info = debug_backtrace();
            $log  = new Log($this->db, ERROR, $function, $class, $file, $debug_sql, $info, $e->getMessage(), $e->getMessage(), $created_by);                            
            $log->Insert();
			return false;
        }        
    }
    
    /**
	 * Funzione che permette di eseguire le query su Database.
	 * 
	 *
	 */	
    public static function executeQuery($sql,$operation, $function = NULL, $class = NULL, $file = NULL, $debug_sql = NULL, $info = NULL, $created_by = NULL)
    {
        try
        {
            $statement = $sql->prepareStatementForSqlObject($operation);
            $results = $statement->execute();                        
        }
        catch(\Exception $e)
        {                              
            $log  = new Log($sql->getAdapter(), ERROR, $function, $class, $file, $debug_sql, $info, $e->getMessage(), $e->getTraceAsString(), $created_by);
            $log->Insert();
			return false;
        }
		return $results;
    }
	
    /**
	 * Funzione che permette di eseguire le query su Database.
	 * 
	 *
	 */	
    public static function getLastId($db)
    {	
		return $db->getDriver()->getLastGeneratedValue();
    }
			
	/**
	 * Funzione che permette di ordinare gli elementi di una lista.
	 * 
	 * @param mssql $db Risorsa del database da utilizzare
	 * 
	 * @return array $ret Array con il risultato della query eseguita su database,
	 * contiene le informazioni sulle aree del backoffice
	 */	
	public function Order($db, $contatore, $direzione, $table) {
	   
		$ret = false;
		if(isset($contatore) && $contatore!=''){ 
			
            $sql = 'SELECT  id,
                            posizione 
					FROM '.$table.'
					
					WHERE id ='.$contatore;
					
			Debug::ShowDebug($debug,__FUNCTION__,$sql);
			
			if($result = $this->db->query($sql)) {
			
				if($row = $result->fetch_assoc()) {
                
					//posizione e id elemento selezionato	
					$old_id 	= $row['id'];
					$old_pos 	= $row['posizione'];
                    
				}
					
				$sql = 'SELECT TOP 1 posizione, id 
						FROM '.$table.'
						WHERE posizione '.$direzione.' '.$old_pos; 

				if ($direzione == '>')
				{
					$sql .=	' ORDER BY posizione ASC';
				}
				else
				{
					$sql .=	' ORDER BY posizione DESC';
				}
	
					
				Debug::ShowDebug($debug,__FUNCTION__,$sql);
                
				//trovo la posizione direttamente superiore                
                if($result = $this->db->query($sql)) {
                
                    if($row = $result->fetch_assoc()) {
                    
						//aggiorno la posizione del selezionato a quella superiore			
						$sql = 'UPDATE '.$table.' SET posizione='.$row['posizione'].' WHERE id = '.$contatore;
						
						Debug::ShowDebug($debug,__FUNCTION__,$sql);
						
						if($db->query($sql)) {
							//aggiorno la posizione del selezionato in quella del superiore			
							$sql = 'UPDATE '.$table.' SET posizione='.$old_pos.' WHERE id='.$row['id'];
							
							Debug::ShowDebug($debug,__FUNCTION__,$sql);
							
							if($db->query($sql)) {
								$ret = true;
							} else {					
								//recupero e salvo l'errore durante l'approvazione della news
								$info=debug_backtrace();
                                Log::logsError($db, ERROR, "Errore durante il recupero dell'elenco news - mysql_query:".$sql." - mysql_errno: ".$db->errno." - mysql_error_description: ".$db->error, 37,Log::stackTrace($info));				
							}
						}else{					
							//recupero e salvo l'errore durante l'approvazione della news
							$info=debug_backtrace();	
                            Log::logsError($db, ERROR, "Errore durante il recupero dell'elenco news - mysql_query:".$sql." - mysql_errno: ".$db->errno." - mysql_error_description: ".$db->error, 37,Log::stackTrace($info));			
						}
					}
				}else{					
					//recupero e salvo l'errore durante l'approvazione della news
					$info=debug_backtrace();	
                    Log::logsError($db, ERROR, "Errore durante il recupero dell'elenco news - mysql_query:".$sql." - mysql_errno: ".$db->errno." - mysql_error_description: ".$db->error, 37,Log::stackTrace($info));			
				}
			}else{					
				//recupero e salvo l'errore durante l'approvazione della news
				$info=debug_backtrace();	
                Log::logsError($db, ERROR, "Errore durante il recupero dell'elenco news - mysql_query:".$sql." - mysql_errno: ".$db->errno." - mysql_error_description: ".$db->error, 37,Log::stackTrace($info));			
			}
		}
		return $ret;
	}
    
    
	/**
	 * Funzione che permette di cambiare lo stato di un elemento.
	 * 
	 * @param mssql $db Risorsa del database da utilizzare
	 * @param mssql $table tabella dove si trova l\'elemento
	 * @param mssql $id id dell\'elemento
	 * @param mssql $field il campo della tabella da cambiare
	 * 
	 * @return array $ret Array con il risultato della query eseguita su database,
	 * 
	 */	
	public static function ChangeStatus($db, $table, $id, $value, $field) 
    {	   
		$ret        = false;        
        $sql        = new Sql($db);
        $operation     = $sql->update(PREFIX.$table);
        $newData    = array('status'  => $value );
        $operation->set($newData);
        $operation->where($field.' = '.$id);
        
        $results = self::executeQuery($sql,$operation);
		if ($results) 
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
	 * Funzione che permette di cambiare lo stato di un elemento.
	 * 
	 * @param mssql $db Risorsa del database da utilizzare
	 * @param mssql $table tabella dove si trova l\'elemento
	 * @param mssql $id id dell\'elemento
	 * @param mssql $field il campo della tabella da cambiare
	 * 
	 * @return array $ret Array con il risultato della query eseguita su database,
	 * 
	 */	
	public static function ToggleStatus($db, $table, $id) 
    {	   
		$ret        = false;  
        
        $sql = new Sql($this->db);
        $operation = $sql->select();
        $operation->from(  array('T' => PREFIX.$table),
                        array(  
                                'id',
                                'status'
                             ) 
                        );
        
        $operation->where(array('T.id' => $id));
		        
		$resData = self::getRecord($sql,$operation,__FUNCTION__, __CLASS__, basename(__FILE__), $debug_sql, debug_backtrace(), ID_USER_LOG);
		
		if ($row = $resData->current()) 
        {
            $status 		= ( (isset($row['status']) && $row['status'] == '1') ? '0' : '1' );
                  
            $sql_u          = new Sql($db);
            $operation_u    = $sql->update(PREFIX.$table);
            $newData        = array('status'  => $status );
            $operation_u->set($newData);
            $operation_u->where('status = '.$id);
            
            $results = self::executeQuery($sql_u,$operation_u);
    		if ($results) 
            {				
    			$ret = true;
    		}
            else
            {   
    			return false;
            }
		}
		return $ret;
	}
    
	/**
	 * Funzione che permette di eliminare un elemento.
	 * 
	 * @param mssql $db Risorsa del database da utilizzare
	 * @param mssql $id id dell\'elemento da eliminale
	 * 
	 * @return array $ret Array con il risultato della query eseguita su database,
	 * 
	 */	
	public static function DeleteMaster($db, $table, $field, $id) 
    {	   
		$ret = false;
        		        
        $sql        = new Sql($db);
        $operation     = $sql->delete(PREFIX.$table);
        $operation->where($field.' = '.(int)$id);
        
        $debug_sql = $sql->getSqlStringForSqlObject($operation); 
        $results = self::executeQuery($sql,$operation);
        
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
	 * Funzione che permette di approvare un elemento.
	 * 
	 * @param mssql $db Risorsa del database da utilizzare
	 * @param mssql $id id dell\'elemento da approvare
	 * 
	 * @return array $ret Array con il risultato della query eseguita su database,
	 * 
	 */	
	public static function ApproveMaster($db, $table, $id) 
    {	   
        return self::ChangeStatus($db, PREFIX.$table, $id, ENABLE, 'id');
	}
	
	/**
	 * Funzione che permette di disapprovare un elemento.
	 * 
	 * @param mssql $db Risorsa del database da utilizzare
	 * @param mssql $id id dell\'elemento da disapprovare
	 * 
	 * @return array $ret Array con il risultato della query eseguita su database,
	 * 
	 */	
	public static function DisapproveMaster($db, $table, $id) 
    {	   
        return self::ChangeStatus($db, PREFIX.$table, $id, DISABLE, 'id');
	}
    
    
	/**
	 * Funzione che permette di recuperare l'elenco degli elementi e li pagina.
	 * 
	 * @param mysqli $db Risorsa del database da utilizzare
	 * @param int $numxpag Numero di utenti visualizzati in una singola pagina
	 * @param int $pag La pagina visualizzata al momento del richiamo della funzione
	 *
	 * @return array $ret Array con i dati ottenuti dalla query su database
	 */	
	public static function GetPagination($numxpag, $pag=1, $results = NULL) {
	    
        
        $paginator = new Paginator(new ArrayAdapter($results));
        $paginator->setCurrentPageNumber($pag)
        ->setItemCountPerPage($numxpag)
        ->setPageRange(6);
        $paginator->setDefaultScrollingStyle('Sliding');
        
        
        $renderer = new PhpRenderer;
        $resolver = new Resolver\AggregateResolver();
        $map = new Resolver\TemplateMapResolver(array(
        'pagination'      => '../include/pagination.phtml',
        ));
        
        $resolver->attach($map);
        $renderer->setResolver($resolver);
        $paginator->setView($renderer);
        
        PaginationControl::setDefaultViewPartial('pagination');
        
        //var_dump ($paginator); //for test
        return $paginator;
	}
}

?>