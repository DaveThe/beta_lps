<?php

/**
 * La class Social contiene tutte le operazioni relative alla gestione dei social login
 *
 *
 * @version   1.00
 * @since     2015-05-29
 * @author    Andrea Tiraboschi
 */

class Social
{
	/**
	*
	* Variabili che indicano le chiavi per utilizzare le app di login
	*/
	
	private $FB_APP_ID 			= '698255393636113'; 
	private $FB_SECRET 			= '43e8e82fc4a2fd818ec30adb0c9430a2';
	private $GO_CLIENT_ID 		= '1013796245322-4nva16d5cmnm8qmavvqsvmokbg6ki17d.apps.googleusercontent.com';
	private $GO_CLIENT_SECRET 	= 'sRe3UBaNsQfD-D-HPyFNO9x2';
	private $GO_RED_URL		 	= 'postmessage';
	private $STATE_CODE			= NULL;
	
	function __construct()
	{
		if(isset($_SESSION['state']))
		{
			//Già generato un codice di sessione
			$this->STATE_CODE = $_SESSION['state'];
		}
		else
		{
			//Genero un codice e lo salvo in sessione
			$this->STATE_CODE = md5(uniqid(rand(), TRUE));
			$_SESSION['state'] = $this->STATE_CODE;
		}
	}
	
	public function getFBKey()
	{
		return $this->FB_APP_ID;
	}
	
	public function getFBSecret()
	{
		return $this->FB_SECRET;
	}
	
	public function getGOKey()
	{
		return $this->GO_CLIENT_ID ;
	}
	
	public function getGOSecret()
	{
		return $this->GO_CLIENT_SECRET ;
	}
	
	public function getGORedUrl()
	{
		return $this->GO_RED_URL;
	}
	
	public function getState()
	{
		return $this->STATE_CODE ;
	}
		
	public function login($par)
	{
		$array_esito = array('esito' => 0, 'data' => ''); 
		
		switch($par)
		{
			case 'FB': 
			{
				require_once('include/Facebook/facebook.php');

				$facebook = new Facebook(array(
				  'appId'  => $this->FB_APP_ID,
				  'secret' => $this->FB_SECRET,
				));
				
				// Recupero il FB_id
				$user = $facebook->getUser();
				if ($user) 
				{	
					try 
					{
						// Se settato l'id, recupero gli altri parametri
						$user_data = $facebook->api('/me?fields=id,name,picture,first_name,last_name,gender,email');
						
						$user_gender 			= substr($user_data['gender'],0,1);
						if ((strtoupper($user_gender) != 'M') && (strtoupper($user_gender) != 'F'))
						{
							$user_gender 	= '';
						}
						
						$user_elements = array(	'id' 			=> $user_data['id'],
												'nickname' 		=> $user_data['name'],
												'first_name' 	=> $user_data['first_name'],
												'last_name' 	=> $user_data['last_name'],
												'gender' 		=> $user_gender,
												'picture'		=> $user_data['picture']['data']['url'],
												'email' 		=> $user_data['email'],
												'type'			=> 'FB');
						
						$array_esito = array('esito'=>1,'data'=>$user_elements);
					} 	
					catch (FacebookApiException $e) 
					{
						error_log($e);
						$user = NULL;
					}
					
				}
				break;	
			}
			
			case 'GO': 
			{
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
				
				set_include_path("include/google-api/src/" . PATH_SEPARATOR . get_include_path());
				require_once('Google/Client.php');
				require_once('Google/Service.php');
				require_once('Google/Service/Plus.php');
				
				$client = new Google_Client();
				$client->setClientId($this->GO_CLIENT_ID);
				$client->setClientSecret($this->GO_CLIENT_SECRET);
				$client->setRedirectUri($this->GO_RED_URL);
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
												
					$array_esito = array('esito'=>1,'data'=>$user_elements);
					
				} else {
				  //header("HTTP/1.1 401 Bad token");
				}
				
				break;
			}
		}
		return $array_esito;
	}
}

?>