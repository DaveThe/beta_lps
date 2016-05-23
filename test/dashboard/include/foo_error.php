<?php
$msg_lng = include('plugin/lang/it.php');

switch($resp_code) {
	
	/** AVVISI GENERICI **/
	case 100:
	{
		$respok 	= $msg_lng['GEN']['INSERT_OK'];
		break;
	}
	case 105:
	{
		$errors[] 	= $msg_lng['GEN']['INSERT_KO'];
		break;
	}
	case 110:
	{
		$respok 	= $msg_lng['GEN']['EDIT_OK'];
		break;
	}
	case 115:
	{
		$errors[] 	= $msg_lng['GEN']['EDIT_KO'];
		break;
	}	
	case 120:
	{
		$respok 	= $msg_lng['GEN']['APPROVE_OK'];
		break;
	}
	case 125:
	{
		$errors[] 	= $msg_lng['GEN']['APPROVE_KO'];
		break;
	}	
	case 130:
	{
		$respok 	= $msg_lng['GEN']['NOT_APPROVE_OK'];
		break;
	}
	case 135:
	{
		$errors[] 	= $msg_lng['GEN']['NOT_APPROVE_KO'];
		break;
	}
	case 140:
	{
		$respok 	= $msg_lng['GEN']['DELETE_OK'];
		break;
	}
	case 145:
	{
		$errors[] 	= $msg_lng['GEN']['DELETE_KO'];
		break;
	}
	
	/**AVVISI PER ALLEGATI**/
	case 200:
	{
		$respok 	= $msg_lng['ATC']['UPLOAD_OK'];
		break;
	}
	case 205:
	{
		$errors[] 	= $msg_lng['ATC']['UPLOAD_KO'];
		break;
	}
	case 210:
	{
		$respok 	= $msg_lng['ATC']['DELETE_OK'];
		break;
	}
	case 215:
	{
		$errors[] 	= $msg_lng['ATC']['DELETE_KO'];
		break;
	}
	case 220:
	{
		$respok 	= $msg_lng['ATC']['APPROVE_OK'];
		break;
	}
	case 225:
	{
		$errors[] 	= $msg_lng['ATC']['APPROVE_KO'];
		break;
	}
	case 230:
	{
		$respok 	= $msg_lng['ATC']['NOT_APPROVE_OK'];
		break;
	}
	case 235:
	{
		$errors[] 	= $msg_lng['ATC']['NOT_APPROVE_KO'];
		break;
	}
			
	
	/**AVVISI PER IMMAGINI**/
	
	case 30:
	{
		$respok 	= $msg_lng['IMG']['UPLOAD_OK'];
		break;
	}
	case 305:
	{
		$errors[] 	= $msg_lng['IMG']['UPLOAD_KO'];
		break;
	}
	case 310:
	{
		$respok 	= $msg_lng['IMG']['DELETE_OK'];
		break;
	}
	case 315:
	{
		$errors[] 	= $msg_lng['IMG']['DELETE_KO'];
		break;
	}
	case 320:
	{
		$respok 	= $msg_lng['IMG']['APPROVE_OK'];
		break;
	}
	case 325:
	{
		$errors[] 	= $msg_lng['IMG']['APPROVE_KO'];
		break;
	}
	case 330:
	{
		$respok 	= $msg_lng['IMG']['NOT_APPROVE_OK'];
		break;
	}
	case 335:
	{
		$errors[] 	= $msg_lng['IMG']['NOT_APPROVE_KO'];
		break;
	}
	
			
	
	/**AVVISI PER USER**/
	
	case 400:
	{
		$respok 	= $msg_lng['USER']['INSERT_OK'];
		break;
	}
	case 405:
	{
		$errors[] 	= $msg_lng['USER']['INSERT_KO'];
		break;
	}
	case 410:
	{
		$respok 	= $msg_lng['USER']['EDIT_OK'];
		break;
	}
	case 415:
	{
		$errors[] 	= $msg_lng['USER']['EDIT_KO'];
		break;
	}	
	case 420:
	{
		$respok 	= $msg_lng['USER']['APPROVE_OK'];
		break;
	}
	case 425:
	{
		$errors[] 	= $msg_lng['USER']['APPROVE_KO'];
		break;
	}	
	case 430:
	{
		$respok 	= $msg_lng['USER']['NOT_APPROVE_OK'];
		break;
	}
	case 435:
	{
		$errors[] 	= $msg_lng['USER']['NOT_APPROVE_KO'];
		break;
	}
	case 440:
	{
		$respok 	= $msg_lng['USER']['DELETE_OK'];
		break;
	}
	case 445:
	{
		$errors[] 	= $msg_lng['USER']['DELETE_KO'];
		break;
	}

			
	/**AVVISI PER PERMESSI**/	
	
	case 500:
	{
		$respok 	= $msg_lng['CRED']['INSERT_OK'];
		break;
	}
	case 505:
	{
		$errors[] 	= $msg_lng['CRED']['INSERT_KO'];
		break;
	}
	case 510:
	{
		$respok 	= $msg_lng['CRED']['EDIT_OK'];
		break;
	}
	case 515:
	{
		$errors[] 	= $msg_lng['CRED']['EDIT_KO'];
		break;
	}	
			
	
	/**AVVISI PER NAVIGAZIONE GENERALE**/
	
	
	case 605:
	{
		$errors[] 	= $msg_lng['GEN_PAGE']['CRED_PAGE_KO'];
		break;
	}
	case 615:
	{
		$errors[] 	= $msg_lng['GEN_PAGE']['ELEMENT_EXIST_KO'];
		break;
	}	
	case 625:
	{
		$errors[] 	= $msg_lng['GEN_PAGE']['PAGE_EXIST_KO'];
		break;
	}
	case 635:
	{
		$errors[] 	= $msg_lng['GEN_PAGE']['GENERAL_KO'];
		break;
	}
	case 645:
	{
		$errors[] 	= $msg_lng['GEN_PAGE']['DB_KO'];
		break;
	}
	
	/**AVVISI PER PERMESSI**/	
	
	case 700:
	{
		$respok 	= $msg_lng['PUSH']['INSERT_OK'];
		break;
	}
	case 705:
	{
		$errors[] 	= $msg_lng['PUSH']['INSERT_KO'];
		break;
	}
	case 710:
	{
		$respok 	= $msg_lng['PUSH']['EDIT_OK'];
		break;
	}
	case 715:
	{
		$errors[] 	= $msg_lng['PUSH']['EDIT_KO'];
		break;
	}
	case 720:
	{
		$respok 	= $msg_lng['PUSH']['APPROVE_OK'];
		break;
	}
	case 725:
	{
		$errors[] 	= $msg_lng['PUSH']['APPROVE_KO'];
		break;
	}	
	case 730:
	{
		$respok 	= $msg_lng['PUSH']['NOT_APPROVE_OK'];
		break;
	}
	case 735:
	{
		$errors[] 	= $msg_lng['PUSH']['NOT_APPROVE_KO'];
		break;
	}	
	case 740:
	{
		$respok 	= $msg_lng['PUSH']['DELETE_OK'];
		break;
	}
	case 745:
	{
		$errors[] 	= $msg_lng['PUSH']['DELETE_KO'];
		break;
	}
}
?>