<?php
namespace Lapsic;
/**
 * Classe per la gestione dei social Login
 * 
 *
 * @author		Andrea Tiraboschi	
 * @version		1.00
 * @since		2015-07-28
 */
 
class Social 
{
	/**
	 * App id facebook
	 * @var string
	 */
	public static $fb_app_id = array('DEV'=>'698255393636113','PROD'=>'698255393636113');
	 
	/**
	 * Secret Key facebook
	 * @var string
	 */
	 public static $fb_secret_key = array('DEV'=>'43e8e82fc4a2fd818ec30adb0c9430a2','PROD'=>'43e8e82fc4a2fd818ec30adb0c9430a2');

	/**
	 * App id google
	 * @var string
	 */
	 public static $goo_app_id = array('DEV'=>'1013796245322-4nva16d5cmnm8qmavvqsvmokbg6ki17d.apps.googleusercontent.com','PROD'=>'1013796245322-4nva16d5cmnm8qmavvqsvmokbg6ki17d.apps.googleusercontent.com');
	 
	/**
	 * Secret Key google
	 * @var string
	 */
	 public static $goo_secret_key = array('DEV'=>'sRe3UBaNsQfD-D-HPyFNO9x2','PROD'=>'sRe3UBaNsQfD-D-HPyFNO9x2');
	 
	/**
	 * Informazioni dell'utente
	 * @var array
	 */
	 public $user_info = NULL;
	 
	/**
	 * Variabile che contiene il valore di sessione per il login
	 * @var STATE_CODE
	 */
	private $STATE_CODE = NULL; 
	 
	/**
	 * Variabile contenente i riferimenti al database
	 * @var dbObject
	 */
	private $db;
	
	private static $instance;
	
	
	/* Costruttore;
	$db : connessione al database aperta esternamente all'istanza della classe
	*/
	public function __construct() {
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
	
	 public static function getInstance()
	  {
		if ( is_null( self::$instance ) )
		{
		  self::$instance = new self();
		}
		return self::$instance;
	  }
	
	/**
	 * Restituisce il codice di sessione per il login
	 *
	 *
	 * @return  STATE_CODE
	 *
	 * @author		Andrea Tiraboschi	
	 * @version		1.00
	 * @since		2015-08-31
	 */
	
	public function getState()
	{
		return $this->STATE_CODE ;
	}
	
	/**
	 * Restituisce il codice js per il social
	 *
	 * @param  string $type il tipo di social utilizzato (FB => Facebook, GO => Google) 
	 * @return  echo codice javascript del social utilizzato
	 *
	 * @author		Andrea Tiraboschi	
	 * @version		1.00
	 * @since		2015-08-31
	 */	
	public function generaJS($type = NULL, $state)
	{
		if(isset($type))
		{
			switch($type)
			{
				case 'FB':
				{
					echo('<script type="text/javascript">
						  window.fbAsyncInit = function() {
							FB.init({
							  appId      : "'.(DEV_MODE?self::$fb_app_id['DEV']:self::$fb_app_id['PROD']).'",
							  xfbml      : true,
							  version    : "v2.3",
							  cookie	 : true
							});
						  };
						
						  (function(d, s, id){
							 var js, fjs = d.getElementsByTagName(s)[0];
							 if (d.getElementById(id)) {return;}
							 js = d.createElement(s); js.id = id;
							 js.src = "//connect.facebook.net/en_US/sdk.js";
							 fjs.parentNode.insertBefore(js, fjs);
						   }(document, \'script\', \'facebook-jssdk\'));
						   
						 	function FBLogin() {
								FB.login(function(response) {
									if (response.authResponse) {
										FB.api(\'/me\', function(response) {
											$.ajax({
											  method: "POST",
											  url: "/config/social/login_social.php",
											  dataType: "json",
											  data: {state: "'.$state.'", t: "FB", code: ""}
											})
											  .done(function( obj ) {
											     console.log("ssdas");
												  //console.log(dati.esito);
												//obj = JSON.parse(dati);
												console.log(obj);
												switch(obj.esito)
												{
													case 0 :
													location.href="index.php"; 
													break;
													case 1: 
													location.href="index.php"; 
													break;	
													case 2: 
													location.href="index.php?l=104"; 
													break;	
													case 3: 
													location.href="abbina_account.php"; 
													break;	
													case 4: 
													location.href="index.php"; 
													break;		
												}
											  })                                                                                          
                                              .always(function() {
											     console.log("always");
                                                location.href="index.php"; 
                                              });
							 
										});
									}
								},{scope: "email"});
							}
							 
							function checkLoginState() {
								FB.getLoginStatus(function(response) {
								  statusChangeCallback(response);
								});
							  }
							  function shareFB(ref,txt,title,img){
								var share = {
									method: \'stream.share\',
									u: ref
								};
								FB.ui(share, function(response) { 
									//console.log(response); 
								});
                              }
						</script>');
					break;
				}
				case 'GO':
				{
					echo("<script src=\"https://apis.google.com/js/api:client.js\"></script>
						  <script>
						  var googleUser = {};
						  var startApp = function() {
							gapi.load('auth2', function(){
							  // Retrieve the singleton for the GoogleAuth library and set up the client.
							  auth2 = gapi.auth2.init({
								client_id: '".(DEV_MODE?self::$goo_app_id['DEV']:self::$goo_app_id['PROD'])."',
								cookiepolicy: 'single_host_origin',
								// Request scopes in addition to 'profile' and 'email'
								//scope: 'additional_scope'
							  });
							  attachSignin(document.getElementById('customBtn'));
							});
						  };
						
						  function attachSignin(element) {
							auth2.attachClickHandler(element, {},
								function(googleUser) {
								  auth2.grantOfflineAccess({'redirect_uri': 'postmessage'}).then(signInCallback);
								}, function(error) {
								  alert(JSON.stringify(error, undefined, 2));
								});
						  }
						  </script>
						  <script>
							function signInCallback(authResult) {
							  if (authResult['code']) {
								$.ajax({
								  method: 'POST',
								  url: '/config/social/login_social.php',
								  dataType: 'json',
								  data: {state: '".$state."', t: 'GO', code: authResult['code']}
								})
								  .done(function( obj ) {
									  //obj = JSON.parse(dati);
											switch(obj.esito)
												{
													case 0 :
													location.href='index.php'; 
													break;
													case 1: 
													location.href='index.php'; 
													break;	
													case 2: 
													location.href='index.php?l=104'; 
													break;	
													case 3: 
													location.href='abbina_account.php'; 
													break;	
													case 4: 
													location.href='index.php'; 
													break;	
												
												}
								  });
							  } else {
								// There was an error.
							  }
							}
							startApp();
							</script>");
					break;
				}
			}
		}
	}
	/**
	 * Restituisce il bottone per il social login
	 *
	 * @param  string $type il tipo di social utilizzato (FB => Facebook, GO => Google) 
	 * @return  echo codice bottone
	 *
	 * @author		Andrea Tiraboschi	
	 * @version		1.00
	 * @since		2015-08-31
	 */		
	public function generaBottone($type, $template)
	{
		if(isset($type))
		{
			switch($type)
			{
				case 'FB':
				{
					echo('<a href="javascript:void(0);" onClick="FBLogin();">'.$template.'</a>');
					break;
				}
				case 'GO':
				{
					echo('<a href="javascript:void(0);" id="customBtn">'.$template.'</a>');
					break;
				}
			}
		}
	}
	/**
	 * Restituisce il codice di sessione per il login
	 *
	 * @param  string $type il tipo di social utilizzato (FB => Facebook, GO => Google) 
	 * @return  Array esito richiesta di login
	 *
	 * @author		Andrea Tiraboschi	
	 * @version		1.00
	 * @since		2015-08-31
	 */	
	public function login($type)
	{
		$array_esito = array('esito' => 0, 'data' => ''); 
		
		if(isset($type))
		{
			switch($type)
			{
				case 'FB': 
				{
					require_once dirname(__DIR__) . '/script/Facebook/autoload.php';
					
					$fb = new \Facebook\Facebook([
					  'app_id' => (DEV_MODE?self::$fb_app_id['DEV']:self::$fb_app_id['PROD']),
					  'app_secret' => (DEV_MODE?self::$fb_secret_key['DEV']:self::$fb_secret_key['PROD']),
					  'default_graph_version' => 'v2.4',
					  ]);
					
					$helper = $fb->getJavaScriptHelper();
					
					try {
					  $accessToken = $helper->getAccessToken();
					} catch(\Facebook\Exceptions\FacebookResponseException $e) {
					  echo 'Graph returned an error: ' . $e->getMessage();
					  exit;
					} catch(\Facebook\Exceptions\FacebookSDKException $e) {
					  echo 'Facebook SDK returned an error: ' . $e->getMessage();
					  exit;
					}
					
					if (isset($accessToken)) {
						$fb->setDefaultAccessToken($accessToken);
						try {
						  $response = $fb->get('/me?fields=id,name,picture,first_name,last_name,gender,email');
						  $userNode = $response->getGraphUser();
 
						} catch(\Facebook\Exceptions\FacebookResponseException $e) {
						  echo 'Graph returned an error: ' . $e->getMessage();
						  exit;
						} catch(\Facebook\Exceptions\FacebookSDKException $e) {
						  echo 'Facebook SDK returned an error: ' . $e->getMessage();
						  exit;
						}
						
						$user_id 				= $userNode['id'];
						$user_name 				= filter_var($userNode['name'], FILTER_SANITIZE_SPECIAL_CHARS);
						$user_gender 			= substr($userNode['gender'],0,1);
						
						if ((strtoupper($user_gender) != 'M') && (strtoupper($user_gender) != 'F'))
						{
							$user_gender 	= '';
						}
						$profile_image_url 		= filter_var($userNode['picture']['url'], FILTER_VALIDATE_URL);
						$given_name				= filter_var($userNode['first_name'], FILTER_SANITIZE_SPECIAL_CHARS);
						$family_name			= filter_var($userNode['last_name'], FILTER_SANITIZE_SPECIAL_CHARS);
						$user_email 			= filter_var($userNode['email'], FILTER_VALIDATE_EMAIL);
						$user_elements = array(		'id' 			=> $user_id ,
													'nickname' 		=> $user_name,
													'first_name' 	=> $given_name,
													'last_name' 	=> $family_name,
													'gender' 		=> strtoupper($user_gender),
													'picture'		=> $profile_image_url ,
													'email' 		=> $user_email,
													'type'			=> 'FB');
													
						$array_esito = array('esito'=>1,'data'=>$user_elements);
						$_SESSION['user_detail'] = $user_elements;
					}
					break;	
				}
				
				case 'GO': 
				{
				
				set_include_path("script/" . PATH_SEPARATOR . get_include_path());
				require_once('Google/Client.php');
				require_once('Google/Service.php');
				require_once('Google/Service/Plus.php');
				
				$client = new \Google_Client();
				$client->setClientId((DEV_MODE?self::$goo_app_id['DEV']:self::$goo_app_id['PROD']));
				$client->setClientSecret((DEV_MODE?self::$goo_secret_key['DEV']:self::$goo_secret_key['PROD']));
				$client->setRedirectUri('postmessage');
				$client->addScope("https://www.googleapis.com/auth/plus.login");
				$client->addScope("email");
				
			
				/*******************************************************
					Salva il token di autenticazione passato dal login 
				********************************************************/
				
					if (isset($_POST['code'])) {
						$client->authenticate($_POST['code']);
						$_SESSION['access_token'] = $client->getAccessToken();
						unset($_SESSION['logout']);
						if (isset($_SESSION['access_token']))
						{
							
						}
					}
					
				/************************************************
				  Se esiste un token
				 ************************************************/
				 
				if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
					
					// Recupera le informazioni dell'utente	
					$client->setAccessToken($_SESSION['access_token']);
					$PlusService 	= new \Google_Service_Plus($client);
					$me 			= new \Google_Service_Plus_Person();
					$me 			= $PlusService->people->get('me');
				  
				  	$user_email = '';
					$PlusPersonEMails = new \Google_Service_Plus_PersonEmails();
					$PlusPersonEMails = $me->getEmails();
					
					foreach($PlusPersonEMails as $em) {
						if($em->type == "account") {
							$user_email = $em->value;
						}
					}
				  
					$PlusPersonName 		= new \Google_Service_Plus_PersonName();
					$PlusPersonName 		= $me->getName();
					$PlusPersonImage 		= new \Google_Service_Plus_PersonImage();
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
					$ImgResized				= $parsed_url['scheme'] . '://' . $parsed_url["host"]  . $parsed_url["path"] . '?sz=300';//'?sz=25';
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
					$_SESSION['user_detail'] = $user_elements;
					
				} else {
				  $array_esito = array('esito' => 0, 'data' => 'LOGIN NON AUTORIZZATO');
				}
					
					break;
				}
			}
			//Recuperati dati utente controllo che non sia già registrato.
			if(isset($user_data['data']['id']) && trim($user_data['data']['id'])!='')
			{
				//da creare una funzione che controlla se esiste l'id del social
				if(checkSocialId($db,$user_data['data']['id']))
				{
					//Utente già presente nel db, lo loggo
					$id_user = loginFromSocial($db,$user_data['data']['id']);
					$array_esito = array('esito'=>2,'data'=>$user_elements); 
					$_SESSION['user_id'] = $id_user;
				}
			}
			else if(isset($user_data['data']['email']) && trim($user_data['data']['email'])!='')
			{
				//da creare una funzione che controlla se esiste l'email
				if(checkEmail($db,$user_data['data']['email']))
				{
					//Mail utente già presente lo mando alla pagina di abbina account	
					$array_esito = array('esito'=>3,'data'=>$user_elements);
					$_SESSION['user_detail'] = $user_elements; 
				}
			}	
		}
		else
		{
			$array_esito = array('esito' => 0, 'data' => 'ERRORE TYPE SOCIAL'); 
		}
		return $array_esito;
	}

}

?>