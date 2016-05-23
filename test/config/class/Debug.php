<?php
namespace Lapsic;
 /**
 * La Class Debug contiene i metodi per crittografare e decirare le chiavi di debug, visualizzare la finestra di Debug.
 * 
 *
 * @version   1.00
 * @since     2014-12-29
 */
 

class Debug
{
	/**
	 *
	 *	Variabili che vengono usate per la creazione della chiave
	 *
	**/
	
	private 		$encryption_key 	= 	NULL;
	private 		$string_key			= 	"Shufflesoft debug 2014";
	public 			$private_key		= 	NULL;
	public static	$debug_state		=	false;
	
	public function __construct() 
	{
		$this->encryption_key = date('d/m/y');
		$this->private_key = self::encrypt($this->string_key,$this->encryption_key);		
	}
	
	public function getKey()
	{
		return $this->private_key;
	}
	
	public static function encrypt($pure_string, $encryption_key) 
	{
    	$encrypted_string= hash('md5',$pure_string + $encryption_key);
    	return $encrypted_string;
	}

	public function check_Key($key)
	{
		$ret=false;
		if(strcmp($key,$this->private_key)==0)
		{

			$ret=true;
			self::$debug_state	=	true;
		}
		return $ret;
	}
	
	/*
	*FUNZIONE CHE MI VISUALIZZA O NASCONDE I RISULTATI PER IL DEBUG
	* $SHOW = BOOLEAN, FALSE NASCONDE TRUE MOSTRA
	* $NAME = NOME DELLA FUNZIONE CHE MOSTRA IL DEBUG
	* $VALORE = VALORI DA MOSTRARE
	*/
	public static function ShowDebug($nome_funzione, $valore, $class,$file=''){

		if(self::$debug_state){
			
			$info = debug_backtrace(); 
			$info2 = Log::stackTraceDebug($info);
            
			$single = SingDebug::getInstance();
			$single->setVar(array( 'Class' => $class, 'FOO' => $nome_funzione,'values' => $valore ,'file' =>$info2));

		}
		
	}	
	
	public static function EnableErrors(){
		if(self::$debug_state)
		{						
			 error_reporting(E_ALL);
			 ini_set("display_errors", 1);	
		}
	}
	
	public static function Debugger() {

        if(self::$debug_state)
        {
        	echo '
        	<script type="text/javascript">
        	$(document).ready(function(){
        	var stile = "top=10, left=10, width=600, height=500, status=no, menubar=no, toolbar=no";
        	 window.open("debugger.php","",stile); // will open new tab on document ready
        	});
        	</script>
        	';
        }
	}
    
    public function CheckDebug($debug_key)
    {
        if(PAGE_NAME != 'DEBUGGER')
    	{
    		if(isset($debug_key))
    		{
    			if($this->check_Key($debug_key))
    			{
    				$_SESSION['debug_key']	=	$debug_key;
    			}
    		}
    		else if (isset($_SESSION['debug_key']))
    		{
    			if(!$this->check_Key($_SESSION['debug_key']))
    			{
    				unset($_SESSION['debug_key']);
    			}
    		}
    	}
        
    }
    
    public static function var_dump2()
    {
        $trace = debug_backtrace();
        $rootPath = dirname(dirname(__FILE__));
        $file = str_replace($rootPath, '', $trace[0]['file']);
        $line = $trace[0]['line'];
        $var = $trace[0]['args'][0];
        $lineInfo = sprintf('<div><strong>%s</strong> (line <strong>%s</strong>)</div>', $file, $line);
        $debugInfo = sprintf('<pre>%s</pre>', print_r($var, true));
        print_r($lineInfo.$debugInfo);
    }		
}



?>