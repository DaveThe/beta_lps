<?php
namespace Lapsic;
function printItems($elements)
{
    foreach ($elements as $el) {
        $dimensions = ElabImg('media/image/medium/',$el['source_path']);
        
        if($dimensions['error'] == '1'){continue;}
    ?>
        <div class="item" style="width: <?php echo ($dimensions['width']); ?>px;height: <?php echo ($dimensions['height']); ?>px;">
            <a class="dettaglio-photo fancybox.ajax" href="/photo.php?id=<?php echo ($el['id']); ?>" data-fancybox-type="ajax">
                <img class="img-zoom lazy" data-src="<?php echo $dimensions['name'] ?>" border="0" alt="" width="<?php echo ($dimensions['width']); ?>" height="<?php echo ($dimensions['height']); ?>" style="background-color: #<?php echo (isset($el['average_colour']) && $el['average_colour']!='' ? $el['average_colour'] : '6BB8F1'); ?>;" />                            
                <img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt="<?php echo ($el['id']); ?>"/>
            </a>
            <div class="box-date-hour" style="display: block;">
                <div class="date-item" id="counter_<?php echo ($el['id']); ?>" title="<?php echo (strtotime($el['time_left'])); ?>" now="<?php echo (time()); ?>" data-countdown="<?php echo ($el['time_left']); ?>">
                    112d:04h
                </div>
                <div class="time_container">
                    <div class="add-hour" id="24_<?php echo ($el['id']); ?>">
                        +24 h
                    </div>
                    <div class="add-hour" id="12_<?php echo ($el['id']); ?>">
                        +12 h
                    </div>
                    <div class="add-hour" id="6_<?php echo ($el['id']); ?>">
                        +6 h
                    </div>
                    <div class="add-hour" id="3_<?php echo ($el['id']); ?>">
                        +3 h
                    </div>
                </div>
            </div>
            <div class="name-profile-photo" style="display: block;">
                <a class="href_nn" style="color: white;" href="profile.php?id=<?php echo ($el['id_owner']); ?>">
                    <?php echo ((strlen($el['user'])>15)?substr($el['user'],0,15).'...':$el['user']); ?>
                </a>
                <a class="href_nn" style="color: white;" href="index.php?mode=rankuser">
                    <span>#<?php echo ($el['rank']); ?></span>
                </a>
            </div>
        </div>
    <?php }      
}


function printItemsUser($elements, $ParametersList)
{
    include_once('mosaic.php');
    foreach ($elements as $el) {
        $ParametersList['id'] = $el['id'];
        $mosaicon = (MakeMosaic($ParametersList));
    ?>

        <div class="box-altri-profili">      
            <div class="box-dettaglio-profilo fl_none">
              <div class="box-numeri-profilo">
                  <div class="numeri-profilo-left">
                    <p class="nome-profilo-dett"><a class=" nounderline" style="" href="profile.php?id=<?php echo ($el['id']); ?>"><?php echo ( (isset($el['nickname']) && $el['nickname'] != '') ? ((strlen($el['nickname'])>7)?substr($el['nickname'],0,7).'...':$el['nickname']) : ((strlen($el['username'])>7)?substr($el['username'],0,7).'...':$el['username']) ); ?></a></p>
                    <p class="time-profilo-dett"><a class="nounderline"  href="profile.php?id=<?php echo ($el['id']); ?>&filter=timing">Timing</a></p>
                    <p class="time-profilo-dett"><a class="nounderline"  href="profile.php?id=<?php echo ($el['id']); ?>&filter=timers">Timers</a></p>
                 </div> 
                 <div class="numeri-profilo-right">
                  <p class="codice-utente">
                      #<?php echo ($el['rank']); ?>
                  </p>
                    <p class="time-profilo-numeri"><a class="nounderline"  href="profile.php?id=<?php echo ($el['id']); ?>&filter=timing"><?php echo ($el['timing']); ?></a></p>
                    <p class="time-profilo-numeri"><a class="nounderline"  href="profile.php?id=<?php echo ($el['id']); ?>&filter=timers"><?php echo ($el['timers']); ?></a></p>
                 </div>
              </div>
              <div class="img-profilo-dettaglio">
                <a href="profile.php?id=<?php echo($el['id']); ?>" class="nounderline">
                    <img class="lazy" src="media/avatar/<?php echo ( ( (isset($el['img']) && $el['img'] != '') ? $el['img'] : 'avatar.png') ); ?>" alt=""/>
                </a>
             </div>
            </div>
            
            <div class="box-img-altri-profili">
                <?php $top = (preg_match("/#/", $mosaicon['top'][0])) ? $mosaicon['top'][0] : ElabImg('media/image/small/',$mosaicon['top'][0]); //echo $mosaicon['top'][0]; ?>
                <div class="box-img-top lazy" data-src="<?php echo($mosaicon['top'][0]); ?>" style="<?php echo (( preg_match("/#/", $mosaicon['top'][0])) ? 'background-color:'.$top : 'background-image: url( '.$top['name'].');'); ?>"></div>
                <?php $top2 = (preg_match("/#/", $mosaicon['top'][1]) ) ? $mosaicon['top'][1] : ElabImg('media/image/small/',$mosaicon['top'][1]); ?>
                <div class="box-img-top lazy" data-src="<?php echo($mosaicon['top'][1]); ?>" style="<?php echo ((preg_match("/#/", $mosaicon['top'][1]) ) ? 'background-color:'.$top2 : 'background-image: url( '.$top2['name'].');'); ?>"></div>
                <?php $top3 = (preg_match("/#/", $mosaicon['top'][2]) ) ? $mosaicon['top'][2] : ElabImg('media/image/small/',$mosaicon['top'][2]); ?>
                <div class="box-img-top lazy" data-src="<?php echo($mosaicon['top'][2]); ?>" style="<?php echo ((preg_match("/#/", $mosaicon['top'][2])) ? 'background-color:'.$top3 : 'background-image: url( '.$top3['name'].');'); ?>"></div>
                <?php $bottom = (preg_match("/#/", $mosaicon['bottom']) ) ? $mosaicon['bottom'] : ElabImg('media/image/small/large/',$mosaicon['bottom']); ?>
                <div class="box-img-bottom lazy" data-src="<?php echo($mosaicon['bottom']); ?>" style="<?php echo ((preg_match("/#/", $mosaicon['bottom'])) ? 'background-color:'.$bottom : 'background-image: url( '.$bottom['name'].');'); ?>"></div>
            </div>
        </div>
        
    <?php }      
}

?>