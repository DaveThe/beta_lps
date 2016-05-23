//questa funzione fa un resize del popup in base all'altezza del contenuto dell'iframe caricato...
//TO DO controllare su safari
function resizeMagnific()
{
	console.log('before iframe is added to DOM');
	//controllo se l'iframe si è caricato
    this.content.find('iframe').on('load', function() {
		//aggiungo l'id all' iframe
	$('iframe').attr('id','iframe');	
	//recupero la sua altezza e la metto fissa all'iframe
	document.getElementById('iframe').style.height = 
    document.getElementById('iframe').contentWindow.document.body.offsetHeight + 'px';		
      console.log('iframe loaded');
	  console.log($('iframe'));
    });
}
     
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
                
                if(window.location.pathname== "/photo.php")
                {                    
                    $(this).html('<img src="images/orologio.png" width="16" height="16" alt=""/> '+event.strftime(format));                    
                }
                else
                {
                    $(this).html(event.strftime(format));
                }
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
    
    /****  GESTIONE MAGNIFIC POPUP *****/
    
    $('#popup_term').magnificPopup({
        type: 'iframe',
        closeBtnInside:true
    });	
    $('.add-photo, .box-cerca, .dettaglio-photo, .register').magnificPopup({
		type: 'iframe',
		alignTop: true,
        showCloseBtn: false,
		callbacks: {
            close: function(){
                //var didConfirm = confirm("Are you sure?");
                /*
                if(didConfirm ==false){
                    return false;
                }
                */
                var magnificPopup = $.magnificPopup.instance,
                cur = magnificPopup.st.el;
                //console.log(cur.attr('href'));
                //console.log(this);
                
                if(cur.attr('href') == "/register.php"){ parent.location.reload(true);  }
            },
			//callback che prima di appendere l'iframe chiama una funzione
        	beforeAppend: resizeMagnific
    	}
        
		//overflowY: 'scroll' // as we know that popup content is tall we set scroll overflow by default to avoid jump
	});	
    /*	
    $(".add-photo, .box-cerca, .dettaglio-photo, .register").magnificPopup({
        type: 'iframe',
        showCloseBtn: false,
        //type: 'ajax',
        alignTop: false,
        overflowY: 'scroll',
        fixedContentPos: true, mainClass: 'mfp-no-margins mfp-with-zoom',
               
        //closeBtnInside:true
    });	*/		              
    
    
    /****  GESTIONE MAGNIFIC POPUP *****/
                
    /****  GESTIONE FANCYBOX   ****/
	//console.log($(window).width());
	//console.log($(window).height());
    /*
	$(".add-photo, .box-cerca, .dettaglio-photo, .register").fancybox({
		type        : 'iframe',
        scrolling   : 'no',
        helpers: {
            overlay: {
                locked: true         
            }
        },
		autoSize    :  false,
		padding     : '0', //'1',
		margin      : '0', //'2',
		autoScale   : false,
        aspectRatio : false,
        width       : '100%',
        height      : '100%',
		closeBtn    : false,
		iframe : {
		   scrolling : 'no'
		},
        afterClose: function(){
            if(this.href == "/register.php"){ parent.location.reload(true);  }
            //console.log(this.href); // == "/register.php")
        } 
                      
	 });
        */
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
    
	$('.button-chiudi').click(function()
    {    	
        try
        {
            parent.jQuery.fancybox.close();
        }
        catch(err)
        {
            parent.$('#fancybox-overlay').hide();
            parent.$('#fancybox-wrap').hide();
        }
    });
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
       //var id_div_photo = id_photo.join("_");
       var id_image = this.id.split("_").pop();
       var time     = id_photo.slice(0, id_photo.indexOf("_"));
       //console.log(id_photo);
       
       console.log(id_image);
       console.log(id_photo.slice(0, id_photo.indexOf("_")));
	   $('#'+id_photo).animate({rotate: '360deg', scale: '0'}, 400);
	   $('#'+id_photo).animate({rotate: '360deg', scale: '1'}, 400);
       //console.log($('#'+id_photo).text().trim());
       $.ajax({url: "include/addTime.php?id="+id_image+"&time="+time, success: function(result){
        //console.log(result);
        var results = jQuery.parseJSON(result)
            if(results.esito != '1')
            {
                //tutto ok
                $('#counter_'+id_photo).effect( "shake" );
                $('#counter_'+id_photo).countdown('stop');
                $('#counter_'+id_photo).countdown(results.date);
                $('#counter_'+id_photo).attr('title',results.date);
                $('#counter_'+id_photo).attr('data-countdown',results.date);
                $('#counter_'+id_photo).countdown('start'); 
                $('#'+id_photo).effect( "shake" );               
                //update();
                //console.log('#counter_'+id_photo);
            }
            else
            {
                //$('.esagono-abs').effect( "shake" );   
                $('#'+id_photo).effect( "shake" );
                $('.piu-ore').attr('color','red');  //.css('color: rgb(255, 0, 0);');
                //console.log('ERRORE');             
                //console.log('id_photo'+id_photo);
                if(results.error == '0')
                {
                    myAlert("Potrai rivotare la foto tra 24 ore");
                }
                else if(results.error == '1')
                {
                    myAlert("Non puoi votare la tua stessa foto!");
                }
                else if(results.error == '2')
                {
                    myAlert("Devi prima accedere a Lapsic!");
                }
                else if(results.error == 'generic')
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