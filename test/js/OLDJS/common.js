
     
 /*
 *  GESTIONE COUNTDOWN
 */
 	    
function update()
{ 
    
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
  
 /*
 *  FINE GESTIONE COUNTDOWN
 */

// INIZIO DOCUMENT READY
$(document).ready(function() {
			
    /****  GESTIONE FANCYBOX   ****/
	//console.log($(window).width());
	//console.log($(window).height());
	$(".add-photo, .box-cerca, .dettaglio-photo, .register").fancybox({
		autoSize    :  false,
		padding     : '1',
		margin      : '2',
		autoScale   : false,
		width       : '100%',
		height      : '100%',
		type        : 'iframe',
		closeBtn    : false,
        scrolling   : 'no',
		iframe : {
		   scrolling : 'no'
		},
        afterClose: function(){
            if(this.href == "/register.php"){ parent.location.reload(true);  }
            //console.log(this.href); // == "/register.php")
        } 
                      
	 });
    
    
    function myAlert(text)
    {
        $.fancybox({
            'autoScale': true,
            'transitionIn': 'elastic',
            'transitionOut': 'elastic',
            'speedIn': 500,
            'speedOut': 300,
            'autoDimensions': true,
            'centerOnScroll': true,
            'content': '<html><head><link rel="stylesheet" type="text/css" href="css/style.css"></head><body><div class="descr-txt" style="background-color: white;padding: 30px;border-radius: 10px;">'+text+'</div></body></html>'
        });
    }
    
    /**** FINE GESTIONE FANCYBOX   ****/
	/* gestione scroll top */
   $('#scroll-top').click(function(){
    	$('html, body').animate({scrollTop:$('.second-container').position().top}, 1000);
    
    });
	/* gestione scroll top */	
    	 
    /* gestione hide and show all'hover blocchi*/
    $("body").on("mouseover mouseout", "div", function(e){
    
        $('.item').hover(function() {
            $(this).find(".img-zoom").addClass('transition');
        			$(this).find(".search-hover").show();
        			$(this).find(".box-date-hour").show();
        			$(this).find(".name-profile-photo").show();
        			
        
        }, function() {
            $(this).find(".img-zoom").removeClass('transition');
        			$(this).find(".search-hover").hide();
        			$(this).find(".box-date-hour").show();//.hide();
        			$(this).find(".name-profile-photo").show();//.hide();
        			$('.search-hover').animate({rotate: '0deg', scale: '1'}, 400);
        });
    });
    /* gestione hide and show all'hover blocchi*/
		
	/* click su + ore, rotazione img zoom a scomparsa*/
    $('.add-hour, .esagono-abs').click(function(){
	   $('.search-hover').animate({rotate: '360deg', scale: '0'}, 400);
       var id_photo = this.id;
       $.ajax({url: "include/addTime.php?id="+this.id, success: function(result){
        //console.log(result);
            if(result != 'error' && result != '0' && result != '1')
            {
                //tutto ok
                $('#counter_'+id_photo).effect( "shake" );
                $('#counter_'+id_photo).attr('title',result);
                $('#counter_'+id_photo).attr('data-countdown',result);                
                //update();
                //console.log('#counter_'+id_photo);
            }
            else
            {
                $('.esagono-abs').effect( "shake" );   
                $('#'+id_photo).attr('color','red');  //.css('color: rgb(255, 0, 0);');
                //console.log('ERRORE');             
                //console.log('id_photo'+id_photo);
                if(result == '0')
                {
                    myAlert("Potrai rivotare la foto tra 24 ore");
                }
                else if(result == '1')
                {
                    myAlert("Non puoi votare la tua stessa foto!");
                }
                else
                {
                    myAlert("Ops! qualcosa non va, riprova più tardi!");
                }
            }
        }});
       
    });
	/* click su + ore, rotazione img zoom a scomparsa*/
		
	/* inizio a seguire un utente *//*
    $('.add_timing').click(function(){
	   //$('.search-hover').animate({rotate: '360deg', scale: '0'}, 400);
       var id_user = this.id;
       $.ajax({url: "include/addTiming.php?id="+this.id, success: function(result){
            if(result != 'error' && result != '0' && result != '1')
            {
                //tutto ok
                //$('#counter_'+id_photo).effect( "shake" );
                //$('#counter_'+id_photo).attr('title',result);
                console.log('#counter_'+id_user);
            }
            else
            {                
                $('.esagono-abs').effect( "shake" );     
                console.log('ERRORE');           
            }
        }});
       
    });*/
	/*  inizio a seguire un utente */
		
		
		 /* show and hide box cerca, aggiungi foto e dettaglio immagine*/
   $('#search').click(function(){
				$('.container-cerca').show();
		 });
   $('.search-hover').click(function(){
				$('.container-dett-img').show();
				$('.container-dett-img').load('photo.php?id='+this.alt);
		 });
   $('.notify_link').click(function(){                
				$('.container-dett-img').show();
				$('.container-dett-img').load(this.href);
                return false;
		 });
   
		 /* show and hide box cerca, aggiungi foto e dettaglio immagine*/
	
    /* AJAX RICERCA */
   $('.box-parole-cercate').click(function(){
    
    var msg = $(this).text();
    msg = msg.replace('#','');
    $("#search_text").val( $.trim(msg) );
    DoSearch();
   });
   
   $('#tab_user').click(function(){
        $("#photo_search").hide();
        $("#user_search").show();
        var txt = $('#tab_user').html();
        $('#tab_user').html('<span>'+txt+'</span>');
        var old = $('#tab_photo').html();
        $('#tab_photo').html(old.replace('<span>','').replace('</span>','')); 
   
   });
    
   $('#tab_photo').click(function(){
        $("#user_search").hide();
        $("#photo_search").show();
        var txt = $('#tab_photo').html();
        $('#tab_photo').html('<span>'+txt+'</span>');  
        var old = $('#tab_user').html();
        $('#tab_user').html(old.replace('<span>','').replace('</span>','')); 
    });
    var MIN_LENGTH = 3;
    function DoSearch()
    {
        var keyword = $("#search_text").val();
        
        //console.log('inizio ricerca con la parola: '+keyword);
        
		if (keyword.length >= MIN_LENGTH) {
			$.get( "include/search.php", { text: keyword } )
			  .done(function( data ) {
			    //console.log(data);
                //console.log(jQuery.parseJSON(data).esito );
				$('#user_search, #photo_search').html('');
                if(jQuery.parseJSON(data).esito == '1')
                {
    				var results = jQuery.parseJSON(data).data;
                    var total_src = 0;
    			    //console.log(results);
                    $(results).each(function(key, value) {
    					//$('#results').append('<div class="item">' + value + '</div>');
                        
                        //console.log(value);
                        
                        if(value.type == 'LapsicPhoto')
                        {
                            $('#tab_photo').html('photo('+value.count+')');
                            if(value.count > 0)
                            {
                                $("#photo_search").show();
                                $("#user_search").hide();
                                var txt = $('#tab_photo').html();
                                $('#tab_photo').html('<span>'+txt+'</span>');  
                                var old = $('#tab_user').html();
                                $('#tab_user').html(old.replace('<span>','').replace('</span>','')); 
                            }
                            total_src = total_src + value.count;
                            $(value.data).each(function(key2, value2) {
                                $('#photo_search').html('<div class="item" style="width: '+value2.width+'px;height: '+value2.height+'px;">'+
                                                            '<img class="img-zoom lazy" data-src="images/isotope/'+value2.source_path+'" border="0" alt="" width="'+value2.width+'" height="'+value2.height+'" style="background-color: #'+value2.average_colour+'" />'+
                                                            '<img class="search-hover"  src="images/zoom-img.png" width="73" height="83" alt="'+value2.id+'"/>'+
                                                            '<div class="box-date-hour" style="display: block;">'+
                                                                '<div class="date-item" id="counter_'+value2.id+'" title="'+value2.time_left+'">'+
                                                                    '112d:04h'+
                                                                '</div>'+
                                                                '<div class="add-hour" id="'+value2.id+'">'+
                                                                    '+24 h'+
                                                                '</div>'+
                                                            '</div>'+
                                                            '<div class="name-profile-photo" style="display: block;">'+
                                                                '<a class="href_nn" style="color: white;" href="profile.php?id='+value2.id_owner+'">'+
                                                                    ''+value2.user+''+
                                                                    '<span>#'+value2.rank+'</span>'+
                                                                '</a>'+
                                                            '</div>'+
                                                        '</div>');
                            })
                        }
                        else if(value.type == 'LapsicUser')
                        {                            
                            $('#tab_user').html('persone('+value.count+')');
                            total_src = total_src + value.count;
                            $(value.data).each(function(key2, value2) {
                                $('#user_search').html('<div class="single-box-profili">'+
                                                          	'<div class="mini-ico-profilo">'+
                                                            	'<img src="images/maschera-esagono.png" class="maschera-esagono" alt=""/>'+
                                                            	'<img src="media/avatar/'+value2.img+'" width="27" height="31" alt=""/>'+
                                                            '</div>'+
                                                            '<div class="box-dett-profilo-utente">'+
                                                            		'<div class="dett-utente">'+
                                                                '<p><strong>'+value2.nickname+'</strong></p>'+
                                                                '<p>#327</p>'+
                                                              '</div>'+
                                                              '<div class=" timing-profile">'+
                                                                '<p>Timing  |  <strong>'+value2.timing+'</strong></p>'+
                                                                '<p>Timers  |  <strong>'+value2.timers+'</strong></p>'+
                                                              '</div>'+
                                                              '</div>'+
                                                            '</div>');
                            })
                        }
    				})
                    /*
    				$(results).each(function(key, value) {
    					$('#results').append('<div class="item">' + value + '</div>');
    				})
    
    			    $('.item').click(function() {
    			    	var text = $(this).html();
    			    	$('#keyword').val(text);
    			    })*/
                }
                if(total_src == 0)
                {
				    $('#user_search, #photo_search').html('Nessun risultato trovato con la ricerca effettuata');
                }
			  })
              .error(function( data ) {
                console.log('errore');
			    console.log(data);
                
                });
		} 
        else 
        {
			$('#results').html('');
		}
    }
    
	$("#search_text").keyup(function() {
		DoSearch()
	});
    
    $('.box-bottom-cose-lapsic').click(function(){
    
    });
        
    /* AJAX RICERCA */
    
	/*------- GESTIONE add photo and scroll top ----------*/
    var sec_cont = $(".second-container");
    if(sec_cont !== undefined && sec_cont.offset() !== undefined)
    {
    	var pos_header=sec_cont.offset().top + 60 ;
        $(document).scroll(function(){
    		
    				if($(document).scrollTop()>=pos_header)
    				{
    					$(".box-scroll-and-add").show(500);
    				}
    				else
    				{
    					$(".box-scroll-and-add").hide(500);
    				}
    			
    		});
     }    
	/*------- GESTIONE add photo and scroll top ----------*/
    	
    /* GESTIONE NOTIFICHE */
        $('#notify_icon').click(function() {
            $('.tendina-notifiche').toggle( 200, function() {
                // Animation complete.
            });
        });
        $('#user_icon').click(function() {
            $('.tendina-profilo-log-out').toggle( 200, function() {
                // Animation complete.
            });
        });
        
    /* FINE GESTIONE NOTIFICHE */
	
	
	});
// FINE DOCUMENT READY

/* CONTROLLO SE C'è STATO UN CAMBIAMENTO NEI RANK */

function checkRank()
{
   $.ajax({url: "include/check_rank.php?mode="+last_upd, success: function(result){
        if(result.esito == '1')
        {
            last_upd = result.data;
            //qualcosa è cambiato e devo aggiornare
            console.log('aggiorno lista');
        }
        else
        {  
            console.log(last_upd);           
        }
    }});
}

/* GESTIONE APERTURA CHIUSURA BOX Generico*/
function tog_box(id)
{
	if ($('#'+id).css('display')==('block'))
		{
			$('.').slideUp(800);
			$('#'+id).slideUp(800);
			
		}
		else
		{
			$('.').slideUp(800);
			$('#'+id).slideDown(800);
		}
}
/* GESTIONE APERTURA CHIUSURA BOX Generico*/