<?php 
namespace Lapsic;
/**
 * La Class Common contiene le operazioni comuni utilizzate anche da altre Classi.
 * 
 *
 * @version   1.00
 * @since     2015-05-17
 * @author    Davide Tresoldi
 * @company   http://addictify.it/
 */ 
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Helper\PaginationControl;
use Zend\View\Resolver;    //necessary

class Common {
	
	/**
	 * Risorsa del datbase.
	 * @var mssql
	 */	
	 
	private $db 				= NULL;
	
	/**
	 * Costruttore della Class
	 *
	 * @param mssql $db Risorsa del database da utilizzare
	 *
	 */
	public function __construct($db) {
		$this->db = $db;
	}	
	    	    
    public static function random_color_part() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }
    
    public static function random_color() {
        return self::random_color_part() . self::random_color_part() . self::random_color_part();
    }
    
    // Function to get the client IP address
    public static function get_client_ip() 
    {
        $ipaddress = '';
        if ($_SERVER['HTTP_CLIENT_IP'])
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if($_SERVER['HTTP_X_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if($_SERVER['HTTP_X_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if($_SERVER['HTTP_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if($_SERVER['HTTP_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if($_SERVER['REMOTE_ADDR'])
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    
    public static function autoVer($url, $return = false)
    {
        $path = pathinfo($url);
        $ver = '__'.filemtime($_SERVER['DOCUMENT_ROOT'].$url).'.';
        //echo $path['dirname'].'/'.str_replace('.', $ver, $path['basename']);
        if($return)
        {
             return $path['dirname'].'/'.$path['filename'].$ver.$path['extension'];
        }
        else
        {
            echo $path['dirname'].'/'.$path['filename'].$ver.$path['extension'];//str_replace('.', $ver, $path['basename']);
        }
    }
}
?>