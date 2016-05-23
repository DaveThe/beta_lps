<?php
if(!$plugins->plugin_status){ $resp_code = 635; }
    

    $plug_list = $plugins->GetPluginFromArea($area[PAGE_NAME]['id'], (isset($area[PAGE_NAME]['sub_area'][PAGE_SUB]))? $area[PAGE_NAME]['sub_area'][PAGE_SUB]['id'] : '');
 //$plug_list = $plugins->GetPluginFromArea($area[PAGE_NAME]['id']);
    //var_dump($plug_list); //exit ();
 if(sizeof($plug_list)>0)
 {
     for($i = 0; $i < sizeof($plug_list); $i++)
     {
        
        $plugins->GetElement($plug_list[$i]['id_plugin'], ENABLE);
        include_once('plugin/'.$plugins->name.'/index.php');
     }
 }
?>