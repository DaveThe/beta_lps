<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();


$array_esito = array('esito'=>0);


/************************************************
 Check CSRF attack
*************************************************/
if (isset($_POST['state']) && isset($_SESSION['state'])) {
	if (!($_POST['state'] == $_SESSION['state'])) {
		header('HTTP/1.0 401 Unauthorized');
		exit;
	}
} else {
	// Commento temporaneo per i tests
	/*header('HTTP/1.0 401 Unauthorized');
	exit();*/
}
$google_client_id 		= '1013796245322-4nva16d5cmnm8qmavvqsvmokbg6ki17d.apps.googleusercontent.com';
$google_client_secret 	= 'sRe3UBaNsQfD-D-HPyFNO9x2';
$google_redirect_url 	= 'postmessage';

/*
$gPlusWhenLogout = '	<div id="gSignInWrapper">
							<div id="customBtn">
								<a onclick="gapi.auth.signIn({\'clientid\' : \'' . $_SESSION['clientid'] . '\',\'cookiepolicy\' : \'single_host_origin\',
\'callback\' : \'signinCallback\',\'requestvisibleactions\' : \'http://schemas.google.com/AddActivity\',\'scope\' : \'https://www.googleapis.com/auth/plus.login email\'}); $(\'#customBtn\').hide();">+Sign In</a>
							</div>
						</div>';*/

/************************************************
				 Handles logout
				*************************************************/
				
				if (isset($_REQUEST['logout'])) {
					unset($_SESSION['access_token']);
					$_SESSION['logout'] = 1;
					//echo $gPlusWhenLogout;
					echo(1);
					exit();
				}
				var_dump(realpath(dirname(__FILE__) . 'include/Google/src/Google/autoload.php'));
				require_once realpath(dirname(__FILE__) . 'include/Google/src/Google/autoload.php');
				
				$client = new Google_Client();
				$client->setClientId($google_client_id);
				$client->setClientSecret($google_client_secret);
				$client->setRedirectUri($google_redirect_url);
				$client->addScope("https://www.googleapis.com/auth/plus.login");
				$client->addScope("email");

				/************************************************
				 Revoca dell'autorizzazione data all'app
				*************************************************/
				
				if (isset($_REQUEST['revoke'])) {
					$_SESSION['logout'] = 1;
					$token = json_decode($_SESSION['access_token'])->access_token;
					$discon = $client->revokeToken($token); 
					unset($_SESSION['access_token']);
					//echo $gPlusWhenLogout;
					echo(1);
					exit;
				}
				
				/*******************************************************
					Salva il token di autenticazione passato dal login 
				********************************************************/
				if (isset($_REQUEST['storeToken'])) {
					if (isset($_POST['code'])) {
						$client->authenticate($_POST['code']);
						$_SESSION['access_token'] = $client->getAccessToken();
						unset($_SESSION['logout']);
						if (isset($_SESSION['access_token']))
						{
							
						}
					}
				}
				
				/************************************************
				  Se esiste un token
				 ************************************************/
				if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
					
					// Recupera le informazioni dell'utente	
					$client->setAccessToken($_SESSION['access_token']);
					$PlusService 	= new Google_Service_Plus($client);
					$me 			= new Google_Service_Plus_Person();
					$me 			= $PlusService->people->get('me');
				  
				  	$user_email = '';
					$PlusPersonEMails = new Google_Service_Plus_PersonEmails();
					$PlusPersonEMails = $me->getEmails();
					
					foreach($PlusPersonEMails as $em) {
						if($em->type == "account") {
							$user_email = $em->value;
						}
					}
				  
					$PlusPersonName 		= new Google_Service_Plus_PersonName();
					$PlusPersonName 		= $me->getName();
					$PlusPersonImage 		= new Google_Service_Plus_PersonImage();
					$PlusPersonImage 		= $me->getImage();
					$user_id 				= $me->id;
					$user_name 				= filter_var($me->displayName, FILTER_SANITIZE_SPECIAL_CHARS);
					$user_gender 			= substr($me->gender,0,1);
					
					if ((strtoupper($user_gender) != 'M') && (strtoupper($user_gender) != 'F'))
					{
						$user_gender 	= '';
					}
					$profile_url 			= $me->url;
					$profile_image_url 		= filter_var($PlusPersonImage->getUrl(), FILTER_VALIDATE_URL);
					$parsed_url 			= parse_url($profile_image_url);
					$ImgResized				= $parsed_url['scheme'] . '://' . $parsed_url["host"]  . $parsed_url["path"] . '?sz=25';
					$given_name				= filter_var($PlusPersonName->getGivenName(), FILTER_SANITIZE_SPECIAL_CHARS);
					$family_name			= filter_var($PlusPersonName->getFamilyName(), FILTER_SANITIZE_SPECIAL_CHARS);
					
					$user_elements = array(		'id' 			=> $user_id ,
												'nickname' 		=> $user_name,
												'first_name' 	=> $given_name,
												'last_name' 	=> $family_name,
												'gender' 		=> $user_gender,
												'picture'		=> $ImgResized,
												'email' 		=> $user_email,
												'type'			=> 'GO');
												
									$array_esito = array('esito'=>4,'data'=>$user_elements);
					
				} else {
				  //header("HTTP/1.1 401 Bad token");
				}
echo(json_encode($array_esito));
?>