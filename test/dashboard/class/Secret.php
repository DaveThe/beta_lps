<?php  
namespace Dashboard;

class Secret {
	//const SECKEY = 'e9c7b658d78b0518583216b06d387d71';
	const SECKEY = 'i5ndn4ihkv4abcmem20lfe393975lop0';
	const ALG = 'tripledes';
	const MODE = 'ecb';
	private $module;
	private $key;
	
    public function __construct() {
    	$this->module = mcrypt_module_open(self::ALG, '', self::MODE, '');
    	$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($this->module), MCRYPT_RAND);
    	$this->key = substr(self::SECKEY,0, mcrypt_enc_get_key_size($this->module));
    	mcrypt_generic_init($this->module, $this->key, $iv);
    }
    
    public function encript($in){
    	$in = trim($in);
    	$encrypted_data = mcrypt_generic($this->module, $in);
    	return $encrypted_data;
    }
    
    public function decript($in){
    	$decrypted_data = mdecrypt_generic($this->module, $in);
    	return trim($decrypted_data);
    }
    
    public function destruct(){
    	mcrypt_generic_deinit($this->module);
    	mcrypt_module_close($this->module);
    }

}//Class
?>