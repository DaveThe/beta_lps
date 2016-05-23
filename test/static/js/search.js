
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
			    console.log(data);
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
                                $('#photo_search').html(value2);
                                /*
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
                                */
                            })
                        }
                        else if(value.type == 'LapsicUser')
                        {                            
                            $('#tab_user').html('persone('+value.count+')');
                            total_src = total_src + value.count;
                            $(value.data).each(function(key2, value2) {
                                $('#user_search').html(value2);
                                /*
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
                                */
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
                    update();
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
		DoSearch();
	});
    
    if($('#search_text').val()!='') { DoSearch(); }
    
    
    $('.box-bottom-cose-lapsic').click(function(){
    
    });
        
    /* AJAX RICERCA */
