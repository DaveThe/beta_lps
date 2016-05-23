<?php
 /**
 * SingleTone per gestire gli output di Debug
 * 
 *
 * @version   1.00
 * @since     2014-12-29
 */
Class SingDebug  { 

 ///Condition 1 - Presence of a static member variable
    private static $instance;

    ///Condition 2 - Locked down the constructor
    private function  __construct() { } //Prevent any oustide instantiation of this Class

    ///Condition 3 - Prevent any object or instance of that Class to be cloned
    private function  __clone() { } //Prevent any copy of this object

    ///Condition 4 - Have a single globally accessible static method
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new SingDebug();
        }
        return self::$instance;
    }

	function setVar($val)
	{ 
    	$_SESSION['var_dump'][] = $val; 
  	} 

	function getVar()
	{ 
		return $_SESSION['var_dump']; 
	} 

} 


?>