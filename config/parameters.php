<?php

	$errors         = array();
	$resp_code      = isset($_GET["resp_code"]) && is_numeric($_GET["resp_code"])				? (int) ($_GET["resp_code"]) 									: 0;
	$respok         = NULL;
	$limit			= NULL;
	$idproprio	    = NULL;
    
	$id             = isset($_GET["id"]) && trim($_GET["id"]) != "" && is_numeric($_GET["id"]) 	? (int) $_GET["id"] 											: NULL;
	
	$_pag			= isset($_GET["pag"]) && trim($_GET["pag"])!="" && is_numeric($_GET["pag"]) ? (int)$_GET["pag"] 											: 1;
	$_st 			= isset($_GET["st"])&& trim($_GET["st"])!="" && is_numeric($_GET["st"]) 	? (int)$_GET["st"] 												: 0;
	$_text 			= isset($_GET["text"]) 														? trim($_GET["text"]) 											: NULL;
	$_type 			= isset($_GET["type"]) 														? trim($_GET["type"]) 											: NULL;
	
	$active_tab 	= isset($_GET["tab"]) 														? trim($_GET["tab"]) 											: 'tab_1';
	
	
    
    $ParametersList = array(
                            'db_adapter'        => $db,
                            'elements_in_page'  => '20',
                            'page'              => $_pag,
                            'text'              => $_text,
                            'status'            => $_st,
                            'type'              => $_type,
                            'own_element'       => $idproprio,
                            'pagination'        => true
                            );
                            
	$_page 			= isset($_GET["p_page"]) 		? trim($_GET["p_page"])       : NULL;
    $_plug 			= isset($_GET["plug"]) 			? trim($_GET["plug"])       : NULL;
    
    $querystring 	= 'id='.$id.'&text='.urlencode($_text).'&st='.$_st.'&p_page='.$_page.'&plug='.$_plug;
    
    //if(PAGE_SUB == 'PLUGS') define("PAGE_PLUG", strtoupper ( $_plug.'_'.$_page ) );
?>