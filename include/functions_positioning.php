<?php 
/*function clean_string($stringa)
{
	$stringa = strtr($stringa, "àéèìòù", "aeeiou");
	$chain=preg_replace('/[^a-zA-Z0-9]+/i','-',$stringa); 
	return(strtolower($chain));
}*/

$GLOBALS['normalizeChars'] = array(
'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
'ú'=>'u', 'û'=>'u',	'ü'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f');

function clean_string($toClean) {
	$toClean = strtr($toClean, $GLOBALS['normalizeChars']);
	$toClean = strip_tags($toClean);
	$toClean = str_replace('&', '-e-', $toClean);
	$toClean = trim(preg_replace('/[^\w\d_ -]+/si', '-', $toClean));//remove all illegal chars
	//$toClean = str_replace(' ', '-', $toClean);
	$toClean = str_replace('--', '-', $toClean);
	$toClean = strtolower($toClean);
	return $toClean;
}

function trunk_string($toTrunk) {
	
	if(strlen($toTrunk) > 80){
	
		preg_match('/^.{80}[^\s]+|^.{0,80}$/s', $toTrunk, $match);
		$toTrunk = $match[0];
		
	}
	return $toTrunk;
}

function meta_description($string, $num, $tail='...')
{
        /** words into an array **/
		$string = strip_tags($string);
		
        $words = str_word_count($string, 2);
        /*** get the first $num words ***/
        $firstwords = array_slice( $words, 0, $num);
        /** return words in a string **/
        return  implode(' ', $firstwords).$tail;
}

function meta_keywords($string){
      $stopWords = array('per','di','da','al','il','la','i','gli','con','ai','alle','agli','allo','alla','e');
   
      $string = preg_replace('/ss+/i', '', $string);
      $string = trim($string); // trim the string
      $string = preg_replace('/[^a-zA-Z0-9 -]/', '', $string); // only take alphanumerical characters, but keep the spaces and dashes too…
      $string = strtolower($string); // make it lowercase
   
      preg_match_all('/\b.*?\b/i', $string, $matchWords);
      $matchWords = $matchWords[0];
      
      foreach ( $matchWords as $key=>$item ) {
          if ( $item == '' || in_array(strtolower($item), $stopWords) || strlen($item) <= 3 ) {
              unset($matchWords[$key]);
          }
      }   
      $wordCountArr = array();
      if ( is_array($matchWords) ) {
          foreach ( $matchWords as $key => $val ) {
              $val = strtolower($val);
              if ( isset($wordCountArr[$val]) ) {
                  $wordCountArr[$val]++;
              } else {
                  $wordCountArr[$val] = 1;
              }
          }
      }
      arsort($wordCountArr);
      $wordCountArr = array_slice($wordCountArr, 0, 10);
	  $str = implode(',', array_keys($wordCountArr));
      return $str;
}

?>