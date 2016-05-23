<?php
namespace Lapsic;
include_once(dirname(dirname(__FILE__)).'/config/config.php');

include_once('super.php');  
$_test = ((isset($_GET['test']) && $_GET['test'] == 'true') ? true : false);
$buggy = $_test;
if($buggy)
{
    ini_set('display_startup_errors',1);
    ini_set('display_errors',1);
    error_reporting(-1);
}    

$user           = new $lapsic_user($db);
$photo          = new LapsicPhoto($db);
$hashtag        = new LapsicHashTag($db);
$ParametersList['text'] = $_text;//'dqpFNCwIiu';
//echo $_text;
if($buggy) echo '<br>';
$elements_tag 			= LapsicHashTag::SearchIndex($ParametersList);
if($buggy) echo '<br>';
//var_dump($elements_tag);
/*
foreach($elements_tag as  $el)
{
    echo $el.'<br>';
}*/
//echo '<br>--------------------------------------------------<br>';
//$results = /* Search results returned by querying search_index */;
$components = array();
if($elements_tag)
{
    if($buggy) echo 'ho trovato dei risultati - #: '.sizeof($elements_tag);
    if($buggy) echo '<br>------';
    if($buggy) echo '<br>'.print_r($elements_tag).'<br>';
    foreach($elements_tag as $result)
    {
        if($buggy) echo 'sto analizzando '.print_r($result);
        if($buggy) echo '<br>';
        $component = $result['component'];
        $componentId = $result['component_id'];
        //UpdateFreq($result['idtag']);
        // build a per-component array of component ids
        $components[$component][] = $componentId;//$components[$componentId];
        
        if($hashtag->GetElement($result['idtag']))
        {
            if($buggy) echo '<br>';        
            $counter = $hashtag->frequency;
            $hashtag->frequency = $counter+1;
            
            $res = $hashtag->update();
        
        	if($res)
            {        
                $action     = new LogAction($db, UPDATE, __FUNCTION__, __CLASS__, basename(__FILE__), $result['idtag'], ID_USER_LOG, 'Incremento frequenza richiesta hashtag #: '.$result['idtag']);                            
                $ret		= $action->Insert();
        		if(!$ret)
                {
                    echo 'errore in action';
                    if($buggy) echo '<br>';
                }
        	}    
            else
            {
                echo 'male male';
            }
        }
        else
        {
            echo 'no id';
        }
        
    }
}
else
{
    if($buggy) echo 'nessun risultato';
    if($buggy) echo '<br>';
}
    $ParametersList['text'] = '';
    $ParametersList['pagination'] = false;
    $ParametersList['elements_in_page'] = 10;
    
// functions to return detailed information for both blog &
// page components, weeding out results that are no longer valid
function LapsicPhoto($ids, $ParametersList) 
{
    //echo 'Attivo funzione LapsicPhoto';
    //echo '-<br>';
    //print_r($ids);
    //echo '-<br>';
    $ParametersList['search'] = $ids;
    $results = LapsicPhoto::GetElementsList($ParametersList);
    
    /**
     * CICLO E CREO LA LISTA COMPLETA
     */
     $container = array();
     foreach($results->toArray() as $el)
     {
        $dimensions = ElabImg('../media/image/medium/',$el['source_path']);
        //var_dump($dimensions);
      $container[] =  
      '
      <div class="item" style="width: '.$dimensions["width"].'px;height: '.$dimensions["height"].'px;margin-right: 15px;">
            <a target="_parent" class="dettaglio-photo fancybox.ajax" href="/photo.php?id='.$el["id"].'" data-fancybox-type="ajax">
                <img class="img-zoom lazy" src="'.str_replace('../','',$dimensions["name"]).'" border="0" alt="" width="'.$dimensions["width"].'" height="'.$dimensions["height"].'" style="background-color: #'.$el["average_colour"].';" />                            
                <img class="search-hover"  src="/images/zoom-img.png" width="73" height="83" alt="'.$el["id"].'"/>
            </a>
            <div class="box-date-hour" style="display: block;">
                <div class="date-item" id="counter_'.$el["id"].'" title="'.strtotime($el["time_left"]).'" now="'.(time()).'" data-countdown="'.$el["time_left"].'">
                    112d:04h
                </div>
                <div class="time_container">
                    <div class="add-hour" id="24_'.$el["id"].'">
                        +24 h
                    </div>
                    <div class="add-hour" id="12_'.$el["id"].'">
                        +12 h
                    </div>
                    <div class="add-hour" id="6_'.$el["id"].'">
                        +6 h
                    </div>
                    <div class="add-hour" id="3_'.$el["id"].'">
                        +3 h
                    </div>
                </div>
            </div>
            <div class="name-profile-photo" style="display: block;">
                <a class="href_nn" style="color: white;" href="profile.php?id='.$el["id_owner"].'">
                    '.clean_string(((strlen($el["user"])>15)?(substr($el["user"],0,15).'...'):($el["user"]))).'
                </a>
                <a class="href_nn" style="color: white;" href="index.php?mode=rankuser">
                    <span>#'.$el["rank"].'</span>
                </a>
            </div>
        </div>';
        
    }
    //var_dump($container);
    return array('type' => 'LapsicPhoto', 'count' => sizeof($results), 'data' => $container);//$results->toArray());
    
}

function lapsicUserS($ids, $ParametersList) 
{
    //echo 'Attivo funzione lapsicUserS';
    //echo '-<br>';
    include_once('mosaic.php');
    
    $ParametersList['search'] = $ids;
    $array_ret = array();
    $results = LapsicUser::GetElementsList($ParametersList);
    /**
     * CICLO E CREO LA LISTA COMPLETA
     */
     $container = array();
     foreach($results->toArray() as $el)
     {
        $ParametersList['id'] = $el['id']; //echo 'mosaic'; var_dump(MakeMosaic($ParametersList));
        $mosaicon = (MakeMosaic($ParametersList));
                $top = (preg_match("/#/", $mosaicon['top'][0])) ? $mosaicon['top'][0] : ElabImg('/media/image/small/',$mosaicon['top'][0]);
                $top2 = (preg_match("/#/", $mosaicon['top'][1]) ) ? $mosaicon['top'][1] : ElabImg('/media/image/small/',$mosaicon['top'][1]);
                $top3 = (preg_match("/#/", $mosaicon['top'][2]) ) ? $mosaicon['top'][2] : ElabImg('/media/image/small/',$mosaicon['top'][2]);
                $bottom = (preg_match("/#/", $mosaicon['bottom']) ) ? $mosaicon['bottom'] : ElabImg('/media/image/small/large/',$mosaicon['bottom']);
                
      $container[] =        
      '
        <div class="box-altri-profili" style="margin-right: 15px;">      
            <div class="box-dettaglio-profilo fl_none">
              <div class="box-numeri-profilo">
                  <div class="numeri-profilo-left">
                    <p class="nome-profilo-dett white"><a class=" nounderline" style="" href="profile.php?id='.$el['id'].'">'.( (isset($el['nickname']) && $el['nickname'] != '') ? ((strlen($el['nickname'])>7)?substr($el['nickname'],0,7).'...':$el['nickname']) : ((strlen($el['username'])>7)?substr($el['username'],0,7).'...':$el['username'])).'</a></p>
                    <p class="time-profilo-dett white"><a class="nounderline"  href="profile.php?id='.$el['id'].'&filter=timing">Timing</a></p>
                    <p class="time-profilo-dett white"><a class="nounderline"  href="profile.php?id='.$el['id'].'&filter=timers">Timers</a></p>
                 </div> 
                 <div class="numeri-profilo-right">
                  <p class="codice-utente white">
                      #'.$el['rank'].'
                  </p>
                    <p class="time-profilo-numeri white"><a class="nounderline"  href="profile.php?id='.$el['id'].'&filter=timing">'.$el['timing'].'</a></p>
                    <p class="time-profilo-numeri white"><a class="nounderline"  href="profile.php?id='.$el['id'].'&filter=timers">'.$el['timers'].'</a></p>
                 </div>
              </div>
              <div class="img-profilo-dettaglio">
                <a href="profile.php?id='.$el['id'].'" class="nounderline">
                    <img class="lazy" src="media/avatar/'.( ( (isset($el['img']) && $el['img'] != '') ? $el['img'] : 'avatar.png') ).'" alt=""/>
                </a>
             </div>
            </div>
            
            <div class="box-img-altri-profili">
                <div class="box-img-top lazy" data-src="'.($mosaicon['top'][0]).'" style="'.(( preg_match("/#/", $mosaicon['top'][0])) ? 'background-color:'.$top : 'background-image: url( '.$top['name'].');').'"></div>
                
                <div class="box-img-top lazy" data-src="'.($mosaicon['top'][1]).'" style="'.((preg_match("/#/", $mosaicon['top'][1]) ) ? 'background-color:'.$top2 : 'background-image: url( '.$top2['name'].');').'"></div>
                
                <div class="box-img-top lazy" data-src="'.($mosaicon['top'][2]).'" style="'.((preg_match("/#/", $mosaicon['top'][2])) ? 'background-color:'.$top3 : 'background-image: url( '.$top3['name'].');').'"></div>
                
                <div class="box-img-bottom lazy" data-src="'.($mosaicon['bottom']).'" style="'.((preg_match("/#/", $mosaicon['bottom'])) ? 'background-color:'.$bottom : 'background-image: url( '.$bottom['name'].');').'"></div>
            </div>
        </div>';
      
      
      /*
     '<div class="box-altri-profili">      
                        <div class="box-dettaglio-profilo fl_none">
                          <div class="box-numeri-profilo">
                              <div class="numeri-profilo-left">
                                <p class="nome-profilo-dett"><a class=" nounderline" style="" href="profile.php?id='.$el['id'].'">'.( (isset($el['nickname']) && $el['nickname'] != '') ? $el['nickname'] : $el['username'] ).'</a></p>
                                <p class="time-profilo-dett">Timing</p>
                                <p class="time-profilo-dett">Timers</p>
                             </div> 
                             <div class="numeri-profilo-right">
                              <p class="codice-utente">
                                  #'.$el['rank'].'
                              </p>
                                <p class="time-profilo-numeri">'.$el['timing'].'</p>
                                <p class="time-profilo-numeri">'.$el['timers'].'</p>
                             </div>
                          </div>
                          <div class="img-profilo-dettaglio">
                            <img class="lazy" src="media/avatar/'.( ( (isset($el['img']) && $el['img'] != '') ? $el['img'] : 'avatar.png') ).'" alt=""/>
                         </div>
                        </div>
                        
                        <div class="box-img-altri-profili">
                        	<div class="box-img-top lazy" style="background-image: url(images/slider/001.jpg);">
                          </div>
                        	<div class="box-img-top lazy" style="background-image: url(images/slider/002.jpg);">
                          </div>
                        	<div class="box-img-top lazy" style="background-image: url(images/slider/003.jpg);">
                          </div>
                          <div class="box-img-bottom lazy" style="background-image: url(images/slider/004.jpg);">
                          </div>
                        </div>
                    </div>';*/
    }
    //var_dump($container);
    
    return array('type' => 'LapsicUser', 'count' => sizeof($results), 'data' => $container);//$results->toArray());
    /*
    return mysqli_query('
        SELECT id, title, image
        FROM page
        WHERE id IN ('. implode( ',', $ids ) .')
    ');
    */
}

// pass the per-component grouped ids to the callback functions
// fill $verified with the actual verified search results
$verified = array();
$undefined = 0;
if(sizeof($components))
{
    foreach($components as $component => $ids) 
    {   
        if($buggy) echo '<br>analizzo la funzione: -'.$component.'-<br>';
        if($component == 'LapsicPhoto')
        {
            if($buggy) echo '<br>sto chiamando la funzione: -'.$component.'-<br>';
            if($buggy) echo '<br>passo i parametri: -';
            if($buggy) print_r($ids);
            if($buggy) echo '-<br>';
            $componentResults[] = LapsicPhoto($ids, $ParametersList);
        }
        elseif($component == 'LapsicUser')
        {
            if($buggy) echo '<br>sto chiamando la funzione: -'.$component.'-<br>';
            if($buggy) echo '<br>passo i parametri: -';
            if($buggy) print_r($ids);
            if($buggy) echo '-<br>';
            $componentResults[] = lapsicUserS($ids, $ParametersList);        
        }
        else
        {
            $undefined++;
            $componentResults[] = array('type' => 'undefined', 'count' => $undefined, 'data' => null);
        }
        if(is_array($componentResults) )
        {
            if($buggy) 
            {
                echo 'merge degli array';
                echo '<br>';
                echo 'verified';    
                echo '<br>';
                var_dump($verified);            
                echo '<br>';
                echo 'componentResults';    
                echo '<br>';
                var_dump($componentResults);            
                echo '<br>';
                //$componentResults = call_user_func($component, $ids);
                //$verified = array_merge($verified, $componentResults);
            }
            $verified = $componentResults;
        }
    }
}
else
{    
    if($buggy) echo '<br>';
    if($buggy) echo 'nessun risultato';
    if($buggy) echo '<br>';    
}

if($buggy) echo '<br>--------------------------------------------------<br>';
if($buggy) echo 'risultati: ';    
if($buggy) echo '<br>';
echo json_encode(array('esito'=>( (sizeof($verified)>0 ) ? 1 : 0),'data'=>$verified) );
//var_dump($verified);
?>