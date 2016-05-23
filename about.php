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
$lang 			= isset($_GET["lang"]) ? trim($_GET["lang"]) : '';
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
        
        <div class="title-expo">
        	About us 
        </div>
        <div class="general-txt">
            <?php if($lang == 'eng') {?>
            <strong>Lapsic</strong> is a free platform for <strong>sharing</strong> photos and media content, where you can <strong>express a valuation</strong>  of the content, <strong>donating</strong> it the most <strong>precious</strong> thing there is: <strong>time</strong>.<br /> Lapsic community is  young, fresh, dynamic, constantly moving and changing. We want it to remain a place of sincere sharing and <strong>honest “testing”</strong> of photos and videos, help us to grow and improve yourself.<br /> Discover how valuable your pictures are, upload them on <strong>Lapsic</strong> and wait other users to evaluate your photos and your profile by donating time, <strong>is simple</strong>, fast, fun. The most <strong>time</strong> people <strong>donate</strong> to your pictures, the most <strong>beautiful</strong> they are. <br /> <strong>Join us!</strong>
            <?php }else{ ?>
        	<strong>Lapsic</strong> è una piattaforma di <strong>condivisione</strong> di fotografie e contenuti mediatici gratuita, dove l’utente può esprimere un <strong>grado di gradimento</strong> di un contenuto <strong>donando</strong> quanto di più <strong>prezioso</strong> esista, il <strong>tempo</strong>.<br /> Lapsic è una community giovane, fresca, dinamica, in continuo movimento e cambiamento. Vogliamo rimanga un luogo di condivisione sincera e di <strong>“messa alla prova”</strong> onesta di foto e video, aiutaci a crescere e far crescere te stesso. <br /> Scopri quanto valgono le tue foto caricandole su <strong>Lapsic</strong> ed attendi che altri utenti valutino le tue immagini ed il tuo profilo <strong>donando tempo</strong>, è semplice, veloce, <strong>divertente</strong>. <br /> <strong>Let’s join us!</strong>
            <?php } ?>
        <span><br /><br />(<a class="nounderline" href="/about.php<?php echo(($lang == 'eng')?'':'?lang=eng');?>"><?php echo(($lang == 'eng')?' Versione italiana':'English version');?></a>)</span>
        </div>
        
    </div>
    
    <?php include ("include/footer.php");?>
    
</body>
</html>
