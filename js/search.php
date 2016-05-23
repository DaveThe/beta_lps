<script type="text/javascript">
    
    var MIN_LENGTH = 3;
    /* AJAX RICERCA */
    function DoSearch(keyword)
    {
        //var keyword = $("#search_text").val();
        
        //console.log('inizio ricerca con la parola: '+keyword);
        
		if (keyword.length >= MIN_LENGTH) {
			$.get( "include/search.php", { text: keyword } )
			  .done(function( data ) {
			    //console.log(data.toString());
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
                                $('#user_search').html('');
                                $('#photo_search').html('');
                                $("#photo_search").show();
                                $("#user_search").hide();
                                var txt = $('#tab_photo').html();
                                $('#tab_photo').html('<span>'+txt+'</span>');  
                                var old = $('#tab_user').html();
                                $('#tab_user').html(old.replace('<span>','').replace('</span>','')); 
                            }
                            total_src = total_src + value.count;
                            $(value.data).each(function(key2, value2) {
                                var precedente = $('#photo_search').html();
                                $('#photo_search').html(value2+precedente);    
                                                        /*
                        		$grid = $('.iso-container-photo');
                                $grid.isotope({
                            			itemSelector:'.item',
                            			layoutMode:'masonry',
                            			transformsEnabled: false,
                            			masonry:{columnWidth:200, gutter:15}
                            	 });    */                      
                            })
                        }
                        else if(value.type == 'LapsicUser')
                        {                            
                            $('#tab_user').html('persone('+value.count+')');
                            total_src = total_src + value.count;
                            $(value.data).each(function(key2, value2) {
                                var precedente = $('#photo_search').html();
                                $('#user_search').html(value2+precedente);
                                /*                        
                                $grid2 = $('.iso-container-user');
                                $grid2.isotope({
                            			itemSelector: '.box-altri-profili',
                            			layoutMode:'masonry',
                            			transformsEnabled: false,
                            			masonry:{columnWidth:300, gutter:15}
                            	 });
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
    
$(document).ready(function() {
        $('#photo_search').change(function() {
            $('.add-hour').click(function()
            {
                console.log('asdsad');
                AddTime(this);
            });
         });   
       $('.box-parole-cercate').click(function(){
        console.log('clicca ricerca');
        var msg = $(this).text();
        /*
        if(msg >= MIN_LENGTH)
        {*/
            msg = msg.replace('#','');
            $("#search_text").val( $.trim(msg) );
            DoSearch($.trim(msg));
        /*}*/
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
        
    	$("#search_text").keyup(function() {
    	   
            console.log('ho scritto qualcosa nel cerca');
    		if($('#search_text').val()!='') 
            {
            var msg = $('#search_text').val();
            DoSearch($.trim(msg));
            }
    	});
        
        if($('#search_text').val()!='') 
        {         
            console.log('click cerca');
            var msg = $('#search_text').val();
            DoSearch($.trim(msg));
        }
        
        
        $('.box-bottom-cose-lapsic').click(function(){
        
        });
     
    });     
      
    /* AJAX RICERCA */
</script>