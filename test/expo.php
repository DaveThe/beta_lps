<?php
namespace Lapsic;
/**
 * Pagina di Front-end del progetto Lapsic
 *
 *
 * @version   1.00
 * @since     2015-05-17
 * @company   http://addictify.it/
 */
include_once(dirname(__FILE__).'/config/config.php');

include_once('super.php');  
include_once('check_login.php');
include_once('item_list.php');


$ParametersList['pagination'] = true;
$ParametersList['elements_in_page'] = 20;
$mode = (isset($_GET['mode']) && $_GET['mode']) ? $_GET['mode'] : '';
$ParametersList['contest']  = 'summer';
$ParametersList['order']    = $mode;
$ParametersList['status']   = ENABLE;
$elements 			= LapsicPhoto::getContestElements($ParametersList);

?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" > 
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<title>Lapsic | Benvenuti</title>
<meta name="description" content="hype sensitive photography – which pics will stand the test of time?">
<?php include_once('include/resources.php'); ?>
<script type="text/javascript" src="js/home.js" defer></script>
<style type="text/css">
.header-int{ max-width:1394px;}
</style>
</head>

<body>
    <?php include('include/googanal.php'); ?>
        
    <div class="second-container">    
        
        <?php include ("include/header.php");?>
        
        <div class="banner-expo">
        </div>
        
        <div class="title-expo">
        	Contest #expo
        </div>
        <div class="descr-expo" style="text-align: left !important;">
        	Il contest <strong>#expo</strong> lanciato da <strong>Lapsic in Expo Milano 2015</strong> è un concorso con monte premi di <strong>euro duecento</strong> per la foto caricata su <strong>Lapsic</strong> (<strong>con</strong> almeno, fra i tanti “#”, l’<strong>#expo</strong>) che colleziona più tempo donato nella finestra temporale del contest stesso. <br />Caricare una foto con tale dicitura implicherà in maniera <strong>automatica</strong> la <strong>partecipazione</strong> al contest promosso da <strong>Lapsic</strong>. Il contest ha <strong>inizio</strong> in data <strong>10/10/15</strong> alle ore 10.30 per <strong>terminare</strong> in data <strong>31/10/15</strong> alle ore 23.59, orario di chiusura ufficiale di <strong>Expo2015</strong>. Tutte le immagini uplodate su Lapsic dai suoi utenti in tale fascia temporale ed aventi almeno <strong>"#expo"</strong> avranno <strong>30 giorni</strong> di tempo <strong>per ricevere tempo donato</strong> dagli utenti, il che significa che una foto caricata in data 10/10/15 partecipante al contest risulterà “votabile” sino al 10/11/15, così come una foto uplodata in data 31/10/15 risulterà votabile sino alla data 01/12/15. Terminato il contest, le foto pubblicate con  l’#expo e quindi partecipanti al concorso risulteranno nuovamente votabili da chiunque. Il team di Lapsic contatterà il vincitore del contest a mezzo mail (quella fornita al momento dell’iscrizione) per la fornitura degli estremi su cui effettuare il pagamento della vincita, di <strong>euro duecento</strong>. 
<br /><strong>In bocca al lupo!</strong>
<br /> Il team di Lapsic.

        </div>
    
        <div class="container-menu-e-blocchi">
            <div id="container-blocchi" class="iso-container">
                <?php if(sizeof($elements) > 0) {
                        echo printItems($elements);
                } ?>  
                			
    		
            </div> 
            <?php if(isset($_SESSION['lapsic_logged']) && $_SESSION['lapsic_logged']) { ?>  
            <div class="box-scroll-and-add">
                <a class="add-photo fancybox.ajax mfp-iframe" href="/add-photo.php" data-fancybox-type="ajax"><img src="images/add-image.png" width="52" alt=""/></a><br />
                <img src="images/scrolltop.png" width="52" id="scroll-top" alt=""/>
            </div>	   
            <?php } ?>
            <div id="pagination" style="display: none;">
                <?php echo ( ($_pag != $elements->getPages()->pageCount) ? '<a href="'. $_SERVER['PHP_SELF'] .'?pag='.($_pag+1).'&'.$querystring.'" class="next">next</a>' : ''); ?>
            </div>
        </div>
    </div>
    
    <?php include ("include/footer.php");?>
    
</body>
</html>
