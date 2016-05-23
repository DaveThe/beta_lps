<?php 
/*function clean_string($stringa)
{
	$stringa = strtr($stringa, "������", "aeeiou");
	$chain=preg_replace('/[^a-zA-Z0-9]+/i','-',$stringa); 
	return(strtolower($chain));
}*/

$GLOBALS['normalizeChars'] = array(
'�'=>'S', '�'=>'s', '�'=>'Dj','�'=>'Z', '�'=>'z', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A',
'�'=>'A', '�'=>'A', '�'=>'C', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'I', '�'=>'I', '�'=>'I',
'�'=>'I', '�'=>'N', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'U', '�'=>'U',
'�'=>'U', '�'=>'U', '�'=>'Y', '�'=>'B', '�'=>'Ss','�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a',
'�'=>'a', '�'=>'a', '�'=>'c', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'i', '�'=>'i', '�'=>'i',
'�'=>'i', '�'=>'o', '�'=>'n', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'u',
'�'=>'u', '�'=>'u',	'�'=>'u', '�'=>'y', '�'=>'y', '�'=>'b', '�'=>'y', '�'=>'f');

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
      $string = preg_replace('/[^a-zA-Z0-9 -]/', '', $string); // only take alphanumerical characters, but keep the spaces and dashes too�
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