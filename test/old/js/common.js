// INIZIO DOCUMENT READY
$(document).ready(function() {
		

		
    $('.cont-slider').flexslider({
		animation: "slide",
		animationLoop: true,
		directionNav: true,
		controlNav: false,
		itemWidth: 0,
		itemMargin : 0,
		
 		controlsContainer: ".flex-container",
          start: function(slider) {
            $('.total-slides').text(slider.count);
						$('.current-slide').text(slider.currentSlide + 1);
          },
          after: function(slider) {
            $('.current-slide').text(slider.currentSlide + 1);
          }		
		});

	$('.box-login-txt').click(function(){
		$('.cont-login').slideToggle(800);
	});



});
// FINE DOCUMENT READY



$(window).load(function() {
		

	/*------- GESTIONE blocchi masory inzio ----------*/
		$('#container-blocchi').isotope({
				itemSelector:'.item',
				layoutMode:'masonry',
				transformsEnabled: false,
				animationEngine: 'jquery',
				masonry:{columnWidth:264, gutter:30}
		 });	
		 		 	
	/*------- GESTIONE blocchi masory fine ----------*/
	
	
	});
// FINE WINDOW LOAD	



/* GESTIONE APERTURA CHIUSURA VOCI  MENU*/
function tog_menu(id)
{
	if ($('#voce_menu_'+id).css('display')==('block'))
		{
			$('.cont-navigation-menu ul').slideUp(800);
			$('#voce_menu_'+id).slideUp(800);
			
		}
		else
		{
			$('.cont-navigation-menu ul').slideUp(800);
			$('#voce_menu_'+id).slideDown(800);
		}
}
/* GESTIONE APERTURA CHIUSURA VOCI  MENU*/
