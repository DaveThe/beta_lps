<?php
/**
 * funzione per connettersi al db  
 * in caso di errori viene reindirizzato alla pagina di errore
**/

function DBConnect() {
    
	try
	{
		$res_id = new Zend\Db\Adapter\Adapter(array(
			'driver' => 'Mysqli',
			'database' => 'Sql948942_1',
			'username' => 'Sql948942',
			'password' => '3k8816t6m7'
		 ));
	 
         //$res_id->query('SET @@session.time_zone = "+00:00"');
         
	} catch (Zend_Db_Adapter_Exception $e) {
		// perhaps a failed login credential, or perhaps the RDBMS is not running
	} catch (Zend_Exception $e) {
		// perhaps factory() failed to load the specified Adapter class
	}
   
	return $res_id;
}

?>