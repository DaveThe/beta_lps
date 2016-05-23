$(document).ready(function() {

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
        
     	
});