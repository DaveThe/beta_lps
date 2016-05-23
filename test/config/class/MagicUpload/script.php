<?php /* PLUGIN UPLOAD */ ?>        

<script type="text/javascript">
/*
function openImg(img) {
	$.fancybox({
		'href'						: img,
		'padding'					: 0,
		'showCloseButton'			: true,
		'overlayColor'				: '#222',
		'type'						: 'image',
		'scrolling'					: 'no'
	});
}*/
var preview_list = '';

</script>
        <script src="<?php echo('/config/class/MagicUpload/core/js/template.js'); ?>"></script>
        <script src="<?php echo('/config/class/MagicUpload/core/js/lang.js'); ?>"></script>
        <script src="<?php echo('/config/class/MagicUpload/core/js/uploads.js'); ?>"></script>
        <link href="<?php echo('/config/class/MagicUpload/core/css/upload.css'); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$(document).ready(function(){
    $(document).MagicUpload({
                              Anchor                : "panel-body", //classe di ancoraggio per recuperare l'id di upload
                              drop                  : true, //abilita funzione drag and drop
                              dropZone              : 'drop-zone', //id zona drag drop
                              uploadForm            : 'js-upload-form', //id form upload
                              inputfiles            : 'js-upload-files', //id input file
                              dropZoneCss           : 'upload-drop-zone', //classe css per la zona del drag and drop
                              dropZoneCss_drop      : 'upload-drop-zone drop', //stile grafico per quando si passa un file sopra alla zona dd
                              dropZoneId_finish     : 'js-upload-finished', //id sezione elenco file già caricati
                              error_shake           : true, //error shake
                              errorCss              : 'error', //css errore
                              successCss            : 'good', //css successo
                              lang                  : 'EN', // lingua messaggi
                        	  list                  : <?php echo ((PAGE_NAME != 'PROFILE_EDIT') ? 'true' : 'false'); ?>, // visualizzare lista file caricati
                              preview               : false, // visualizzare anteprima
                              previewImg            : '',  // immagine anteprima da visualizzare
                              multiUpload           : true,  //abilita l'upload di più immagini con un solo drag and drop
                              debug                 : true  //abilita i console log
                            });
});
</script>