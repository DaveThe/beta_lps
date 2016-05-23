$(document).ready(function() {
	   

	/*------- GESTIONE blocchi masory inzio ----------*/
    var $grid = $('#container-blocchi').isotope({
				itemSelector:'.item',
				layoutMode:'masonry',
				transformsEnabled: false,
				animationEngine: 'jquery',
				masonry:{columnWidth:200, gutter:15}
		 });	
		 		 	
	/*------- GESTIONE blocchi masory fine ----------*/
        
    	/****  GESTIONE SLIDER ORIZZONTALE   ****/	
        //$('.cont-slider').flexslider({
        $('#sliderhome').flexslider({
    		animation: "slide",
    		animationLoop: true,
    		directionNav: true,
    		controlNav: false,
    		itemWidth: 0,
    		itemMargin : 0,
            smoothHeight: true,
    		
     		controlsContainer: ".flex-container",
              start: function(slider) {
                $('.total-slides').text(slider.count);
    						$('.current-slide').text(slider.currentSlide + 1);
              },
              after: function(slider) {
                $('.current-slide').text(slider.currentSlide + 1);
              }		
    		});
    	/**** FINE  GESTIONE SLIDER ORIZZONTALE   ****/
        
        
	    /****  GESTIONE BOX LOGIN   ****/
        $('.box-login-home').click(function() {
            //$('#sliderhome').pause();
            var options = {};
            $('.content-form-login').toggle( 'blind', options, 500 ); //.slideToggle(500,"linear");
    
        });
		
	    /**** FINE GESTIONE BOX LOGIN   ****/
		
	/*		    
    function update()
    { //Europe/Rome
        //requestAnimationFrame(update);
        $('[data-countdown]').each(function() {
            var $this = $(this), finalDate = $(this).data('countdown');
            $this.countdown(finalDate, {elapse: true})
              .on('update.countdown', function(event) {
                    var format = '%H:%M:%S';
                    if(event.offset.days > 0) 
                    {
                        format = '%-d d%!d ' + format;
                    }
                    
                    if(event.offset.weeks > 0) 
                    {
                        format = '%-w w%!w ' + format;
                    }
                    
                    $(this).html(event.strftime(format));
                  })
              .on('finish.countdown', function(event) {
                    $(this).html('This photo has expired!');
                    //.parent().addClass('disabled')
                
              });
        });
    }
    */
    
    var instance = jQuery("img.lazy").Lazy({chainable: false});
        
    var ias = jQuery.ias({
      container:  '#container-blocchi',
      item:       '.item',
      pagination: '#pagination',
      next:       '.next',
      delay: 200
    });
    
    // Add a loader image which is displayed during loading
    ias.extension(new IASSpinnerExtension());
        
    // Add a text when there are no more pages left to load
    ias.extension(new IASNoneLeftExtension({ html: '<img src="images/end_content.png" style="position: absolute;bottom: 0;margin-left: 50%;margin-right: 50%;" />' })); 
    //({text: "You reached the end"}));
    
    ias.on('render', function(items) {
      $(items).css({ opacity: 0 });
    });
    
    ias.on('rendered', function(items) {
        
      $('#container-blocchi').isotope( 'insert', items );
      
      $(items).css({ opacity: 1 });
      
        jQuery("img.lazy").lazy({
            bind: "event",
            delay: 400
        });
      
        update();
    });
     
    update();   
});