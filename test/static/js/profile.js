/* GESTIONE ALTEZZA PROFILI */		 
function AutoHeightProfili()
{
   var height_fascia_profilo = $('.cont-box-profili').height();
   $('.dettaglio-profilo-left').css('min-height', height_fascia_profilo +150 +'px');
}
/* FINE GESTIONE ALTEZZA PROFILI */	

$(document).ready(function(e) {
  
	/*------- GESTIONE blocchi masory inzio ----------*/
 var $grid = $('.cont-box-profili').isotope({
				itemSelector: modeClass, 
				layoutMode:'masonry',
				transformsEnabled: false,
				animationEngine: 'jquery',
				masonry:{columnWidth:modeMasonry, gutter:15}
		 });	
		 		 	
	/*------- GESTIONE blocchi masory fine ----------*/
    
    
    var instance = jQuery("img.lazy").Lazy({chainable: false});
        
    var ias = jQuery.ias({
      container:  '#cont-box-profili',
      item:       modeClass, 
      pagination: '#pagination',
      next:       '.next',
      delay: 200
    });
    
    // Add a loader image which is displayed during loading
    ias.extension(new IASSpinnerExtension());
        
    // Add a text when there are no more pages left to load
    //ias.extension(new IASNoneLeftExtension({ html: '<img src="images/end_content.png" style="position: absolute;bottom: 0;margin-left: 50%;margin-right: 50%;" />' })); 
    //ias.extension(new IASNoneLeftExtension({text: "--"}));
    
    ias.on('render', function(items) 
    {
      $(items).css({ opacity: 0 });
    });
    
    ias.on('rendered', function(items) 
    {
        
      $('#cont-box-profili').isotope( 'insert', items );
      
      $(items).css({ opacity: 1 });
      
        jQuery("img.lazy").lazy({
            bind: "event",
            delay: 400
        });
      update();
      AutoHeightProfili();
      
    });
    
    AutoHeightProfili();
    update();
});