<?php
    namespace Lapsic;

    $dati	= array();
    
    $exit 	= isset($_GET['exit']) && is_numeric(trim($_GET['exit']))		? $_GET['exit']		: NULL;
    
    if(isset($exit))
    {                
        session_unset();
        session_destroy();
    	$respok	=	'Logout avvenuto con successo';
        header('Location: index.php ');
        exit ();
    }
    else
    {
    
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_POST["act"]) && $_POST["act"]=='login') 
        {   
        	if (isset($_POST['utente']) && (trim($_POST['utente']) != '')) 
            {
        		$utente   = trim($_POST['utente']);
        	} else {
        		$errors[]  = "Digitare uno username<br/>";
        	}
        	
        	if (isset($_POST['password']) && (trim($_POST['password']) != '')) 
            {
        		$password = trim($_POST['password']);
        	} 
            else 
            {
        		$errors[]  = "Digitare una password<br/>";
        	}
        	
        	if( sizeof($errors) == 0 )
            {   
                $lapsic_user             = new LapsicUser($db);
                $data = $lapsic_user->Login($utente, $password);
                if( isset($data) && $data != NULL )
                {
                	$_SESSION['lapsic_login']			= true;
                    $_SESSION['lapsic_logged']          = true;
                	$_SESSION['lapsic_iduser']			= $data;
                	//$_SESSION['tipo']				= $dati['type_user'];			
                    //$_SESSION['lapsic_nickname']			= $dati['nickname'];
                	//$_SESSION['lapsic_username']			= $dati['username'];
                	//$_SESSION['prj_color']			= $dati['prj_color'];
                	//$_SESSION['avatar']  			= $dati['img'];
                	//$_SESSION['company']  			= $dati['company'];
                	    			
                	header('location: index.php ');
                	exit ();
                }
                else
                {
                	$errors[]	= 'Login errato';
                }
        	}
        }
        elseif(isset($_POST["act"]) && $_POST["act"]=='register') 
        {   
            $lapsic_user             = new LapsicUser($db);
            /*
            if(isset($_POST['password']) && trim($_POST['password'])!='' && preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $_POST['password']))
            {            
                $lapsic_user->password =  $_POST['password'];
            }
            else
            {
                $errors[] = "Devi inserire una password compresa tra gli 8 e i 20 caratteri, con una maiuscola e un numero";
            }
            */
                    
        	if(isset($_POST['password']) && trim($_POST['password'])!='' && preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $_POST['password']))
            {
        		//if(isset($_POST['conferma_password']) && $_POST['password']==$_POST['conferma_password']){
        			$lapsic_user->password =  $_POST['password'];
        		/*
                }
                else
                {
        			$errors['password2'] = "Le password non coincidono";
        		}*/
        	}
        	else 
            {
        		$errors['password'] = "Devi inserire una password compresa tra gli 8 e i 20 caratteri, con una maiuscola e un numero";
                $errors['password2'] = $errors['password'];
        	}
    
            if(isset($_POST['nickname']) && trim($_POST['nickname'])!='')
            {
                $lapsic_user->nickname 			=  $_POST['nickname'];
                $lapsic_user->username 			=  $_POST['nickname'];
            }
            else
            {
                $errors['nickname'] = "Devi inserire il tuo nickname";
            }
            
                    
        	if(isset($_POST['email']) && trim($_POST['email'])!='' && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            {
        		$lapsic_user->email 			=  $_POST['email'];
        	}
        	else
        	{	
        		$errors['email'] 					= "Devi inserire una Mail valida";
        	}
                
        	if(isset($_POST['informativa']) && trim($_POST['informativa'])!='')
            {
        		$lapsic_user->informativa		=  '1';
        	}
        	else
        	{	
        		$errors['informativa']			= "Devi accettare l'informativa";
        	}

            $captcha=NULL;

            if(isset($_POST['g-recaptcha-response']))
            {
                $captcha=$_POST['g-recaptcha-response'];
            }
            
            if(!$captcha)
            {
                $errors['recaptcha']	=	'Inserire il codice Captcha';
            }
            
            define("GOO_SECRET", "6Lc3LA4TAAAAAPDCEVSa0J4txok513y2vOMlnahP");
            
            $response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".GOO_SECRET."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']));
            
            if($response->success==false)
            {
                $errors['recaptcha']	= 'Codice di controllo (il codice inserito è errato, riprovare)<br>';
            }
            

            $lapsic_user->img                = 'avatar.png';
            $lapsic_user->gender             = '0';
            $lapsic_user->created_by         = '1';
            $lapsic_user->status             = '1';
            
            if(sizeof($errors)==0) 
            {	
                
    			$res = $lapsic_user->insert();
                
    			if($res) 
                {    			 
    				$resp_code 			= 100;
                    
                    $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $lapsic_user->id, ID_USER_LOG);                            
                    $ret		= $action->Insert();
    			} 
                else 
                {
    				$resp_code 			= 105;	
    			}
                
                if ($ret)
                {   
                    $element_hashtag           = new LapsicHashTag($db);
                    $element_hashtag->type_record = 'LapsicUser';
                    $element_hashtag->id_record     = $lapsic_user->id;
                    
                    $element_hashtag->tag_original = $lapsic_user->nickname;
                    $element_hashtag->tag_name = $lapsic_user->nickname;
                    $res = $element_hashtag->insert();
                    
        			if($res) {
        				$resp_code 			= 100;
                        
                        $action     = new LogAction($db, CREATE, __FUNCTION__, __CLASS__, basename(__FILE__), $element_hashtag->id, ID_USER_LOG, 'Inserimento hashtag: '.$element_hashtag->id);                            
                        $ret		= $action->Insert();
        			} else {
        				$resp_code 			= 105;	
        			}
                }
                
        		if($ret) 
                {
                    $_SESSION['lapsic_login']			= true;
                	$_SESSION['lapsic_iduser']			= $lapsic_user->id;
                    
        			//header('Location: index.php');
        			//exit ();
        		} 
                else 
                {
        			$resp_code 				= 635;
        		}
        	}
            
        }
    }
?>