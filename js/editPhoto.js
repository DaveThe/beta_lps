$(document).ready(function() {
    var num_photo = $( "div[id^='box_']" ).length;
    var response_share = false;
    $('.operations_new').click(function(){
        var action = $(this).attr("value");
        var box_id = 'box_'+$(this).attr("ids");
        var data_id = 'data_'+$(this).attr("ids");
        
        if(action === 'disabilita')
        {
            
            if($('#'+data_id+' textarea[name=name]').val().length < 3)
            {
                $('#'+data_id+' textarea[name=name]').effect( "shake" );
                $('#'+data_id+'_title').css( "border", "solid 2px red" );
                //$('#'+data_id+' textarea[name=name]').css("border", "2px solid red;");
                return;
            }
            
            $.ajax({
                method: "POST",
                url: "include/operations_photo.php",
                dataType: "json",
                data: { 
                        act                         : 'save_img',
                        description                 : $('#'+data_id+' textarea[name=description]').val(), //$(this).attr("description"),
                        name                        : $('#'+data_id+' textarea[name=name]').val(), //$(this).attr("title"),
                        status                      : '0',
                        extra_photo_average_colour  : $('#'+data_id+' input[name=average_colour]').val(),
                        extra_photo_Lat             : $('#'+data_id+' input[name=extra_photo_lat]').val(),
                        extra_photo_Lng             : $('#'+data_id+' input[name=extra_photo_lng]').val(),
                        avatar                      : $('#'+data_id+' input[name=photo_name]').val(),
                        extra_photo                 : $('#'+data_id+' input[name=photo_extra_info]').val(),
                        id_photo                    : $(this).attr("ids")
                       }
            })
            .done(function( dati ) {
                //console.log( dati );
                //console.log( JSON.stringify(dati) );
                if(dati == "OK")
                {                       
                    $('#'+box_id).fadeTo( "slow", 0.33 );
                    $('#'+box_id).children().prop('disabled',true);
                    $('#'+box_id).hide(500).delay(2000).queue(function() { $(this).remove(); });
                    //$('#'+box_id).remove();
                    num_photo--;// = ($( "div[id^='box_']" ).length)-1;
                    console.log( num_photo );
                    if ( num_photo > 0 ) {             
                    }
                    else
                    {
                        document.location.href = 'profile.php';
                    }
                }
            })
            .fail(function(xhr, status, error) {
              console.log( "error" );
              console.log( xhr );
              var err = eval("(" + xhr.responseText + ")");
              console.log(err.Message);
            })
            .always(function() {
                console.log( "complete" );
            });            
        }
        else if(action === 'elimina')
        {
            $('#'+box_id).fadeTo( "slow", 0.33 );
            $('#'+box_id).children().prop('disabled',true);
            $('#'+box_id).hide(500).delay(2000).queue(function() { $(this).remove(); });
            num_photo--;
            console.log( num_photo );
            if ( num_photo > 0 ) {             
            }
            else
            {
                document.location.href = 'profile.php';
            }
        }
    });
    
    //console.log( num_photo );
    
    $('.operations').click(function()
    {
        console.log( 'click operation' );
        console.log( $(this).attr("value") );
        var action = $(this).attr("value");
        var data_id = 'data_'+$(this).attr("ids");
        var d_id = $(this).attr("ids");
        var box_id = 'box_'+$(this).attr("ids");
        console.log('id - '+d_id);
        console.log($(this).id);
        $('#save_'+d_id).hide();//.attr("disabled", true);$(selector).is(':checked')
                    var enabl = $('#share_'+d_id).is(':checked'); //.val();
                    console.log('share? '+enabl); //return;
        if( (action === 'save_img' || action === 'aggiorna') && $('#'+data_id+' textarea[name=name]').val().length < 3)
        {
            
            $('#'+data_id+' textarea[name=name]').effect( "shake" );
            $('#'+data_id+'_title').css( "border", "solid 2px red" );
            
            $('#'+data_id+' textarea[name=description]').effect( "shake" );
            $('#'+data_id+'_desc').css( "border", "solid 2px red" );
            
            $('#save_'+d_id).show();
            
            //$('#'+data_id+' textarea[name=name]').css("border", "2px solid red;");
            return;
        }
        
        $.ajax({
            method: "POST",
            url: "include/operations_photo.php",
            dataType: "json",
            data: { 
                    act                         : $(this).attr("value"),
                    description                 : $('#'+data_id+' textarea[name=description]').val(), //$(this).attr("description"),
                    name                        : $('#'+data_id+' textarea[name=name]').val(), //$(this).attr("title"),
                    status                      : $('#'+data_id+' input[name=status]').val(),
                    extra_photo_average_colour  : $('#'+data_id+' input[name=average_colour]').val(),
                    extra_photo_Lat             : $('#'+data_id+' input[name=extra_photo_lat]').val(),
                    extra_photo_Lng             : $('#'+data_id+' input[name=extra_photo_lng]').val(),
                    avatar                      : $('#'+data_id+' input[name=photo_name]').val(),
                    extra_photo                 : $('#'+data_id+' input[name=photo_extra_info]').val(),
                    id_photo                    : $(this).attr("ids")
                    //photo_id: $('#'+data_id+' input[name=status]').val()$(this).attr("id")
                   }
        })
        .done(function( dati ) {
            console.log( dati );
            console.log( JSON.stringify(dati) );
            var arrDati = dati;//jQuery.parseJSON(dati);//JSON.stringify(dati);
            console.log( arrDati );
            if(arrDati.status == "OK")
            {   console.log(action + '=== abilita');
                if(action === 'abilita')
                {
                    location.reload();
                    /*
                    if($('#'+data_id+' input[name=status]').val() == '1')
                    {
                        $('#'+box_id).css({ opacity: 1 });
                    }
                    else
                    {                        
                        $('#'+box_id).css({ opacity: 0.5 });
                    }
                    */
                }
                else
                {
                    var enabl = $('#share_'+d_id).is(':checked');//$('#share_'.d_id).val();
                    console.log('share? '+enabl); //return;
                    if ((action === 'save_img' || action === 'aggiorna') && enabl)
                    {
                        console.log('share'); //return;
						num_photo--;// = ($( "div[id^='box_']" ).length)-1;
						console.log( num_photo );
						if ( num_photo > 0 ) {    
							shareFBEdit('http://lapsic.it/snapshot.php?id='+arrDati.id_photo,'nored');         
						}
						else
						{
							shareFBEdit('http://lapsic.it/snapshot.php?id='+arrDati.id_photo,'red');
						}
                        
                    }
					else
					{
						num_photo--;// = ($( "div[id^='box_']" ).length)-1;
						console.log( num_photo );
						if ( num_photo > 0 ) {             
						}
						else
						{
							document.location.href = 'profile.php';
						}
					}
                    $('#'+box_id).fadeTo( "slow", 0.33 );
                    $('#'+box_id).children().prop('disabled',true);
                    $('#'+box_id).hide(500).delay(2000).queue(function() { $(this).remove(); });
                    //$('#'+box_id).remove();
                    // = ($( "div[id^='box_']" ).length)-1;
  
                }
            }
        })
        .fail(function(xhr, status, error) {
          console.log( "error" );
          console.log( xhr );
          var err = eval("(" + xhr.responseText + ")");
          console.log(err.Message);
          $('#save_'+d_id).show();
        })
        .always(function() {
            console.log( "complete" );
        });
        
    });
    /*
    $('textarea[name=description]').change(function() {
        var regex = /#+([a-zA-Z0-9_]+)/g; 
        var input = $(this).val(); 
        if(regex.test(input)) {
          var matches = input.match(regex);
          for(var match in matches) {
            //matches[match].css('color', 'red');
            $(this).html($(this).val().replace(matches[match],'<span style="color:blue;">'+matches[match]+'</span>'));
            //alert(matches[match]);
          } 
        } else {
          alert("No matches found!");
        }
    });
    */
        
    $(".single_2").fancybox({
        openEffect	: 'elastic',
    	closeEffect	: 'elastic',
    
    	helpers : {
    		title : {
    			type : 'inside'
    		}
    	}
      });
      
});
function shareFBEdit(href,red)
{
	FB.ui({
  method: 'share',
  href: href,
}, function(response){
	console.log(response);
		if(red==='red')
		{
			document.location.href = "profile.php";	
		}
	});
}