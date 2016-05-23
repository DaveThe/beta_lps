<?php
	
    //if($resp_code==0){
        $permissions = $Dashboard_user->checkPermission($Dashboard_user->id, PAGE_NAME, PAGE_SUB);
        //var_dump(PAGE_NAME);
        //var_dump(PAGE_SUB);
        //var_dump($permissions);
        $READ = $permissions['READ'];
        $WRITE = $permissions['WRITE'];
        $DELETE = $permissions['DELETE'];
        $PUBLISH = $permissions['PUBLISH'];
        $OWN_ONLY = $permissions['OWN_ONLY'];
        
        if(!$READ)
        {
            echo 'non puoi leggere';
            //header('Location: index.php?resp_code=605');            
  		    exit ();  
        }
        
        /*
        //CONTROLLO SE L'UTENTE HA I PERMESSI PER ACCEDERE ALLA SEZIONE MASTER
        if(!$Dashboard_user->checkPermission($Dashboard_user->id, $area['area_name'], READ))
        {
    		header('Location: index.php?resp_code=605');            
    		exit ();
    	}
    
        //CONTROLLO SE L'UTENTE HA I PERMESSI PER ACCEDERE ALLA SOTTO-SEZIONE
        if( defined(PAGE_SUB) && (PAGE_SUB != '') ) 
        {
            if(!$Dashboard_user->checkPermission($Dashboard_user->id, $area['area_name'], READ))
            {
        		header('Location: index.php?resp_code=605');            
        		exit ();
        	}
        }
        
        //CONTROLLO SE HA I PERMESSI PER VEDERE ANCHE I DATI INSERITI DA ALTRI UTENTI
 	    if($Dashboard_user->checkPermission($Dashboard_user->id, $area['area_name'], OWN_ONLY))
         {
    		$idproprio	= $Dashboard_user->id;
    	}
    	
    	//CONTROLLO SE L'UTENTE HA IL PERMESSO DI CREA/MODIFICA SULL'AREA
        if(!$Dashboard_user->checkPermission($Dashboard_user->id, $area['area_name'], WRITE))
        {
    		header('Location: '.strtolower($page).'.php?resp_code=605');
    		exit ();
    	}
        */
    //}
?>