<?php
namespace Lapsic;

function MakeMosaic($ParametersList)
{
    //$ParametersList['source']   = $id;
    $elements 			= LapsicPhoto::GetMosaicList($ParametersList);
    
    $up     = 0;
    $down   = 0;
    $mosaic = array();
    foreach($elements as $retur)
    {
        $end = true;
        while($end) 
        {    
            $random = rand(1, 2);    
            
            if($random == '1')
            {
                if($up < 4)
                {                    
                    $mosaic['top'][]      = $retur['source_path'];
                    $up++;
                    $end = false;
                }         
            }
            elseif($random == '2')
            {
                if($down < 1)
                {
                    $mosaic['bottom']   = $retur['source_path'];
                    $down++;
                    $end = false;
                }
                
            }
        }
        //echo $random.'</br>';
    }
    //if(sizeof($mosaic) < 4 )
    //{ 
        
        if(!isset($mosaic['bottom'])){$mosaic['bottom'] = '#9FC8F3';} //sprintf('#%06X', mt_rand(0, 0xFFFFFF));}
        
        if(!isset($mosaic['top']) || sizeof($mosaic['top'])<3)
        {
            if(!isset($mosaic['top'][0])){$mosaic['top'][0] = '#6BB8F1';}
            if(!isset($mosaic['top'][1])){$mosaic['top'][1] = '#84B2D4';}
            if(!isset($mosaic['top'][2])){$mosaic['top'][2] = '#8EC3A3';}
            
        }
    //}
    return $mosaic;
}

//var_dump(MakeMosaic('2605'));

            /*
            for($i=0; $i<(3-(!isset($mosaic['top']))? 3 : sizeof($mosaic['top'])); $i++)
            {
                $mosaic['top'][] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            }
            */
?>