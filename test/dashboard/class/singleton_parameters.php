<?php
 /**
 * SingleTone per gestire gli output di Debug
 * 
 *
 * @version   1.00
 * @since     2014-12-29
 */
class SingApi  { 

 ///Condition 1 - Presence of a static member variable
    private static $instance;
    private $params = Array();
    
    ///Condition 2 - Locked down the constructor
    private function  __construct() { } //Prevent any oustide instantiation of this Class

    ///Condition 3 - Prevent any object or instance of that Class to be cloned
    private function  __clone() { } //Prevent any copy of this object

    ///Condition 4 - Have a single globally accessible static method
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new SingApi();
        }
        return self::$instance;
    }
    
    
    /**
    * @brief Lookup request params
    * @param string $name Name of the argument to lookup
    * @param mixed $default Default value to return if argument is missing
    * @returns The value from the GET/POST/PUT/DELETE value, or $default if not set
    */
    public function get($name, $default = null) {
        if (isset($this->params[$name])) {
          return $this->params[$name];
        } else {
          return $default;
        }
    }
    
    private function _parseParams() {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "PUT" || $method == "DELETE" || $method == "PATCH") {
            parse_str(file_get_contents('php://input'), $this->params);
            $GLOBALS["_{$method}"] = $this->params;
            // Add these request vars into _REQUEST, mimicing default behavior, PUT/DELETE will override existing COOKIE/GET vars
            $_REQUEST = $this->params + $_REQUEST;
        } else if ($method == "GET") {
            $this->params = $_GET;
        } else if ($method == "POST") {
            $this->params = $_POST;
        }
    }

	function setPost()
	{ 
        $this->_parseParams();
    	$_SESSION['var_post'] = $this->params;  
  	} 

	function getPost()
	{ 
		return $_SESSION['var_post']; 
	} 

	function setMethd($val)
	{ 
    	$_SESSION['method'] = $val; 
  	} 

	function getMethod()
	{ 
		return $_SESSION['method']; 
	} 
} 


?>